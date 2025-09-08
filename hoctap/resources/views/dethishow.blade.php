@extends('layouts.app')
@section('content')
<div class="mb-4 flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-semibold">{{ $de_thi->tieu_de }}</h1>
    <div class="text-sm text-gray-600">Môn: {{ $de_thi->monHoc->ten ?? '—' }}</div>
  </div>
  <div class="flex gap-2">
    @if(!$de_thi->cong_khai)
      <form method="POST" action="{{ route('de-thi.publish',$de_thi) }}">@csrf
        <button class="px-3 py-2 bg-green-600 text-white rounded">Xuất bản</button>
      </form>
    @else
      <form method="POST" action="{{ route('de-thi.unpublish',$de_thi) }}">@csrf
        <button class="px-3 py-2 bg-gray-700 text-white rounded">Bỏ xuất bản</button>
      </form>
    @endif
    <a href="{{ route('de-thi.cau-hoi.create',$de_thi) }}" class="px-3 py-2 bg-pink-600 text-white rounded">+ Thêm câu hỏi</a>
    <a href="{{ route('library.index') }}" class="px-3 py-2 bg-gray-200 rounded">Về Thư viện</a>
  </div>
</div>

@if(session('ok'))<div class="p-2 mb-3 bg-emerald-50 border border-emerald-200 rounded">{{ session('ok') }}</div>@endif

<div class="space-y-4">
  @forelse($de_thi->cauHois as $i=>$q)
  <div class="bg-white border rounded p-4">
    <div class="flex justify-between">
      <div class="font-semibold">{{ $i+1 }}. NHIỀU LỰA CHỌN • {{ strtoupper($q->do_kho) }}</div>
      <div class="flex gap-2">
        <a class="px-2 py-1 bg-amber-600 text-white rounded text-xs" href="{{ route('de-thi.cau-hoi.edit',[$de_thi,$q]) }}">Chỉnh sửa</a>
        <form method="POST" onsubmit="return confirm('Xóa câu hỏi?')" action="{{ route('de-thi.cau-hoi.destroy',[$de_thi,$q]) }}">@csrf @method('DELETE')
          <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">Xóa</button></form>
      </div>
    </div>
    <div class="mt-2">{!! nl2br(e($q->noi_dung)) !!}</div>
    <div class="mt-3 grid md:grid-cols-2 gap-2">
      @foreach($q->dapAns as $op)
        <div class="px-3 py-2 border rounded {{ $op->dung?'bg-green-50 border-green-300':'bg-gray-50' }}">
          {!! nl2br(e($op->noi_dung)) !!} @if($op->dung)<strong class="text-green-700 ml-1">✔ Đúng</strong>@endif
        </div>
      @endforeach
    </div>
  </div>
  @empty
  <div class="p-6 bg-white border rounded text-center text-gray-500">Chưa có câu hỏi. Bấm “+ Thêm câu hỏi”.</div>
  @endforelse
</div>
@endsection
