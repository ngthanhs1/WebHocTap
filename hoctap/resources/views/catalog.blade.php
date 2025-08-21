@extends('welcome')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-semibold mb-4">Danh sách đề thi</h1>

  <form method="GET" action="{{ route('catalog') }}" class="mb-4 flex gap-2">
    <select name="mon_hoc_id" class="border rounded px-3 py-2">
      <option value="">-- Tất cả môn --</option>
      @foreach($monHocs as $m)
        <option value="{{ $m->id }}" @selected(request('mon_hoc_id')==$m->id)>{{ $m->ten }}</option>
      @endforeach
    </select>
    <input name="q" value="{{ request('q') }}" placeholder="Tìm theo tiêu đề..." class="border rounded px-3 py-2 flex-1">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Lọc</button>
  </form>

  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($deThis as $d)
      <div class="border rounded p-4 bg-white">
        <div class="text-sm text-gray-500">{{ $d->monHoc->ten ?? '—' }}</div>
        <h3 class="text-lg font-medium">{{ $d->tieu_de }}</h3>
        <a href="{{ route('de-thi.lam-bai',$d) }}" class="inline-block mt-3 bg-green-600 text-white px-3 py-1.5 rounded">Làm bài</a>
      </div>
    @empty
      <p>Chưa có đề thi.</p>
    @endforelse
  </div>

  <div class="mt-4">{{ $deThis->withQueryString()->links() }}</div>
</div>
@endsection
