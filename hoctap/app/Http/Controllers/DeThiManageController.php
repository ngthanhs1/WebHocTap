<?php

namespace App\Http\Controllers;

use App\Models\DeThi;
use Illuminate\Http\Request;

class DeThiManageController extends Controller
{
    public function show(DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        $de_thi->load('monHoc','cauHois.dapAns');
        return view('dethi.show', compact('de_thi'));
    }

    public function update(Request $r, DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        $data = $r->validate([
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'tieu_de'    => 'required|string|max:255',
            'mo_ta'      => 'nullable|string',
            'cong_khai'  => 'sometimes|boolean',
        ]);
        $de_thi->update([
            'mon_hoc_id' => $data['mon_hoc_id'],
            'tieu_de'    => $data['tieu_de'],
            'mo_ta'      => $data['mo_ta'] ?? null,
            'cong_khai'  => array_key_exists('cong_khai',$data) ? (bool)$data['cong_khai'] : $de_thi->cong_khai,
        ]);
        return redirect()->route('library.index')->with('ok','Đã cập nhật');
    }

    public function publish(DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        $de_thi->update(['cong_khai'=>1]);
        return redirect()->route('library.index')->with('ok','Đã xuất bản');
    }

    public function unpublish(DeThi $de_thi){
        abort_unless($de_thi->user_id === auth()->id(), 403);
        $de_thi->update(['cong_khai'=>0]);
        return redirect()->route('library.index')->with('ok','Đã chuyển nháp');
    }
}
