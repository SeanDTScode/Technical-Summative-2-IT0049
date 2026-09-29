<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Welcome extends BaseController
{
    public function index()
    {
        $today = date('Y-m-d');

        $tasks = (new TaskModel())
            ->where('task_date', $today)
            ->where('is_archived', 0)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('welcome', [
            'today' => $today,
            'tasks' => $tasks,
        ]);
    }
}

