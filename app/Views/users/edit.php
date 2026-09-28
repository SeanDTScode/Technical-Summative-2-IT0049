<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit User</title>
</head>
<body>

<?= view('navigation') ?>

<h1>Edit User</h1>

<?php $errors = session()->getFlashdata('errors'); ?>

<?php if (! empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
$hasAvatar = ! empty($user['avatar'])
    && is_file(
        FCPATH . 'uploads/avatars/' . $user['avatar']
    );

$avatarUrl = $hasAvatar
    ? '/uploads/avatars/' . rawurlencode($user['avatar'])
    : '/images/avatar-placeholder.svg';
?>

<img
    src="<?= esc($avatarUrl) ?>"
    alt="Current user avatar"
    width="120"
    height="120"
    style="object-fit: cover; border-radius: 50%;"
>

<form
    action="/users/<?= esc($user['id']) ?>/update"
    method="post"
    enctype="multipart/form-data"
>
    <?= csrf_field() ?>

    <p>
        <label for="username">Username</label><br>

        <input
            type="text"
            id="username"
            name="username"
            maxlength="50"
            value="<?= esc(old(
                'username',
                $user['username']
            )) ?>"
            required
        >
    </p>

    <p>
        <label for="full_name">Full Name</label><br>

        <input
            type="text"
            id="full_name"
            name="full_name"
            maxlength="100"
            value="<?= esc(old(
                'full_name',
                $user['full_name']
            )) ?>"
            required
        >
    </p>

    <p>
        <label for="password">New Password</label><br>

        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            autocomplete="new-password"
        >

        <br>

        <small>
            Leave this blank to keep the existing password.
        </small>
    </p>

    <p>
        <label for="avatar">New Avatar</label><br>

        <input
            type="file"
            id="avatar"
            name="avatar"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        >

        <br>

        <small>
            JPG or PNG only, maximum 2MB.
        </small>
    </p>

    <button type="submit">Update User</button>

    <a href="/users">Cancel</a>
</form>

</body>
</html>