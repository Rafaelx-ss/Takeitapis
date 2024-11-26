<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación API</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');

        :root {
            --lava-red: #FF4136;
            --fire-orange: #FF851B;
            --ember-yellow: #FFDC00;
            --neon-blue: #00F3FF;
            --plasma-purple: #B10DC9;
            --dark-bg: rgba(17, 24, 39, 0.95);
        }

        body {
            background-color: #0A0F1E;
            color: #fff;
            position: relative;
            overflow-x: hidden;
            font-family: 'Space Grotesk', sans-serif;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(177, 13, 201, 0.1), transparent),
                        radial-gradient(circle at bottom left, rgba(255, 65, 54, 0.1), transparent);
            z-index: -1;
        }

        .endpoint-card {
            background: rgba(31, 41, 55, 0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .endpoint-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg,
                transparent,
                rgba(var(--neon-blue), 0.5),
                transparent
            );
            transform: translateX(-100%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }

        .endpoint-card:hover {
            transform: translateY(-4px) scale(1.00);
            box-shadow: 0 20px 40px rgba(255, 65, 54, 0.15),
                       0 0 20px rgba(255, 133, 27, 0.1),
                       0 0 0 1px rgba(255, 133, 27, 0.2);
            border-color: rgba(255, 133, 27, 0.3);
        }

        .method-badge {
            font-family: 'Space Grotesk', monospace;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .method-badge::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: inherit;
            filter: blur(10px);
            opacity: 0.4;
            z-index: -1;
        }

        .method-badge.get {
            background: linear-gradient(135deg, #2ECC40, #25a233);
        }
        .method-badge.post {
            background: linear-gradient(135deg, var(--fire-orange), #e67300);
        }
        .method-badge.put {
            background: linear-gradient(135deg, var(--neon-blue), #0099ff);
        }
        .method-badge.delete {
            background: linear-gradient(135deg, var(--lava-red), #d4342b);
        }

        .endpoint-url {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .endpoint-url:hover {
            border-color: var(--fire-orange);
            box-shadow: 0 0 15px rgba(255, 133, 27, 0.2);
        }

        .copy-button {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            backdrop-filter: blur(5px);
        }

        .param-card {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .param-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.05),
                transparent
            );
            transform: translateX(-100%);
            transition: transform 0.5s;
        }

        .param-card:hover::after {
            transform: translateX(100%);
        }

        .param-card:hover {
            border-color: var(--neon-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 243, 255, 0.1);
        }

        pre {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .gradient-text {
            background: linear-gradient(
                45deg,
                var(--fire-orange),
                var(--ember-yellow),
                var(--neon-blue),
                var(--plasma-purple)
            );
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient 8s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg,
                var(--fire-orange),
                var(--neon-blue)
            );
            border-radius: 2px;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .search-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--neon-blue);
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.2);
            outline: none;
        }

        .search-button {
            background: linear-gradient(135deg, var(--fire-orange), #e67300);
            transition: all 0.3s ease;
        }

        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 133, 27, 0.3);
        }
    </style>
</head>
<body class="min-h-screen py-12">
    <img id="background" class="fixed -left-20 top-0 max-w-[877px] opacity-30 z-0" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
    <div class="background-overlay"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h1 class="text-6xl font-bold mb-4 gradient-text floating">
                TAKE IT API
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-8">
                Todas las API del proyecto TAKE IT documentadas.
            </p>

            <!-- Buscador -->
            <div class="max-w-2xl mx-auto">
                <div class="flex gap-4">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Buscar API por nombre, endpoint o descripción..."
                        value="{{ $search ?? '' }}"
                        class="search-input w-full px-6 py-4 rounded-xl text-white placeholder-gray-400"
                    >
                    <button id="searchButton" class="search-button px-8 py-4 rounded-xl text-white font-semibold">
                        <i class="fas fa-search mr-2"></i>
                        Buscar
                    </button>
                </div>
            </div>

            <div id="noResults" class="mt-8 text-gray-400 hidden">
                No se encontraron resultados para "<span id="searchTerm" class="text-white"></span>"
            </div>
        </div>

        <div class="grid gap-12">
            @foreach($endpoints as $endpoint)
                <div class="endpoint-card rounded-2xl p-8 shadow-2xl" data-searchable="{{ strtolower($endpoint->name . ' ' . $endpoint->endpoint . ' ' . $endpoint->description . ' ' . $endpoint->method) }}">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold text-white">
                            {{ $endpoint->name }}
                        </h2>
                        <span class="method-badge {{ strtolower($endpoint->method) }} rounded-xl text-white font-mono text-sm tracking-wider shadow-lg">
                            {{ $endpoint->method }}
                        </span>
                    </div>

                    <div class="mb-8 endpoint-url relative">
                        <code class="text-lg px-6 py-4 block w-full overflow-x-auto whitespace-nowrap">
                            {{ $endpoint->endpoint }}
                        </code>
                        <button class="copy-button absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white px-4 py-2">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    <p class="text-gray-300 text-lg mb-10 leading-relaxed">{{ $endpoint->description }}</p>

                    @if($endpoint->parameters)
                        <div class="space-y-8">
                            <h3 class="section-title text-2xl font-bold text-white">
                                <i class="fas fa-code mr-3 text-fire-orange"></i>
                                Parámetros
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($endpoint->parameters as $param => $details)
                                    <div class="param-card rounded-xl p-6">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="font-mono text-neon-blue text-lg">{{ $param }}</span>
                                            <span class="px-3 py-1 bg-black bg-opacity-30 rounded-full text-gray-400 text-sm">
                                                {{ $details['type'] }}
                                            </span>
                                        </div>
                                        <p class="text-gray-400">{{ $details['description'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($endpoint->headers)
                        <div class="mt-12 space-y-8">
                            <h3 class="section-title text-2xl font-bold text-white">
                                <i class="fas fa-exchange-alt mr-3 text-fire-orange"></i>
                                Encabezados
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($endpoint->headers as $header => $value)
                                    <div class="param-card rounded-xl p-6">
                                        <span class="font-mono text-neon-blue text-lg block mb-3">{{ $header }}</span>
                                        <code class="text-gray-400">{{ $value }}</code>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-12 space-y-8">
                        <h3 class="section-title text-2xl font-bold text-white">
                            <i class="fas fa-reply mr-3 text-fire-orange"></i>
                            Ejemplo de Respuesta
                        </h3>
                        <pre class="p-8 overflow-x-hidden param-card"><code class="text-sm">{{ json_encode($endpoint->response_example, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-button').forEach(button => {
            button.addEventListener('click', () => {
                const code = button.parentElement.querySelector('code').textContent.trim();
                navigator.clipboard.writeText(code);

                const icon = button.querySelector('i');
                icon.className = 'fas fa-check';
                setTimeout(() => {
                    icon.className = 'fas fa-copy';
                }, 2000);

                // Efecto de onda
                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                ripple.style.width = '100px';
                ripple.style.height = '100px';
                ripple.style.transform = 'translate(-50%, -50%) scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                button.appendChild(ripple);

                setTimeout(() => ripple.remove(), 700);
            });
        });



        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const endpointsList = document.getElementById('endpointsList');
        const noResults = document.getElementById('noResults');
        const searchTerm = document.getElementById('searchTerm');
        let timeoutId;

        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.endpoint-card');
            let hasResults = false;

            cards.forEach(card => {
                const searchableText = card.dataset.searchable;
                const isMatch = query.split(' ').every(term =>
                    searchableText.includes(term.toLowerCase())
                );

                card.style.display = isMatch ? 'block' : 'none';
                if (isMatch) hasResults = true;
            });

            noResults.style.display = query && !hasResults ? 'block' : 'none';
            searchTerm.textContent = query;
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(performSearch, 300);
        });

        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            performSearch();
        });

        if (searchInput.value) {
            performSearch();
        }
    </script>

    <style>
        @keyframes ripple {
            to {
                transform: translate(-50%, -50%) scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
