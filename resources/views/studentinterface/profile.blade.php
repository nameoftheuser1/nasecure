@php
    $imgUrl = Auth::user()->img_url;
    $defaultImage = 'images/profile.png';
    $imageSource = $imgUrl === $defaultImage ? asset($defaultImage) : asset('storage/' . $imgUrl);
@endphp

<head>
    <title>Student Profile</title>
    <script src="{{ asset('js/index.global.min.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <style>
        .fc-day-today {
            background-color: inherit !important;
        }

        .fc-day-has-event {
            background-color: #FEE2E2 !important;
            border-color: #FCA5A5 !important;
        }
    </style>
</head>

<x-layout>

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Student Profile</h1>
                <div class="flex space-x-4 p-4">

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-block bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <a href="{{ route('profile') }}"
                class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 w-full text-center">
                Edit Profile
            </a>
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center mb-4">

                    <div class="flex-1 text-center">
                        <img src="{{ $imageSource }}" alt="Profile Picture"
                            class="w-40 h-40 rounded-full mx-auto mb-4">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4 uppercase">{{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }}</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <p><strong class="font-medium">Student ID:</strong> {{ $student->student_id }}</p>
                    <p><strong class="font-medium">Email:</strong> {{ $student->email }}</p>
                    <p><strong class="font-medium">RFID:</strong> {{ $student->rfid }}</p>
                    <p><strong class="font-medium">Section:</strong> {{ $student->section->section_name ?? 'N/A' }}</p>
                    <p><strong class="font-medium">Created By:</strong> {{ $student->created_by ?? 'N/A' }}</p>
                </div>

                <h3 class="text-xl font-semibold text-gray-700 mb-3">Attendance Calendar</h3>
                <div id='calendar' class="mb-6 w-full sm:w-1/2 mx-auto">
                </div>

                <div class="p-4 bg-slate-200 rounded-lg mb-2">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Attendance Logs</h3>
                    <ul class="list-disc pl-5 mb-6 max-h-[250px] overflow-y-scroll">
                        @foreach ($student->attendanceLogs as $log)
                            <li class="mb-2">
                                <span class="font-medium">Date:</span> {{ $log->attendance_date->format('m-d-Y') }}
                                <span class="font-medium">Time In:</span> {{ $log->time_in }},
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4 bg-slate-200 rounded-lg mb-2">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Borrowed Kits</h3>
                    <ul class="list-disc pl-5 mb-6 max-h-[250px] overflow-y-scroll">
                        @foreach ($student->borrowedKits as $kit)
                            <li class="mb-2">
                                <span class="font-medium">Kit ID:</span> {{ $kit->kit_id }},
                                <span class="font-medium">Quantity Borrowed:</span> {{ $kit->quantity_borrowed }},
                                <span class="font-medium">Borrowed At:</span> {{ $kit->borrowed_at->format('m-d-Y') }}
                            </li>
                        @endforeach
                    </ul>
                </div>



            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    height: 500,
                    initialView: 'dayGridMonth',
                    events: [
                        @foreach ($student->attendanceLogs as $log)
                            {
                                title: 'Present',
                                start: '{{ $log->attendance_date->format('Y-m-d') }}',
                                display: 'background',
                                color: '#79FF4D'
                            },
                        @endforeach
                    ],
                    eventContent: function(arg) {
                        return '';
                    }
                });
                calendar.render();
            });
        </script>
    </body>
</x-layout>
