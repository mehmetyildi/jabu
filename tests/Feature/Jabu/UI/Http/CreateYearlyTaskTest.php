<?php

namespace Tests\Feature\Jabu\UI\Http;

use App\Http\Livewire\Task\TaskForm;
use Carbon\Carbon;
use Jabu\Task\Domain\Enums\Period;
use Jabu\Task\Domain\Enums\RecurrenceType;
use Jabu\Task\Domain\Models\Task;
use Jabu\Task\TaskRecurrence\Domain\Models\TaskRecurrence;
use Livewire\Livewire;
use Tests\TestCase;

class CreateYearlyTaskTest extends TestCase
{
    protected const MONTH = 11;
    protected const DAY = 1;
    protected const NUMBER_OF_TIMES = 5;
    protected const START_DATE = '2022-10-01';
    protected const END_DATE = '2032-10-01';
    protected const NUMBER_OF_TIMES_WITH_INTERVAL = 10;

    protected function setUp(): void
    {
        parent::setUp();
        $now = Carbon::parse('2022-10-01');
        Carbon::setTestNow($now);
    }

    public function testCreateWithNumberOfTimes() : void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);

        Livewire::test(TaskForm::class)
            ->set('name', self::TASK_NAME)
            ->set('description', self::TASK_DESCRIPTION)
            ->set('recurrenceType', RecurrenceType::NUMBER_OF_TIMES->value)
            ->set('numberOfTimes', self::NUMBER_OF_TIMES)
            ->set('period', Period::YEARLY->value)
            ->set('month', self::MONTH)
            ->set('dayOfMonth', self::DAY)
            ->call('submit')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'name' => self::TASK_NAME
        ]);
        $date = '2022-11-01';
        for ($i = 0; $i < self::NUMBER_OF_TIMES; $i++){
            self::assertNotNull(TaskRecurrence::where('date', $date)->first());
            Carbon::parse($date)->addYear()->toDateString();
        }
    }

    public function testCreateTaskWithInterval() : void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);
        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::INTERVAL->value)
            ->set('period', Period::YEARLY->value)
            ->set('startDate', self::START_DATE)
            ->set('endDate', self::END_DATE)
            ->set('month', self::MONTH)
            ->set('dayOfMonth', self::DAY)
            ->set('name', self::TASK_NAME)
            ->set('description', self::TASK_DESCRIPTION)
            ->call('submit')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'name' => self::TASK_NAME,
            'description' => self::TASK_DESCRIPTION
        ]);

        $task = Task::whereName(self::TASK_NAME)->first();

        self::assertEquals(self::NUMBER_OF_TIMES_WITH_INTERVAL, $task->recurrences->count());

        $date = '2022-11-01';
        for ($i = 0; $i < self::NUMBER_OF_TIMES_WITH_INTERVAL; $i++ ){
            self::assertNotNull(TaskRecurrence::where('date', $date)->first());
            Carbon::parse($date)->addYear()->toDateString();
        }
    }

    public function testCanNotCreateWithoutRequiredFields() : void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);
        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::INTERVAL->value)
            ->set('period', Period::YEARLY->value)
            ->set('startDate', self::START_DATE)
            ->set('description', self::TASK_DESCRIPTION)
            ->call('submit')
            ->assertHasErrors(['name', 'endDate', 'month', 'dayOfMonth']);

        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::NUMBER_OF_TIMES->value)
            ->set('period', Period::YEARLY->value)
            ->set('month', self::MONTH)
            ->set('dayOfMonth', self::DAY)
            ->set('name', self::TASK_NAME)
            ->call('submit')
            ->assertHasErrors(['numberOfTimes', 'description']);

        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME,
            'description' => self::TASK_DESCRIPTION
        ]);
    }

}
