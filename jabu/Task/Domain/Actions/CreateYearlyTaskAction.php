<?php

namespace Jabu\Task\Domain\Actions;

use Carbon\Carbon;
use Jabu\Task\Domain\Enums\Month;
use Jabu\Task\Domain\Models\Task;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

final class CreateYearlyTaskAction
{
    public static function execute(Task $task, int $month, int $dayOfMonth, ?string $startDate, ?string $endDate, ?int $numberOfTimes) : void
    {
        $monthName = Month::tryFrom($month)->name;
        $monthDate = new Carbon('first day of ' . $monthName);
        $thisYearsSchedule = $monthDate->addDays($dayOfMonth - 1);
        $schedule = $thisYearsSchedule;
        if($numberOfTimes){
            if($thisYearsSchedule->lt(Carbon::now())) {
                $schedule = $schedule->addYear();
            }
            for ($i = 0; $i < $numberOfTimes; $i++){
                TaskRecurrence::create([
                    'task_id' => $task->id,
                    'date' => $schedule->toDateString(),
                ]);
                $schedule = $schedule->addYear();
            }
        }else{
            if($thisYearsSchedule->lt(Carbon::parse($startDate))){
                $schedule = $schedule->addYear();
            }
            while($schedule->lte(Carbon::parse($endDate))){
                TaskRecurrence::create([
                    'task_id' => $task->id,
                    'date' => $schedule->toDateString(),
                ]);
                $schedule = $schedule->addYear();
            }
        }
    }
}
