@extends('welcome')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-semibold mb-2">Kết quả: {{ $de_thi->tieu_de }}</h1>
  <p class="mb-6">Điểm: <span class="font-bold">{{ $score }}%</span> ({{ $correct }}/{{ $total }})</p>

  @foreach($de_thi->cauHois as $idx => $q)
    @php $chosenId = $answers[$q->id] ?? null; @endphp
    <div class="border rounded p-4 mb-4 bg-white">
      <h3 class="font-medium mb-2">Câu {{ $idx+1 }}. {!! nl2br(e($q->noi_dung)) !!}</h3>
      <ul class="space-y-1">
        @foreach($q->dapAns as $opt)
          @php
            $isChosen = (int)$chosenId === $opt->id;
            $classes = 'px-2 py-1 inline-block rounded';
            if ($opt->dung) $classes .= ' bg-green-100';
            if ($isChosen && !$opt->dung) $classes .= ' bg-red-100';
          @endphp
          <li><span class="{{ $classes }}">
            {!! nl2br(e($opt->noi_dung)) !!}
            @if($opt->dung) <strong>(đúng)</strong> @endif
            @if($isChosen && !$opt->dung) <em>(bạn chọn)</em> @endif
          </span></li>
        @endforeach
      </ul>
      @if($q->giai_thich)
        <div class="mt-2 text-sm text-gray-700">
          <span class="font-semibold">Giải thích:</span> {!! nl2br(e($q->giai_thich)) !!}
        </div>
      @endif
    </div>
  @endforeach

  <a href="{{ route('catalog') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Về catalog</a>
</div>
@endsection
