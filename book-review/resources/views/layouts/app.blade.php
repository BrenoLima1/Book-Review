<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel 12 Task List App</title>

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .transition-theme {
      transition: background-color 0.4s ease, color 0.4s ease;
    }
  </style>
</head>
<body class="light bg-white text-gray-900 transition-theme container mx-auto mt-10 mb-10 max-w-lg">

  {{-- Header --}}
  <header class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">@yield('title')</h1>
    {{-- Botão Dark/Light --}}
    <button id="themeToggle"
            class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
      🌙 Dark
    </button>
  </header>

  {{-- Flash messages --}}
  <main>
    @if (session()->has('success'))
      <div class="relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700"
           role="alert">
        <strong class="font-bold">Success!</strong>
        <div>{{ session('success') }}</div>
      </div>
    @endif

    {{-- Page content --}}
    @yield('content')
  </main>

  <script>
    const body = document.body;
    const toggleBtn = document.getElementById('themeToggle');

    // Função para aplicar tema
    function applyTheme(theme) {
      if (theme === 'dark') {
        body.classList.remove('light');
        body.classList.add('dark', 'bg-gray-900', 'text-gray-100');
        toggleBtn.textContent = '☀️ Light';
        toggleBtn.classList.remove('bg-gray-200', 'text-gray-800');
        toggleBtn.classList.add('bg-gray-700', 'text-gray-100');
      } else {
        body.classList.remove('dark', 'bg-gray-900', 'text-gray-100');
        body.classList.add('light', 'bg-white', 'text-gray-900');
        toggleBtn.textContent = '🌙 Dark';
        toggleBtn.classList.remove('bg-gray-700', 'text-gray-100');
        toggleBtn.classList.add('bg-gray-200', 'text-gray-800');
      }
      localStorage.setItem('theme', theme);
    }

    // Carregar tema salvo ou padrão do sistema
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      applyTheme(savedTheme);
    } else {
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      applyTheme(prefersDark ? 'dark' : 'light');
    }

    // Alternar tema no clique
    toggleBtn.addEventListener('click', () => {
      const newTheme = body.classList.contains('light') ? 'dark' : 'light';
      applyTheme(newTheme);
    });
  </script>
</body>
</html>
