<?php

namespace Jabu\Task\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jabu\Task\Domain\Enums\Period;
use Jabu\Task\Domain\Enums\RecurrenceType;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;

/**
 * Jabu\Task\Domain\Models\Task
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $recurence_type
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $number_of_times
 * @property Period $period
 * @property int|null $month
 * @property int|null $day_of_month
 * @property int|null $day_of_week
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property RecurrenceType $recurrence_type
 * @property-read \Illuminate\Database\Eloquent\Collection|TaskRecurrence[] $recurrences
 * @property-read int|null $recurrences_count
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDayOfMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereNumberOfTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereRecurenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Task extends Model
{
    protected $guarded = [];
    protected $table = 'tasks';

    protected $casts = [
        'recurrence_type' => RecurrenceType::class,
        'period' => Period::class,
        'days' => 'array',
    ];

    public function recurrences() : HasMany
    {
        return $this->hasMany(TaskRecurrence::class);
    }
}
