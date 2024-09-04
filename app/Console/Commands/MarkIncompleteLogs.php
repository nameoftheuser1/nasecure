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
    protected $description = 'Mark attendance logs as incomplete if time_out is not set within 3 hours.';

    /**
     * Execute the console command.
     *
     * @return int
     */

     /*unused*/
    // public function handle()
    // {
    //     $threeHoursAgo = Carbon::now()->subHours(3);

    //     $updated = AttendanceLog::where('time_in', '<=', $threeHoursAgo)
    //         ->whereNull('time_out')
    //         ->update(['time_out' => null]);

    //     $this->info("Marked $updated incomplete logs as incomplete.");

    //     return 0;
    // }
}
