<x-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Borrow Kits</h1>
        <div>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-400 border border-red-400 text-white px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <a href="{{ route('borrowed-kits.return') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded w-64 mr-4">
            Return Kits
        </a>
        <a href="{{ route('borrowed-kits') }}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded w-64">
            Back
        </a>
        <div class="flex gap-2">
            <div>
                <div class="w-full mt-6">
                    <form method="GET" action="{{ route('borrowed-kits.borrow') }}" class="flex items-center">
                        <div class="relative flex w-full">
                            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full">
                            <button type="submit"
                                class="absolute right-0 top-0 h-full px-4 bg-blue-700 text-white rounded-r-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                @if ($kits->isEmpty())
                    <p class="text-gray-600">No kits available for borrowing at the moment.</p>
                @else
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Kit Name</th>
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Description</th>
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Quantity
                                        Available
                                    </th>
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kits as $kit)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">{{ $kit->kit_name }}</td>
                                        <td class="py-3 px-4 border-b">{{ $kit->description }}</td>
                                        <td class="py-3 px-4 border-b">{{ $kit->quantity }}</td>
                                        <td class="py-3 px-4 border-b">
                                            <form class="add-to-cart-form" data-kit-id="{{ $kit->id }}"
                                                data-kit-name="{{ $kit->kit_name }}"
                                                data-kit-quantity="{{ $kit->quantity }}">
                                                @csrf
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" name="quantity" value="1" min="1"
                                                        max="{{ $kit->quantity }}"
                                                        class="w-16 p-2 border border-gray-300 rounded">
                                                    <button type="button"
                                                        class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                                        &#43;
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($kits->hasPages())
                        <div class="mt-4">
                            <ul class="flex justify-center space-x-2">
                                <li>
                                    <a href="{{ $kits->url(1) }}" aria-label="First"
                                        class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                                        << </a>
                                </li>

                                <li>
                                    <a href="{{ $kits->previousPageUrl() }}" aria-label="Previous"
                                        class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->onFirstPage() ? 'cursor-not-allowed text-gray-400' : '' }}">
                                        Previous
                                    </a>
                                </li>

                                @for ($page = 1; $page <= $kits->lastPage(); $page++)
                                    <li>
                                        <a href="{{ $kits->url($page) }}"
                                            class="px-3 py-1 border rounded-md hover:bg-gray-200
                        {{ $kits->currentPage() == $page ? 'bg-gray-300 text-gray-700' : '' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endfor

                                <li>
                                    <a href="{{ $kits->nextPageUrl() }}" aria-label="Next"
                                        class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                                        Next
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $kits->url($kits->lastPage()) }}" aria-label="Last"
                                        class="px-3 py-1 border rounded-md hover:bg-gray-200
                    {{ $kits->hasMorePages() ? '' : 'cursor-not-allowed text-gray-400' }}">
                                        >>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
            </div>
            <div>
                <div id="cartSection" class="mb-6" style="display: none;">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Kit Name</th>
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Quantity</th>
                                    <th class="py-3 px-4 text-left text-gray-600 font-medium border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('borrowed-kits.proceedToBorrow') }}" method="POST" id="borrowForm">
                        @csrf
                        <input type="hidden" name="cart" id="cartData">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Student Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter student email"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit"
                            class="bg-blue-700 hover:bg-blue-800 text-white py-2 px-4 rounded w-full">
                            Borrow
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartSection = document.getElementById('cartSection');
            const cartItems = document.getElementById('cartItems');
            const borrowForm = document.getElementById('borrowForm');
            const cartDataInput = document.getElementById('cartData');

            function updateCartDisplay() {
                const cart = JSON.parse(sessionStorage.getItem('cart')) || {};
                cartItems.innerHTML = '';

                for (const [kitId, kitDetails] of Object.entries(cart)) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td class="py-3 px-4 border-b">${kitDetails.kit_name}</td>
                <td class="py-3 px-4 border-b">${kitDetails.quantity}</td>
                <td class="py-3 px-4 border-b">
                    <button type="button" class="remove-from-cart bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded" data-kit-id="${kitId}">
                        Remove
                    </button>
                </td>
            `;
                    cartItems.appendChild(row);
                }

                if (Object.keys(cart).length > 0) {
                    cartSection.style.display = 'block';
                } else {
                    cartSection.style.display = 'none';
                }

                cartDataInput.value = JSON.stringify(cart);
            }

            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.add-to-cart-form');
                    const kitId = form.dataset.kitId;
                    const kitName = form.dataset.kitName;
                    const kitQuantity = parseInt(form.dataset.kitQuantity);
                    const quantity = parseInt(form.querySelector('input[name="quantity"]').value);

                    if (quantity > kitQuantity) {
                        alert('Quantity exceeds available stock.');
                        return;
                    }

                    let cart = JSON.parse(sessionStorage.getItem('cart')) || {};

                    if (cart[kitId]) {
                        cart[kitId].quantity = parseInt(cart[kitId].quantity) + quantity;
                        if (cart[kitId].quantity > kitQuantity) {
                            alert('Quantity exceeds available stock.');
                            cart[kitId].quantity = kitQuantity;
                        }
                    } else {
                        cart[kitId] = {
                            kit_name: kitName,
                            quantity: quantity
                        };
                    }

                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    updateCartDisplay();
                });
            });

            cartItems.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-from-cart')) {
                    const kitId = event.target.dataset.kitId;
                    let cart = JSON.parse(sessionStorage.getItem('cart')) || {};
                    delete cart[kitId];
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    updateCartDisplay();
                }
            });

            borrowForm.addEventListener('submit', function(e) {
                const cart = JSON.parse(sessionStorage.getItem('cart')) || {};
                if (Object.keys(cart).length === 0) {
                    e.preventDefault();
                    alert('Your cart is empty. Please add items before checking out.');
                } else {
                    cartDataInput.value = JSON.stringify(cart);
                }
            });

            updateCartDisplay();
        });
    </script>
</x-layout>
