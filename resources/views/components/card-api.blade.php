<div class="flex flex-wrap items-start gap-4 w-full max-w-full">
    <div class="flex flex-row gap-4 w-full rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20] max-w-full">
        <div class="pt-3 sm:pt-5 w-full flex-shrink-0">
            <h2 class="text-xl font-semibold text-black dark:text-white truncate" title="{{ $title }}">{{ $title }}</h2>
            <p class="mt-4 text-sm/relaxed">
                <strong>URL:</strong> <code>{{ $url }}</code><br>
                <strong>Descripción:</strong> {{ $description }}
            </p>
            @if (count($params) > 0)
            <p class="mt-4 text-sm/relaxed">
                <strong>Parámetros:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($params as $param)
                        <li> - <code>{{ $param }}</code></li>
                    @endforeach
                </ul>
            </p>
            @endif
        </div>
        <div>
            @include('components.icon-card')
        </div>
    </div>
</div>
