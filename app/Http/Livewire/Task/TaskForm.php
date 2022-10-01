<?php

namespace App\Http\Livewire\Task;

use Carbon\Carbon;
use Illuminate\View\View;
use Jabu\Task\Domain\Actions\CreateTaskAction;
use Jabu\Task\Domain\Enums\Period;
use Jabu\Task\Domain\Enums\RecurrenceType;
use Jabu\Task\Domain\Models\Task;
use Livewire\Component;
use Livewire\Redirector;

class TaskForm extends Component
{
    public ?Task $task = null;
    public ?string $recurrenceType = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $period = null;
    public ?int $month = null;
    public ?int $dayOfMonth = null;
    public ?int $numberOfTimes = null;
    public mixed $days = '';

    public function render() : View
    {
        return view('livewire.task.task-form');
    }

    public function updatedRecurrenceType()
    {
        $this->numberOfTimes = null;
        $this->startDate = null;
        $this->endDate = null;
    }

    public function updatedPeriod()
    {
        $this->days = '';
        $this->month = null;
        $this->dayOfMonth = null;
    }

    protected function rules() : array
    {
        $today = Carbon::now()->toDateString();
        return [
            'task' => 'nullable',
            'recurrenceType' => 'required|in:' . implode(',', RecurrenceType::caseValues()),
            'period' => 'required|in:' . implode(',', Period::caseValues()),
            'startDate' => 'nullable|date|required_if:recurrenceType,' . RecurrenceType::INTERVAL->value . '|after_or_equal:' . $today,
            'endDate' => 'nullable|date|required_if:recurrenceType,' . RecurrenceType::INTERVAL->value . '|after_or_equal:startDate',
            'numberOfTimes' => 'nullable|numeric|gt:0|required_if:recurrenceType,' . RecurrenceType::NUMBER_OF_TIMES->value,
            'name' => 'required|string',
            'description' => 'required|string',
            'month' => 'required_if:period,' . Period::YEARLY->value,
            'dayOfMonth' => 'nullable|numeric|required_unless:period,' . Period::WEEKLY->value . '|lte:31',
            'days' => 'required_if:period,' . Period::WEEKLY->value,
        ];
    }

    public function submit() : Redirector
    {
        $this->validate($this->rules());
        CreateTaskAction::execute($this);
        return redirect()->route('tasks.index');
    }
}
