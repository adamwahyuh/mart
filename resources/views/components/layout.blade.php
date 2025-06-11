<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    {{-- CSRF Token --}}
    <title>Kasir aku</title>
</head>
<body>
    <header>
        <x-navbar></x-navbar>
    </header>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    <main>
        <article>
            <x-sidebar></x-sidebar>
        </article>
        <article>
            {{ $slot }}
        </article>
    </main>
    <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    }
  </script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>