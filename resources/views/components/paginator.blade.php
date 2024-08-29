@if ($paginator->hasPages())
    <div class="mt-4">
        <ul class="flex justify-center space-x-2">
            <li>
                <a href="{{ $paginator->url(1) }}" aria-label="First"
                    class="px-3 py-1 border rounded-md hover:bg-gray-200
                {{ $paginator->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                    << </a>
            </li>

            <li>
                <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"
                    class="px-3 py-1 border rounded-md hover:bg-gray-200
                {{ $paginator->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                    Previous
                </a>
            </li>

            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                <li>
                    <a href="{{ $paginator->url($page) }}"
                        class="px-3 py-1 border rounded-md hover:bg-gray-300
                    {{ $paginator->currentPage() == $page ? 'bg-gray-400 text-blue-700' : '' }}">
                        {{ $page }}
                    </a>
                </li>
            @endfor

            <li>
                <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next"
                    class="px-3 py-1 border rounded-md hover:bg-gray-200
                {{ $paginator->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                    Next
                </a>
            </li>

            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last"
                    class="px-3 py-1 border rounded-md hover:bg-gray-200
                {{ $paginator->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                    >>
                </a>
            </li>
        </ul>
    </div>
@endif
