<?php

namespace Jabu\Task\Domain\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Jabu\Task\Domain\Models\Task;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

final class CreateWeeklyTaskAction
{
    public static function execute(Task $task, array $days, ?string $startDate, ?string $endDate, ?int $numberOfTimes): void
    {
        $dayOfWeek = Carbon::now()->dayOfWeek;
        $startOfWeek = Carbon::now()->startOfWeek();
        if ($numberOfTimes) {
            foreach ($days as $day) {
                for ($i = 0; $i < $numberOfTimes; $i++) {
                    if (($i === 0) && $day < $dayOfWeek) {
                        $day += 7;
                    }
                    TaskRecurrence::create([
                        'task_id' => $task->id,
                        'date' => Carbon::parse($startOfWeek)->addDays($day - 1)
                    ]);
                    $day += 7;
                }
            }
        } else {
            foreach ($days as $day) {
                $isFirstIteration = true;
                while (Carbon::parse($endDate)->diffInDays() >= $day) {
                    if ($isFirstIteration && Carbon::parse($startOfWeek)->addDays($day)->lt(Carbon::parse($startDate))) {
                        $isFirstIteration = false;
                        $day += 7;
                        continue;
                    }
                    $isFirstIteration = false;
                    TaskRecurrence::create([
                        'task_id' => $task->id,
                        'date' => Carbon::parse($startOfWeek)->addDays($day - 1)
                    ]);
                    $day += 7;
                }
            }
        }
    }
}
