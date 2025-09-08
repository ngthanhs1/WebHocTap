<?php

namespace App\Http\Controllers;

use App\Models\{DeThi, MonHoc};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeThiWizardController extends Controller
{
    public function create(){
        $monHocs = MonHoc::orderBy('ten')->get();
        return view('dethi.wizard', compact('monHocs'));
    }

    public function store(Request $r){
        $data = $r->validate([
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'tieu_de'    => 'required|string|max:255',
            'mo_ta'      => 'nullable|string',
            'cong_khai'  => 'sometimes|boolean',

            'questions'  => 'required|array|min:1',
            'questions.*.noi_dung'   => 'required|string',
            'questions.*.giai_thich' => 'nullable|string',
            'questions.*.do_kho'     => 'required|in:easy,medium,hard',
            'questions.*.options'    => 'required|array|min:2|max:6',
            'questions.*.options.*.noi_dung' => 'required|string',
            'questions.*.options.*.dung'     => 'required|boolean',
        ]);

        DB::transaction(function() use($data){
            $quiz = DeThi::create([
                'user_id'    => auth()->id(),
                'mon_hoc_id' => $data['mon_hoc_id'],
                'tieu_de'    => $data['tieu_de'],
                'mo_ta'      => $data['mo_ta'] ?? null,
                'cong_khai'  => (bool)($data['cong_khai'] ?? false),
            ]);

            foreach($data['questions'] as $q){
                $c = $quiz->cauHois()->create([
                    'noi_dung'   => $q['noi_dung'],
                    'giai_thich' => $q['giai_thich'] ?? null,
                    'do_kho'     => $q['do_kho'],
                ]);
                $c->dapAns()->createMany($q['options']);
                if(!$c->dapAns()->where('dung',1)->exists()){
                    throw new \RuntimeException('Mỗi câu cần ít nhất 1 đáp án đúng');
                }
            }
        });

        return redirect()->route('library.index')->with('ok','Đã tạo quiz');
    }
}
