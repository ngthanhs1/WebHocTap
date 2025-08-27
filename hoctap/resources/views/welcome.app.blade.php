<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','HocTap')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<nav class="bg-white border-b mb-6">
  <div class="container mx-auto px-4 py-3 flex justify-between">
    <a href="{{ route('library.index') }}" class="font-semibold">Thư viện của tôi</a>
    <div class="space-x-2">
      <a href="{{ route('de-thi.create') }}" class="bg-pink-600 text-white px-3 py-1.5 rounded">+ Tạo mới</a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="px-3 py-1.5 border rounded">Đăng xuất</button>
      </form>
    </div>
  </div>
</nav>
<div class="container mx-auto px-4">@yield('content')</div>
</body>
</html>
