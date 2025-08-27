@extends('layouts.app')
@section('title','Thư viện của tôi')

@section('content')
@if(session('ok'))
  <div class="p-2 mb-3 bg-emerald-50 border border-emerald-200 rounded">{{ session('ok') }}</div>
@endif

<div class="flex justify-between mb-4">
  <h1 class="text-2xl font-semibold">Được tạo bởi tôi ({{ $countAll }})</h1>
  <a href="{{ route('de-thi.create') }}" class="bg-pink-600 text-white px-4 py-2 rounded">+ Tạo mới</a>
</div>

<form method="GET" class="grid md:grid-cols-4 gap-2 mb-3">
  <input name="q" value="{{ request('q') }}" placeholder="Tìm tiêu đề..." class="border rounded px-3 py-2">
  <select name="mon_hoc_id" class="border rounded px-3 py-2">
    <option value="">-- Tất cả môn --</option>
    @foreach($monHocs as $m)
      <option value="{{ $m->id }}" @selected(request('mon_hoc_id')==$m->id)>{{ $m->ten }}</option>
    @endforeach
  </select>
  <select name="sort" class="border rounded px-3 py-2">
    @php $s=request('sort','newest'); @endphp
    <option value="newest" @selected($s==='newest')>Mới nhất</option>
    <option value="oldest" @selected($s==='oldest')>Cũ nhất</option>
    <option value="title_asc" @selected($s==='title_asc')>A→Z</option>
    <option value="title_desc" @selected($s==='title_desc')>Z→A</option>
  </select>
  <button class="bg-blue-600 text-white px-4 py-2 rounded">Lọc</button>
</form>

<form method="POST" action="{{ route('library.bulk') }}">@csrf
  <div class="mb-2 flex gap-2">
    <select name="action" class="border rounded px-3 py-2">
      <option value="">Hành động...</option>
      <option value="publish">Công khai</option>
      <option value="unpublish">Nháp</option>
      <option value="delete">Xóa</option>
    </select>
    <button class="px-3 py-2 bg-gray-900 text-white rounded"
      onclick="return confirm('Thực hiện với mục đã chọn?')">Thực hiện</button>
  </div>

  <div class="bg-white border rounded">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2"><input type="checkbox" onclick="document.querySelectorAll('input[name=&quot;ids[]&quot;]').forEach(x=>x.checked=this.checked)"></th>
          <th class="p-2 text-left">Tiêu đề</th>
          <th class="p-2 text-left">Môn</th>
          <th class="p-2 text-left">Trạng thái</th>
          <th class="p-2">Hành động</th>
        </tr>
      </thead>
      <tbody>
        @forelse($deThis as $d)
        <tr class="border-t">
          <td class="p-2"><input type="checkbox" name="ids[]" value="{{ $d->id }}"></td>
          <td class="p-2"><a class="font-medium" href="{{ route('de-thi.show',$d) }}">{{ $d->tieu_de }}</a></td>
          <td class="p-2">{{ $d->monHoc->ten ?? '—' }}</td>
          <td class="p-2">
            @if($d->cong_khai)
              <span class="px-2 py-0.5 bg-green-100 rounded">Công khai</span>
            @else
              <span class="px-2 py-0.5 bg-yellow-100 rounded">Nháp</span>
            @endif
          </td>
          <td class="p-2"><a href="{{ route('de-thi.show',$d) }}" class="px-2 py-1 bg-blue-600 text-white rounded text-xs">Mở</a></td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-4 text-center text-gray-500">Chưa có quiz</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $deThis->links() }}</div>
</form>
@endsection
