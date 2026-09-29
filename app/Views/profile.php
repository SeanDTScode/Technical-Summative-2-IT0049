<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Demo User Profile</h1>

<?php if ($user === null): ?>
    <p>No demo user was found.</p>
<?php else: ?>
    <p><strong>ID:</strong> <?= esc($user['id']) ?></p>
    <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
    <p><strong>Full Name:</strong> <?= esc($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
    <p><strong>Created At:</strong> <?= esc($user['created_at']) ?></p>
<?php endif; ?>

<?= $this->endSection() ?>

