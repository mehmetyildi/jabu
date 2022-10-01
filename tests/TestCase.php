<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected const TASK_NAME = 'New Task';
    protected const TASK_DESCRIPTION = 'New Task Description';

    use CreatesApplication;
    use RefreshDatabase;
}
