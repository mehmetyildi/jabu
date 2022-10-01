<?php

namespace Jabu\Task\Domain\Actions;

use App\Http\Livewire\Task\TaskForm;
use Jabu\Task\Domain\Enums\Period;
use Jabu\Task\Domain\Enums\RecurrenceType;
use Jabu\Task\Domain\Models\Task;
use DB;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

final class CreateTaskAction
{
    public static function execute(TaskForm $data) : Task
    {
        return DB::transaction(function () use ($data){
            $daysArray = explode(',', $data->days);
            $task =  Task::create([
                'name' => $data->name,
                'description' => $data->description,
                'recurrence_type' => RecurrenceType::tryFrom($data->recurrenceType),
                'start_date' => $data->startDate,
                'end_date' => $data->endDate,
                'number_of_times' => $data->numberOfTimes,
                'period' => Period::tryFrom($data->period),
                'month' => $data->month,
                'day_of_month' => $data->dayOfMonth,
                'days' => $daysArray
            ]);

            if($data->period === Period::WEEKLY->value){
                CreateWeeklyTaskAction::execute($task, $daysArray, $data->startDate, $data->endDate, $data->numberOfTimes);
            }
            dd(TaskRecurrence::all());
        });
    }
}
