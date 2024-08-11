<x-layout>
    <div class="container mx-auto p-6 flex justify-center items-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-1/2">
            <h1 class="text-2xl font-bold mb-6">Return Borrowed Kits</h1>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700">Student Email</label>
                <input type="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    id="email" name="email" placeholder="Enter student email" required>
                <button type="button"
                    class="mt-3 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    id="fetch-borrowed-kits">
                    Fetch Borrowed Kits
                </button>
            </div>

            <form action="{{ route('borrowed-kits.return') }}" method="POST">
                @csrf
                <input type="hidden" name="email" id="email-hidden">

                <div id="borrowed-kits-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>

                <button type="submit"
                    class="mt-6 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm mb-4 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Return All Selected Kits
                </button>
                <a href="{{ route('borrowed-kits.borrow') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded w-64 justify-center flex mx-auto">Back</a>

            </form>

            <script>
                document.getElementById('fetch-borrowed-kits').addEventListener('click', function() {
                    const email = document.getElementById('email').value;
                    document.getElementById('email-hidden').value = email;

                    if (email) {
                        fetch(`{{ url('/borrowed-kits/fetch-borrowed-kits?email=') }}${email}`)
                            .then(response => response.json())
                            .then(data => {
                                const container = document.getElementById('borrowed-kits-container');
                                container.innerHTML = '';

                                if (data.length === 0) {
                                    container.innerHTML =
                                        '<p class="text-gray-500">No borrowed kits found for this student.</p>';
                                    return;
                                }

                                data.forEach(borrowedKit => {
                                    if (borrowedKit.quantity_borrowed > 0) {
                                        const kitDiv = document.createElement('div');
                                        kitDiv.classList.add('bg-white', 'p-6', 'rounded-lg', 'shadow-lg');
                                        kitDiv.innerHTML = `
                                            <div>
                                                <h5 class="text-lg font-semibold">${borrowedKit.kit_name}</h5>
                                                <p class="text-gray-600">Borrowed Quantity: ${borrowedKit.quantity_borrowed}</p>
                                                <div class="mb-4">
                                                    <label for="quantity-${borrowedKit.kit_id}" class="block text-sm font-medium text-gray-700">Quantity to Return</label>
                                                    <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="quantity-${borrowedKit.kit_id}" name="kits[${borrowedKit.kit_id}]" min="1" max="${borrowedKit.quantity_borrowed}">
                                                </div>
                                            </div>
                                        `;
                                        container.appendChild(kitDiv);
                                    }
                                });

                                if (container.innerHTML === '') {
                                    container.innerHTML =
                                        '<p class="text-gray-500">No borrowable kits with quantity greater than 0 found for this student.</p>';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching borrowed kits:', error);
                                alert('An error occurred while fetching borrowed kits.');
                            });
                    }
                });
            </script>
        </div>
    </div>
</x-layout>
