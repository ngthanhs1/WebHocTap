<!DOCTYPE html>
<html lang="vi"><head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','HocTap') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  <nav class="bg-white border-b mb-6">
    <div class="container mx-auto px-4 py-3 flex justify-between">
      <a href="{{ route('catalog') }}" class="font-semibold">Học Tập</a>
      <a href="{{ route('catalog') }}" class="text-sm text-gray-600">Catalog</a>
    </div>
  </nav>
  @yield('content')
</body></html>
