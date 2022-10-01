<?php

namespace Jabu\Task\Domain\Actions;

use Jabu\Task\Domain\Models\Task;

class DeleteTaskAction
{
    public static function execute(Task $task) : void
    {
        $task->delete();
    }
}
