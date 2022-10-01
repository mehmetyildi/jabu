<?php

namespace Jabu\Task\Domain\Actions;

use Carbon\Carbon;
use Jabu\Task\Domain\Models\Task;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

class CreateMonthlyTaskAction
{
    public static function execute(Task $task, int $dayOfMonth, ?string $startDate, ?string $endDate, ?int $numberOfTimes) : void
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $thisMonthsSchedule = $thisMonth->addDays($dayOfMonth - 1);
        $schedule = $thisMonthsSchedule;

        if($numberOfTimes){
            if($schedule->lt(Carbon::now()->startOfDay())){
                $schedule = $schedule->addMonth();
            }
            for ($i = 0; $i < $numberOfTimes; $i ++){
                TaskRecurrence::create([
                    'task_id' => $task->id,
                    'date' => $schedule->toDateString(),
                ]);
                $schedule->addMonth();
            }
        }else{
            if($thisMonthsSchedule->lt(Carbon::parse($startDate))){
                $schedule = $schedule->addMonth();
            }
            while($schedule->lte(Carbon::parse($endDate))){
                TaskRecurrence::create([
                    'task_id' => $task->id,
                    'date' => $schedule->toDateString(),
                ]);
                $schedule = $schedule->addMonth();
            }
        }
    }
}
