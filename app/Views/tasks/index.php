<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Task List</h1>

<?php if (session()->get('isLoggedIn')): ?>
    <p><a href="<?= base_url('tasks/new') ?>">Add New Task</a></p>
<?php endif; ?>

<?php if ($tasks === []): ?>
    <p>No active tasks found.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Task Date</th>
                <th>Created At</th>
                <?php if (session()->get('isLoggedIn')): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= esc($task['id']) ?></td>
                    <td><?= esc($task['title']) ?></td>
                    <td><?= esc($task['status']) ?></td>
                    <td><?= esc($task['task_date']) ?></td>
                    <td><?= esc($task['created_at']) ?></td>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <td>
                            <a href="<?= base_url('tasks/' . $task['id'] . '/edit') ?>">
                                Edit
                            </a>

                            <form
                                action="<?= base_url('tasks/' . $task['id'] . '/archive') ?>"
                                method="post"
                                style="display: inline;"
                                onsubmit="return confirm('Archive this task?');"
                            >
                                <?= csrf_field() ?>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?= $this->endSection() ?>

