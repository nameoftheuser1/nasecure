<x-layout>
    <x-sidebar />
    <div class="container mx-auto p-5 bg-gray-100 rounded-3xl flex flex-col items-center">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Section Details</h1>
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

            <div id="attendance-container" class="w-full mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Attendance Logs by Date</h2>
                <div class="text-center py-6">
                    <p class="text-gray-600">Please select a date to view attendance logs.</p>
                </div>
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
        function filterAttendanceByDate(date) {
            const sectionId = {{ $section->id }};
            fetch(`/sections/${sectionId}/attendance?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('attendance-container');
                    if (data.logs.length > 0) {
                        let html = `
                            <h2 class="text-2xl font-bold mb-4 text-gray-800">Attendance Logs for ${data.date}</h2>
                            <p class="text-gray-600 mb-4">Present: ${data.present}/${data.studentCount}</p>
                            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <tr>
                                            <th class="py-3 px-6 text-left">Student Name</th>
                                            <th class="py-3 px-6 text-left">Present</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                        `;
                        data.logs.forEach(log => {
                            html += `
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">${log.student.name}</td>
                                    <td class="py-3 px-6 text-left">${log.present ? 'Yes' : 'No'}</td>
                                </tr>
                            `;
                        });
                        html += `</tbody></table></div>`;
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `
                            <div class="text-center py-6">
                                <p class="text-gray-600">No attendance logs available for ${data.date}.</p>
                            </div>
                        `;
                    }
                });
        }
    </script>
</x-layout>
