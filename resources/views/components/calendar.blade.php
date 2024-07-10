<?php
use Carbon\Carbon;
?>

@php
    $currentMonthName = Carbon::now()->format('F');
    $currentYear = Carbon::now()->format('Y');
    $weekdays = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
    $firstDayOfWeek = $dates->first()->dayOfWeek;
@endphp

<div class="w-[800px] mx-auto bg-gray-200 border-2 border-blue-600 rounded-3xl pb-5">
    <div class="pt-5 px-16 flex justify-between">
        <div class="font-bold font-mono text-xl">{{ $currentMonthName . ' ' . $currentYear }}</div>
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-6 w-6 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
        </p>
    </div>

    <div class="grid grid-cols-7 gap-3 p-5">
        @foreach ($weekdays as $day)
            <div class="p-2 text-sm text-center font-bold text-blue-700">{{ $day }}</div>
        @endforeach

        @for ($i = 0; $i < $firstDayOfWeek; $i++)
            <div></div>
        @endfor

        @foreach ($dates as $date)
            <div class="p-2 text-center text-xs {{ $date->isToday() ? 'bg-blue-600 text-white rounded-full' : '' }}">
                {{ $date->format('d') }}
            </div>
        @endforeach
    </div>
</div>
