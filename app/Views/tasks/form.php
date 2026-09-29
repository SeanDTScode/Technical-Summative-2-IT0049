<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php $editing = $task !== null; ?>

<h1><?= $editing ? 'Edit Task' : 'New Task' ?></h1>

<?= view('partials/errors') ?>

<form
    action="<?= $editing
        ? base_url('tasks/' . $task['id'])
        : base_url('tasks') ?>"
    method="post"
>
    <?= csrf_field() ?>

    <p>
        <label for="title">Title</label><br>
        <input
            type="text"
            id="title"
            name="title"
            maxlength="150"
            value="<?= esc(old('title', $task['title'] ?? '')) ?>"
            required
        >
    </p>

    <p>
        <label for="status">Status</label><br>

        <?php $selectedStatus = old('status', $task['status'] ?? 'pending'); ?>

        <select id="status" name="status" required>
            <option value="pending" <?= $selectedStatus === 'pending' ? 'selected' : '' ?>>
                Pending
            </option>
            <option value="in progress" <?= $selectedStatus === 'in progress' ? 'selected' : '' ?>>
                In Progress
            </option>
            <option value="completed" <?= $selectedStatus === 'completed' ? 'selected' : '' ?>>
                Completed
            </option>
        </select>
    </p>

    <p>
        <label for="task_date">Task Date</label><br>
        <input
            type="date"
            id="task_date"
            name="task_date"
            value="<?= esc(old('task_date', $task['task_date'] ?? '')) ?>"
            required
        >
    </p>

    <button type="submit">
        <?= $editing ? 'Update Task' : 'Create Task' ?>
    </button>

    <a href="<?= base_url('tasks') ?>">Cancel</a>
</form>

<?= $this->endSection() ?>

