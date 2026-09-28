<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

<?= view('navigation') ?>

<h1>Demo User Profile</h1>

<?php if ($user !== null): ?>

    <p><strong>ID:</strong> <?= esc($user['id']) ?></p>
    <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
    <p><strong>Full Name:</strong> <?= esc($user['full_name']) ?></p>
    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
    <p><strong>Created At:</strong> <?= esc($user['created_at']) ?></p>

<?php else: ?>

    <p>No user record found.</p>

<?php endif; ?>

</body>
</html>