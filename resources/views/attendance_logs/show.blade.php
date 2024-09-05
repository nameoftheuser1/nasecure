<x-layout>
    <x-sidebar />
    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-yellow-500" />
    @elseif(session('deleted'))
        <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500" />
    @elseif(session('error'))
        <x-flashMsg msg="{{ session('error') }}" bg="bg-red-500" />
    @endif
    <div class="container mx-auto p-5 bg-gray-100 rounded-3xl flex flex-col items-center">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Attendance Logs</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Section Name</p>
                        <p class="text-lg font-medium text-gray-800">{{ $section->section_name }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Course Name</p>
                        <p class="text-lg font-medium text-gray-800">
                            {{ $section && $section->course ? $section->course->course_name : '' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Created By</p>
                        <p class="text-lg font-medium text-gray-800">{{ $section->created_by }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 font-semibold">Number of Students</p>
                        <p class="text-lg font-medium text-gray-800">{{ $section->student_count }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full mt-6">
                <label for="attendance-date" class="block text-sm font-medium text-gray-700">Select Date</label>
                <input type="date" id="attendance-date" name="attendance_date"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    onchange="filterAttendanceByDate(this.value)">
            </div>

            <div id="error-container" class="w-full mt-4 hidden">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline" id="error-message"></span>
                </div>
            </div>

            <div id="attendance-container" class="w-full mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Attendance Logs by Date</h2>
                <div class="text-center py-6">
                    <p class="text-gray-600">Please select a date to view attendance logs.</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="#" id="download-pdf-link"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 me-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Download PDF
                </a>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('sections.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-full shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <script>
        function updatePdfLink(date) {
            const downloadLink = document.getElementById('download-pdf-link');
            const sectionId = {{ $section->id }};
            downloadLink.href = `/attendance_logs/${sectionId}/pdf?date=${date}`;
        }

        function filterAttendanceByDate(date) {
            const sectionId = {{ $section->id }};
            const errorContainer = document.getElementById('error-container');
            const errorMessage = document.getElementById('error-message');
            const attendanceContainer = document.getElementById('attendance-container');

            updatePdfLink(date);

            fetch(`/sections/${sectionId}/attendance?date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    errorContainer.classList.add('hidden');
                    let html;
                    if (data.logs.length > 0) {
                        html = `
                            <h2 class="text-2xl font-bold mb-4 text-gray-800">Attendance Logs for ${data.date}</h2>
                            <p class="text-gray-600 mb-4">Total Attendance Logs for ${data.date}: ${data.logs.length} / ${data.studentCount}</p>
                            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <tr>
                                            <th class="py-3 px-6 text-left">Student Name</th>
                                            <th class="py-3 px-6 text-left">Time In</th>
                                            <th class="py-3 px-6 text-left">Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                        `;
                        data.logs.forEach(log => {
                            html += `
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">${log.student ? log.student.name : 'N/A'}</td>
                                    <td class="py-3 px-6 text-left">${new Date(log.time_in).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'})}</td>
                                    <td class="py-3 px-6 text-left">
                                    ${log.time_out ? new Date(log.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }) : 'Time Out Not Found'}
                                    </td>
                                </tr>
                            `;
                        });
                        html += `</tbody></table></div>`;
                    } else {
                        html = `
                            <div class="text-center py-6">
                                <p class="text-gray-600">No attendance logs available for ${data.date}.</p>
                            </div>
                        `;
                    }
                    attendanceContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.textContent =
                        `Failed to load attendance data: ${error.message}. Please try again later.`;
                    errorContainer.classList.remove('hidden');
                    attendanceContainer.innerHTML = '';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('attendance-date');

            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;

            filterAttendanceByDate(today);
        });
    </script>

</x-layout>
