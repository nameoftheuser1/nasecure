<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AttendanceLog;
use Carbon\Carbon;

class MarkIncompleteLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-incomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark attendance logs as incomplete if time_out is not set.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        $updated = AttendanceLog::whereDate('attendance_date', $today)
            ->whereNull('time_out')
            ->update(['time_out' => null]);

        $this->info("Marked $updated incomplete logs as incomplete.");

        return 0;
    }
}
