<?php

namespace App\Http\Livewire\Task;

use App\Http\Livewire\LivewireDatatable;
use Illuminate\View\View;
use Jabu\Task\Domain\Actions\DeleteTaskAction;
use Jabu\Task\Domain\Enums\Timeframe;
use Jabu\Task\Domain\Models\Task;
use Jabu\Task\Domain\Services\TaskService;
use Livewire\Redirector;

final class TaskList extends LivewireDatatable
{
    public string $sortField = 'date';
    public ?string $timeframe = 'all';

    protected TaskService $service;

    public function render() : View
    {
        $this->service = app(TaskService::class);
        return view('livewire.task.task-list',
            [
                'records' => $this->service->getAllPaginated(
                    $this->showPerPage,
                    $this->sortField,
                    $this->sortAsc,
                    Timeframe::tryFrom($this->timeframe)
                )
            ]
        );
    }

    public function search() : void
    {
        $this->resetPage();
        $this->render();
    }

    public function delete(int $id) : Redirector
    {
        $task = Task::find($id);
        DeleteTaskAction::execute($task);
        session()->flash('danger', 'Task is successfully deleted');
        return redirect()->route('tasks.index');
    }
}
