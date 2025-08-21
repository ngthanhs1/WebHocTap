<?php

namespace App\Http\Controllers;

use App\Models\{CauHoi, DapAn};
use Illuminate\Http\Request;

class DapAnController extends Controller
{
    public function index(CauHoi $cau_hoi){
        $dapAns = $cau_hoi->dapAns()->latest()->paginate(20);
        return view('dapan.index', compact('cau_hoi','dapAns'));
    }
    public function create(CauHoi $cau_hoi){ return view('dapan.create', compact('cau_hoi')); }
    public function store(Request $r, CauHoi $cau_hoi){
        $data = $r->validate(['noi_dung'=>'required|string','dung'=>'required|boolean']);
        $opt = $cau_hoi->dapAns()->create($data);
        if (!$cau_hoi->dapAns()->where('dung',true)->exists()) $opt->update(['dung'=>true]);
        return redirect()->route('cau-hoi.dap-an.index',$cau_hoi)->with('ok','Đã thêm đáp án');
    }
    public function edit(CauHoi $cau_hoi, DapAn $dap_an){ return view('dapan.edit', compact('cau_hoi','dap_an')); }
    public function update(Request $r, CauHoi $cau_hoi, DapAn $dap_an){
        $data = $r->validate(['noi_dung'=>'required|string','dung'=>'required|boolean']);
        $dap_an->update($data);
        if (!$cau_hoi->dapAns()->where('dung',true)->exists()) $dap_an->update(['dung'=>true]);
        return redirect()->route('cau-hoi.dap-an.index',$cau_hoi)->with('ok','Đã cập nhật');
    }
    public function destroy(CauHoi $cau_hoi, DapAn $dap_an){
        $dap_an->delete();
        if (!$cau_hoi->dapAns()->where('dung',true)->exists()){
            $last = $cau_hoi->dapAns()->latest('id')->first();
            if ($last) $last->update(['dung'=>true]);
        }
        return back()->with('ok','Đã xóa');
    }
}
