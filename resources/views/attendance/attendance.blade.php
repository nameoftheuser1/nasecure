<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        border-top: 50px solid blue;
        border-bottom: 50px solid blue;
    }
</style>
<x-layout>
    <div class="flex bg-gray-100 rounded-lg overflow-hidden w-[1000px] -mt-1">
        <div class="flex-1 bg-cover bg-center rounded-l-lg"
            style="background-image: url('{{ asset('images/NASECURE.png') }}');">
        </div>

        <div class="p-4 w-11/12 max-w-sm flex flex-col justify-center items-center">
            <h1 class="text-3xl font-bold mb-6 text-center">Attendance</h1>

            @if (session('success'))
                <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
            @elseif(session('failed'))
                <x-flashMsg msg="{{ session('failed') }}" bg="bg-red-500" />
            @endif

            @error('email')
                <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @error('section_id')
                <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="mb-6 w-full">
                <h2 class="font-semibold mb-4 text-center">Record Time In</h2>
                <form action="{{ route('attendance.timeIn') }}" method="POST" id="timeInForm">
                    @csrf
                    <div class="mb-4">
                        <label for="email_in" class="block text-sm font-medium text-gray-700 text-center">Student
                            Email</label>
                        <input type="text" id="email_in" name="email"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            placeholder="Enter Email" required>
                    </div>
                    <div class="mb-4">
                        <label for="section_in" class="block text-sm font-medium text-gray-700 text-center">Select
                            Section</label>
                        <select id="section_in" name="section_id"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            required>
                            <option value="" disabled selected>Select Section</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full p-1.5 border-none rounded-md bg-gray-300 cursor-pointer mb-1 hover:bg-blue-700 transition-colors duration-300">Record
                        Time In</button>
                </form>

                <a href="{{ route('login') }}" class="text-center no-underline block text-sm mt-2.5 hover:underline">Do
                    you want to login? <span class="text-blue-700">Login here.</span> </a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('email_in').addEventListener('change', function() {
            fetchSections(this.value, 'section_in');
        });

        document.getElementById('email_out').addEventListener('change', function() {
            fetchSections(this.value, 'section_out');
        });

        function fetchSections(email, sectionSelectId) {
            fetch('{{ route('attendance.fetchSections') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    let sectionSelect = document.getElementById(sectionSelectId);
                    sectionSelect.innerHTML = '<option value="" disabled selected>Select Section</option>';
                    if (data.sections && Array.isArray(data.sections)) {
                        data.sections.forEach(section => {
                            let option = document.createElement('option');
                            option.value = section.id;
                            option.text = section.section_name;
                            sectionSelect.appendChild(option);
                        });
                    } else {
                        let option = document.createElement('option');
                        option.value = '';
                        option.text = data.error || 'No sections found';
                        sectionSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                    let sectionSelect = document.getElementById(sectionSelectId);
                    sectionSelect.innerHTML = '<option value="" disabled selected>Error fetching sections</option>';
                });
        }
    </script>
</x-layout>
