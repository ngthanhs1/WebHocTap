<?php

namespace App\Http\Controllers;

use App\Models\{DeThi, CauHoi, DapAn};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CauHoiManageController extends Controller
{
    public function create(DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        return view('cauhoi.create', compact('de_thi'));
    }

    public function store(Request $r, DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        $d = $r->validate([
            'noi_dung'   => 'required|string',
            'giai_thich' => 'nullable|string',
            'do_kho'     => 'required|in:easy,medium,hard',
            'options'    => 'required|array|min:2|max:6',
            'options.*.noi_dung' => 'required|string',
            'options.*.dung'     => 'required|boolean',
        ]);

        DB::transaction(function() use($de_thi,$d){
            $q = $de_thi->cauHois()->create([
                'noi_dung'=>$d['noi_dung'],
                'giai_thich'=>$d['giai_thich']??null,
                'do_kho'=>$d['do_kho']
            ]);
            $q->dapAns()->createMany($d['options']);
            if(!$q->dapAns()->where('dung',1)->exists()){
                throw new \RuntimeException('Cần ít nhất 1 đáp án đúng');
            }
        });

        return redirect()->route('de-thi.show',$de_thi)->with('ok','Đã thêm câu hỏi');
    }

    public function edit(DeThi $de_thi, CauHoi $cau_hoi){
        abort_unless($de_thi->user_id === auth()->id() && $cau_hoi->de_thi_id==$de_thi->id, 403);
        $cau_hoi->load('dapAns');
        return view('cauhoi.edit', compact('de_thi','cau_hoi'));
    }

    public function update(Request $r, DeThi $de_thi, CauHoi $cau_hoi){
        abort_unless($de_thi->user_id === auth()->id() && $cau_hoi->de_thi_id==$de_thi->id, 403);
        $d = $r->validate([
            'noi_dung'=>'required|string',
            'giai_thich'=>'nullable|string',
            'do_kho' => 'required|in:easy,medium,hard',

            'option_id' => 'array',
            'option_noi_dung' => 'required|array|min:2',
            'option_noi_dung.*' => 'required|string',
            'option_dung' => 'array', // checkbox
        ]);

        DB::transaction(function() use($cau_hoi,$d){
            $cau_hoi->update([
                'noi_dung'=>$d['noi_dung'],
                'giai_thich'=>$d['giai_thich']??null,
                'do_kho'=>$d['do_kho'],
            ]);

            $ids=[]; $rawIds=$d['option_id']??[]; $texts=$d['option_noi_dung']; $correct=$d['option_dung']??[];
            foreach($texts as $i=>$text){
                $id = $rawIds[$i] ?? null;
                $ok = array_key_exists($i,$correct);
                if($id){
                    DapAn::where('id',$id)->where('cau_hoi_id',$cau_hoi->id)->update(['noi_dung'=>$text,'dung'=>$ok]);
                    $ids[] = (int)$id;
                }else{
                    $opt = $cau_hoi->dapAns()->create(['noi_dung'=>$text,'dung'=>$ok]);
                    $ids[] = $opt->id;
                }
            }
            $cau_hoi->dapAns()->whereNotIn('id',$ids)->delete();

            if(!$cau_hoi->dapAns()->where('dung',1)->exists()){
                $first = $cau_hoi->dapAns()->first();
                if($first) $first->update(['dung'=>1]);
            }
        });

        return redirect()->route('de-thi.show',$de_thi)->with('ok','Đã cập nhật câu hỏi');
    }

    public function destroy(DeThi $de_thi, CauHoi $cau_hoi){
        abort_unless($de_thi->user_id === auth()->id() && $cau_hoi->de_thi_id==$de_thi->id, 403);
        $cau_hoi->delete();
        return back()->with('ok','Đã xóa');
    }
}
