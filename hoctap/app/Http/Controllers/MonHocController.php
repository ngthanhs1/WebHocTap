<?php

namespace App\Http\Controllers;

use App\Models\MonHoc;
use Illuminate\Http\Request;

class MonHocController extends Controller
{
    public function index(){ $items = MonHoc::latest()->paginate(12); return view('monhoc.index', compact('items')); }
    public function create(){ return view('monhoc.create'); }
    public function store(Request $r){
        $data = $r->validate(['ten'=>'required|string|max:120|unique:mon_hocs,ten','mo_ta'=>'nullable|string']);
        MonHoc::create($data); return redirect()->route('mon-hoc.index')->with('ok','Tạo thành công');
    }
    public function show(MonHoc $mon_hoc){ $mon_hoc->load('deThis'); return view('monhoc.show', compact('mon_hoc')); }
    public function edit(MonHoc $mon_hoc){ return view('monhoc.edit', compact('mon_hoc')); }
    public function update(Request $r, MonHoc $mon_hoc){
        $data = $r->validate(['ten'=>"required|string|max:120|unique:mon_hocs,ten,{$mon_hoc->id}",'mo_ta'=>'nullable|string']);
        $mon_hoc->update($data); return redirect()->route('mon-hoc.index')->with('ok','Cập nhật xong');
    }
    public function destroy(MonHoc $mon_hoc){ $mon_hoc->delete(); return back()->with('ok','Đã xóa'); }
}
