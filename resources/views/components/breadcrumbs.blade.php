<nav class="bg-white px-6 py-3 shadow-sm">
    <ol class="flex items-center space-x-2 text-sm overflow-x-auto whitespace-nowrap">
        @foreach(App\Helpers\Breadcrumbs::generate() as $label => $url)
            <li class="flex items-center">
                @if(!$loop->last)
                    <a href="{{ $url }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                        {{ $label }}
                    </a>
                    <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @else
                    <span class="text-gray-500 font-medium">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>