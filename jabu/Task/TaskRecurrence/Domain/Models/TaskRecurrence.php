<?php

namespace Jabu\Task\TaskRecurrence\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jabu\Task\Domain\Models\Task;

/**
 * Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence
 *
 * @property int $id
 * @property int $task_id
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecurrence whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskRecurrence extends Model
{
    protected $table = 'task_recurrences';
    protected $guarded = [];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
