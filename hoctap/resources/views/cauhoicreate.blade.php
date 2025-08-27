@extends('layouts.app')
@section('title','Thêm câu hỏi')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Thêm câu hỏi</h1>

@if ($errors->any())
  <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm">
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('de-thi.cau-hoi.store',$de_thi) }}" x-data="createQ()">
  @csrf

  <div class="bg-white border rounded p-4 space-y-3">
    <div>
      <label class="block mb-1 font-medium">Nội dung câu hỏi</label>
      <textarea class="border rounded px-3 py-2 w-full" x-model="q.noi_dung" required></textarea>
    </div>

    <div class="grid md:grid-cols-3 gap-3">
      <div>
        <label class="block mb-1 font-medium">Độ khó</label>
        <select class="border rounded px-3 py-2 w-full" x-model="q.do_kho">
          <option value="easy">Dễ</option>
          <option value="medium">Trung bình</option>
          <option value="hard">Khó</option>
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="block mb-1 font-medium">Giải thích (tuỳ chọn)</label>
        <input class="border rounded px-3 py-2 w-full" x-model="q.giai_thich">
      </div>
    </div>

    <div>
      <div class="font-medium mb-2">Các đáp án</div>
      <template x-for="(op, i) in q.options" :key="i">
        <div class="flex items-center gap-2 mb-2">
          <input class="border rounded px-3 py-2 flex-1" placeholder="Nội dung đáp án" x-model="op.noi_dung" required>
          <label class="inline-flex items-center gap-1 text-sm">
            <input type="checkbox" x-model="op.dung"> Đúng
          </label>
          <button type="button" class="text-red-600 text-sm" @click="removeOption(i)">Xoá</button>
        </div>
      </template>
      <button type="button" class="px-2 py-1 bg-gray-200 rounded text-sm" @click="addOption()">+ Thêm đáp án</button>
    </div>
  </div>

  {{-- serialize theo format controller cần --}}
  <input type="hidden" name="noi_dung"    :value="q.noi_dung">
  <input type="hidden" name="giai_thich"  :value="q.giai_thich">
  <input type="hidden" name="do_kho"      :value="q.do_kho">

  <template x-for="(op, i) in q.options" :key="'h-'+i">
    <div class="hidden">
      <input :name="`options[${i}][noi_dung]`" :value="op.noi_dung">
      <input :name="`options[${i}][dung]`"     :value="op.dung ? 1 : 0">
    </div>
  </template>

  <div class="mt-4 flex gap-2">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Lưu</button>
    <a href="{{ route('de-thi.show',$de_thi) }}" class="px-4 py-2 bg-gray-200 rounded">Huỷ</a>
  </div>
</form>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function createQ(){return{
  q:{ noi_dung:'', giai_thich:'', do_kho:'easy', options:[{noi_dung:'',dung:false},{noi_dung:'',dung:false}] },
  addOption(){ this.q.options.push({noi_dung:'',dung:false}); },
  removeOption(i){ this.q.options.splice(i,1); if(this.q.options.length<2) this.addOption(); },
};}
</script>
@endsection
