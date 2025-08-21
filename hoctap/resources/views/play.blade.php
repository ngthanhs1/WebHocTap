@extends('welcome')

@section('content')
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-semibold mb-2">{{ $de_thi->tieu_de }}</h1>
  <p class="text-gray-600 mb-6">{{ $de_thi->mo_ta }}</p>

  <form method="POST" action="{{ route('de-thi.nop-bai',$de_thi) }}" class="space-y-6">
    @csrf
    @foreach($de_thi->cauHois as $idx => $q)
      <div class="border rounded p-4 bg-white">
        <h3 class="font-medium mb-2">Câu {{ $idx+1 }}. {!! nl2br(e($q->noi_dung)) !!}</h3>
        <div class="space-y-2">
          @foreach($q->dapAns as $opt)
            <label class="flex items-center gap-2">
              <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}">
              <span>{!! nl2br(e($opt->noi_dung)) !!}</span>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Nộp bài</button>
  </form>
</div>
@endsection
