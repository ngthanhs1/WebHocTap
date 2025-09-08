@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tạo bài Quiz mới</h1>
<form method="POST" action="{{ route('de-thi.store') }}" x-data="quiz()">@csrf
  <div class="bg-white border rounded p-4 mb-4 grid md:grid-cols-2 gap-3">
    <div>
      <label class="block mb-1">Môn học</label>
      <select name="mon_hoc_id" class="border rounded px-3 py-2 w-full" required>
        <option value="">-- Chọn môn --</option>
        @foreach($monHocs as $m)<option value="{{ $m->id }}">{{ $m->ten }}</option>@endforeach
      </select>
    </div>
    <div>
      <label class="block mb-1">Tiêu đề</label>
      <input name="tieu_de" class="border rounded px-3 py-2 w-full" required>
    </div>
    <div class="md:col-span-2">
      <label class="block mb-1">Mô tả</label>
      <textarea name="mo_ta" class="border rounded px-3 py-2 w-full"></textarea>
    </div>
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="cong_khai" value="1"> Công khai
    </label>
  </div>

  <div class="space-y-4">
    <template x-for="(q, qi) in questions" :key="qi">
      <div class="bg-white border rounded p-4">
        <div class="flex justify-between mb-2">
          <h3 class="font-semibold">Câu <span x-text="qi+1"></span></h3>
          <button type="button" class="text-red-600 text-sm" @click="removeQuestion(qi)">Xóa câu</button>
        </div>

        <div class="grid md:grid-cols-3 gap-3 mb-3">
          <div class="md:col-span-2">
            <label class="block mb-1">Nội dung</label>
            <textarea class="border rounded px-3 py-2 w-full" x-model="q.noi_dung" required></textarea>
          </div>
          <div>
            <label class="block mb-1">Độ khó</label>
            <select class="border rounded px-3 py-2 w-full" x-model="q.do_kho">
              <option value="easy">Dễ</option>
              <option value="medium">Trung bình</option>
              <option value="hard">Khó</option>
            </select>
          </div>
          <div class="md:col-span-3">
            <label class="block mb-1">Giải thích</label>
            <input class="border rounded px-3 py-2 w-full" x-model="q.giai_thich">
          </div>
        </div>

        <div class="mb-2 font-medium">Đáp án</div>
        <template x-for="(op, oi) in q.options" :key="oi">
          <div class="flex items-center gap-2 mb-2">
            <input class="border rounded px-3 py-2 flex-1" placeholder="Nội dung đáp án" x-model="op.noi_dung" required>
            <label class="inline-flex items-center gap-1"><input type="checkbox" x-model="op.dung"> Đúng</label>
            <button type="button" class="text-red-600 text-sm" @click="removeOption(qi,oi)">Xóa</button>
          </div>
        </template>
        <button type="button" class="px-2 py-1 bg-gray-200 rounded text-sm" @click="addOption(qi)">+ Thêm đáp án</button>
      </div>
    </template>
  </div>

  <div class="flex gap-2 mt-4">
    <button type="button" class="px-3 py-2 bg-gray-200 rounded" @click="addQuestion()">+ Thêm câu hỏi</button>
    <input type="hidden" name="questions" :value="JSON.stringify(questionsForSubmit())">
    <button class="px-4 py-2 bg-blue-600 text-white rounded" @click.prevent="$el.form.submit()">Lưu</button>
  </div>
</form>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function quiz(){return{
  questions:[{noi_dung:'',giai_thich:'',do_kho:'easy',options:[{noi_dung:'',dung:false},{noi_dung:'',dung:false}]}],
  addQuestion(){this.questions.push({noi_dung:'',giai_thich:'',do_kho:'easy',options:[{noi_dung:'',dung:false},{noi_dung:'',dung:false}]});},
  removeQuestion(i){this.questions.splice(i,1); if(this.questions.length===0) this.addQuestion();},
  addOption(i){this.questions[i].options.push({noi_dung:'',dung:false});},
  removeOption(i,j){this.questions[i].options.splice(j,1); if(this.questions[i].options.length<2) this.addOption(i);},
  questionsForSubmit(){return this.questions.map(q=>({noi_dung:q.noi_dung,giai_thich:q.giai_thich,do_kho:q.do_kho,options:q.options.map(o=>({noi_dung:o.noi_dung,dung:o.dung?1:0}))}));}
};}
</script>
@endsection
