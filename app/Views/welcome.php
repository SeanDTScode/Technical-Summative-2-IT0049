<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Tasks for Today</h1>

<p>Date: <?= esc($today) ?></p>

<?php if ($tasks === []): ?>
    <p>No tasks are scheduled for today.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Task Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= esc($task['title']) ?></td>
                    <td><?= esc($task['status']) ?></td>
                    <td><?= esc($task['task_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?= $this->endSection() ?>

