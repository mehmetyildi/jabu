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

class CreateWeeklyTaskTest extends TestCase
{
    protected array $days = [];
    protected const NUMBER_OF_TIMES = 20;
    protected const START_DATE = '2022-10-01';
    protected const END_DATE = '2022-10-30';
    protected const NUMBER_OF_TIMES_WITH_INTERVAL = 4;

    protected function setUp(): void
    {
        parent::setUp();
        $now = Carbon::parse('2022-10-01');
        Carbon::setTestNow($now);
        $this->days = ['2022-10-03', '2022-10-04', '2022-10-05'];
    }

    public function testCreateTaskWithNumberOfTimes(): void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);
        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::NUMBER_OF_TIMES->value)
            ->set('period', Period::WEEKLY->value)
            ->set('numberOfTimes', self::NUMBER_OF_TIMES)
            ->set('days', '1,2,3')
            ->set('name', self::TASK_NAME)
            ->set('description', self::TASK_DESCRIPTION)
            ->call('submit')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'name' => self::TASK_NAME,
            'description' => self::TASK_DESCRIPTION
        ]);

        $task = Task::whereName(self::TASK_NAME)->first();

        self::assertEquals(self::NUMBER_OF_TIMES * 3, $task->recurrences->count());

        for ($i = 0; $i < self::NUMBER_OF_TIMES; $i++ ){
            foreach ($this->days as $day){
                self::assertNotNull(TaskRecurrence::where('date', $day)->first());
            }
            array_map(static fn($d) => Carbon::parse($d)->addDays(7)->toDateString(), $this->days);
        }
    }

    public function testCreateTaskWithInterval() : void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);
        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::INTERVAL->value)
            ->set('period', Period::WEEKLY->value)
            ->set('startDate', self::START_DATE)
            ->set('endDate', self::END_DATE)
            ->set('days', '1,2,3')
            ->set('name', self::TASK_NAME)
            ->set('description', self::TASK_DESCRIPTION)
            ->call('submit')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'name' => self::TASK_NAME,
            'description' => self::TASK_DESCRIPTION
        ]);

        $task = Task::whereName(self::TASK_NAME)->first();

        self::assertEquals(self::NUMBER_OF_TIMES_WITH_INTERVAL * 3, $task->recurrences->count());

        for ($i = 0; $i < self::NUMBER_OF_TIMES_WITH_INTERVAL; $i++ ){
            foreach ($this->days as $day){
                self::assertNotNull(TaskRecurrence::where('date', $day)->first());
            }
            array_map(static fn($d) => Carbon::parse($d)->addDays(7)->toDateString(), $this->days);
        }
    }

    public function testCanNotCreateWithoutRequiredFields() : void
    {
        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME
        ]);
        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::INTERVAL->value)
            ->set('period', Period::WEEKLY->value)
            ->set('startDate', self::START_DATE)
            ->set('days', '1,2,3')
            ->set('description', self::TASK_DESCRIPTION)
            ->call('submit')
            ->assertHasErrors(['name', 'endDate']);

        Livewire::test(TaskForm::class)
            ->set('recurrenceType', RecurrenceType::NUMBER_OF_TIMES->value)
            ->set('period', Period::WEEKLY->value)
            ->set('days', '1,2,3')
            ->set('name', self::TASK_NAME)
            ->call('submit')
            ->assertHasErrors(['numberOfTimes', 'description']);

        $this->assertDatabaseMissing('tasks', [
            'name' => self::TASK_NAME,
            'description' => self::TASK_DESCRIPTION
        ]);
    }
}
