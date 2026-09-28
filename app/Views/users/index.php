<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Accounts</title>
</head>
<body>

<?= view('navigation') ?>

<h1>User Accounts</h1>

<p><a href="/users/new">Add New User</a></p>

<?php if ($message = session()->getFlashdata('message')): ?>
    <p style="color: green;"><?= esc($message) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Avatar</th>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <?php
            $hasAvatar = ! empty($user['avatar'])
                && is_file(
                    FCPATH . 'uploads/avatars/' . $user['avatar']
                );

            $avatarUrl = $hasAvatar
                ? '/uploads/avatars/' . rawurlencode($user['avatar'])
                : '/images/avatar-placeholder.svg';
            ?>

            <tr>
                <td>
                    <img
                        src="<?= esc($avatarUrl, 'attr') ?>"
                        alt="<?= esc($user['full_name'], 'attr') ?>"
                        width="70"
                        height="70"
                        style="object-fit: cover; border-radius: 50%;"
                    >
                </td>

                <td><?= esc($user['id']) ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>

                <td>
                    <a href="/users/<?= esc($user['id']) ?>/edit">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>