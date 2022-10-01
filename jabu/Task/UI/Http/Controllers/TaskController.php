<?php

namespace Jabu\Task\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TaskController extends  Controller
{
    public function index() : View
    {
        return view('tasks.index');
    }

    public function create() : View
    {
        return view('tasks.create');
    }
}
