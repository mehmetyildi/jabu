<?php

namespace App\Http\Livewire\Task;

use App\Http\Livewire\LivewireDatatable;
use Illuminate\View\View;
use Jabu\Task\Domain\Enums\Timeframe;
use Jabu\Task\Domain\Services\TaskService;
use Livewire\Redirector;

final class TaskList extends LivewireDatatable
{
    public string $sortField = 'id';
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
        $product = Product::find($id);
        DeleteProductAction::execute($product);
        session()->flash('danger', 'Product is successfully deleted');
        return redirect()->route('products.index');
    }
}
