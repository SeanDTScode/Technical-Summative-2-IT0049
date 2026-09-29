<?php

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Tasks extends BaseController
{
    public function index()
    {
        return view('tasks/index', [
            'tasks' => (new TaskModel())
                ->where('is_archived', 0)
                ->orderBy('task_date', 'ASC')
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function new()
    {
        return view('tasks/form', [
            'task' => null,
        ]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        (new TaskModel())->insert([
            'title' => trim(
                (string) $this->request->getPost('title')
            ),
            'status' => (string) $this->request->getPost('status'),
            'task_date' => (string) $this->request->getPost('task_date'),
            'created_at' => date('Y-m-d H:i:s'),
            'is_archived' => 0,
        ]);

        return redirect()
            ->to('/tasks')
            ->with('message', 'Task created successfully.');
    }

    public function edit(int $id)
    {
        $task = (new TaskModel())
            ->where('id', $id)
            ->where('is_archived', 0)
            ->first();

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound(
                'Task not found.'
            );
        }

        return view('tasks/form', [
            'task' => $task,
        ]);
    }

    public function update(int $id)
    {
        $model = new TaskModel();

        $task = $model
            ->where('id', $id)
            ->where('is_archived', 0)
            ->first();

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound(
                'Task not found.'
            );
        }

        if (! $this->validate($this->rules())) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'title' => trim(
                (string) $this->request->getPost('title')
            ),
            'status' => (string) $this->request->getPost('status'),
            'task_date' => (string) $this->request->getPost('task_date'),
        ]);

        return redirect()
            ->to('/tasks')
            ->with('message', 'Task updated successfully.');
    }

    public function archive(int $id)
    {
        $model = new TaskModel();

        $task = $model
            ->where('id', $id)
            ->where('is_archived', 0)
            ->first();

        if ($task === null) {
            throw PageNotFoundException::forPageNotFound(
                'Task not found.'
            );
        }

        $model->update($id, [
            'is_archived' => 1,
        ]);

        return redirect()
            ->to('/tasks')
            ->with('message', 'Task archived successfully.');
    }

    private function rules(): array
    {
        return [
            'title' => 'required|max_length[150]',
            'status' => 'required|in_list[pending,in progress,completed]',
            'task_date' => 'required|valid_date[Y-m-d]',
        ];
    }
}

