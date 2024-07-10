<!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
<div class="grid grid-cols-7 gap-4 p-10">
    @php
        $weekdays = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
        $firstDayOfWeek = $dates->first()->dayOfWeek; // Get the day of the week for the first date
    @endphp

    <!-- Weekday headers -->
    @foreach ($weekdays as $day)
        <div class="p-4 text-center font-bold text-blue-500">{{ $day }}</div>
    @endforeach

    <!-- Empty placeholders for days before the first day of the month -->
    @for ($i = 0; $i < $firstDayOfWeek; $i++)
        <div></div>
    @endfor

    <!-- Calendar days -->
    @foreach ($dates as $date)
        <div class="p-4 text-center {{ $date->isToday() ? 'bg-blue-200 rounded-full' : '' }}">
            {{ $date->format('d') }}
        </div>
    @endforeach
</div>

<!-- Navigation links -->
<div class="flex justify-between px-10 py-4">
    <a href="?month={{ $currentMonth->copy()->subMonth()->format('Y-m-d') }}"
        class="text-blue-500 hover:text-blue-700">Previous Month</a>
    <a href="?month={{ $currentMonth->copy()->addMonths(1)->format('Y-m-d') }}"
        class="text-blue-500 hover:text-blue-700">Next Month</a>
</div>
