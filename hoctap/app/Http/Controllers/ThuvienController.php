<?php

namespace App\Http\Controllers;

use App\Models\{DeThi, MonHoc};
use Illuminate\Http\Request;

class ThuVienController extends Controller
{
    public function index(Request $r){
        $monHocs = MonHoc::orderBy('ten')->get();
        $deThis  = DeThi::with('monHoc')->cuaToi()->search($r->q)->filter($r->all())
                    ->paginate(12)->withQueryString();

        $countAll   = DeThi::cuaToi()->count();
        $countPub   = DeThi::cuaToi()->where('cong_khai',1)->count();
        $countDraft = DeThi::cuaToi()->where('cong_khai',0)->count();

        return view('library.index', compact('monHocs','deThis','countAll','countPub','countDraft'));
    }

    public function bulk(Request $r){
        $ids = array_filter(array_map('intval', $r->ids ?? []));
        $q = DeThi::where('user_id', auth()->id())->whereIn('id', $ids);
        if($r->action==='publish')   $q->update(['cong_khai'=>1]);
        if($r->action==='unpublish') $q->update(['cong_khai'=>0]);
        if($r->action==='delete')    $q->delete();
        return back()->with('ok','Đã thực hiện');
    }
}
