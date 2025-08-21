<?php

namespace App\Http\Controllers;

use App\Models\{DeThi, MonHoc};
use Illuminate\Http\Request;

class DeThiController extends Controller
{
    // Catalog công khai
    public function catalog(Request $r){
        $monHocs = MonHoc::orderBy('ten')->get();
        $deThis  = DeThi::congKhai()->with('monHoc')->filter($r->all())->latest()->paginate(12);
        return view('catalog', compact('monHocs','deThis'));
    }

    // Làm bài & nộp bài
    public function lamBai(DeThi $de_thi){
        $de_thi->load('cauHois.dapAns');
        abort_unless($de_thi->cong_khai, 404);
        return view('play', compact('de_thi'));
    }
    public function nopBai(Request $r, DeThi $de_thi){
        $de_thi->load('cauHois.dapAns');
        abort_unless($de_thi->cong_khai, 404);

        $answers = $r->input('answers', []); // [cau_hoi_id => dap_an_id]
        $total = $de_thi->cauHois->count(); $correct = 0;
        foreach ($de_thi->cauHois as $q){
            $chosen = $answers[$q->id] ?? null;
            if(!$chosen) continue;
            $opt = $q->dapAns->firstWhere('id',(int)$chosen);
            if ($opt && $opt->dung) $correct++;
        }
        $score = $total ? round($correct*100/$total,2) : 0;
        return view('result', compact('de_thi','answers','score','correct','total'));
    }

    // Admin CRUD
    public function index(){ $items = DeThi::with('monHoc')->latest()->paginate(12); return view('dethi.index', compact('items')); }
    public function create(){ $monHocs = MonHoc::orderBy('ten')->get(); return view('dethi.create', compact('monHocs')); }
    public function store(Request $r){
        $data = $r->validate([
            'mon_hoc_id'=>'required|exists:mon_hocs,id',
            'tieu_de'=>'required|string|max:255',
            'mo_ta'=>'nullable|string',
            'cong_khai'=>'sometimes|boolean',
        ]);
        DeThi::create($data); return redirect()->route('de-thi.index')->with('ok','Tạo đề thi thành công');
    }
    public function show(DeThi $de_thi){ $de_thi->load('monHoc','cauHois.dapAns'); return view('dethi.show', compact('de_thi')); }
    public function edit(DeThi $de_thi){ $monHocs = MonHoc::orderBy('ten')->get(); return view('dethi.edit', compact('de_thi','monHocs')); }
    public function update(Request $r, DeThi $de_thi){
        $data = $r->validate([
            'mon_hoc_id'=>'required|exists:mon_hocs,id',
            'tieu_de'=>'required|string|max:255',
            'mo_ta'=>'nullable|string',
            'cong_khai'=>'required|boolean',
        ]);
        $de_thi->update($data); return redirect()->route('de-thi.index')->with('ok','Cập nhật xong');
    }
    public function destroy(DeThi $de_thi){ $de_thi->delete(); return back()->with('ok','Đã xóa'); }
}
