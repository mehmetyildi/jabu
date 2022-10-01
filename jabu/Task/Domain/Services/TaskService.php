<?php

namespace Jabu\Task\Domain\Services;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Jabu\Task\Domain\Enums\Timeframe;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

class TaskService
{
    public function getAllPaginated(int $perPage, string $sortField, bool $sortAsc, Timeframe $timeframe) : LengthAwarePaginator
    {
        $query = TaskRecurrence::query();
        $today = Carbon::today()->toDateString();
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();
        $startOfNextWeek = Carbon::parse($startOfWeek)->addWeek()->toDateString();
        $endOfNextWeek = Carbon::parse($endOfWeek)->addWeek()->toDateString();
        $query = match ($timeframe){
            Timeframe::TODAY => $query::whereDate(Carbon::today()->toDateString()),
            Timeframe::THIS_WEEK => $query->where('date', '>=', $today)->where('date', '<=', $endOfNextWeek),
            Timeframe::NEXT_WEEK => $query->where('date', '>=', $startOfNextWeek)->where('date', '<=', $endOfNextWeek),
            default => $query
        };

        return $query->orderBy($sortField, $sortAsc ? 'asc' : 'desc')->paginate($perPage);
    }

}
