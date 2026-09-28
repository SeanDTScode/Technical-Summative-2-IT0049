<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>New User</title>
</head>
<body>

<?= view('navigation') ?>

<h1>New User</h1>

<?php $errors = session()->getFlashdata('errors'); ?>

<?php if (! empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/users/create" method="post">
    <?= csrf_field() ?>

    <p>
        <label for="username">Username</label><br>

        <input
            type="text"
            id="username"
            name="username"
            maxlength="50"
            value="<?= esc(old('username')) ?>"
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
            value="<?= esc(old('full_name')) ?>"
            required
        >
    </p>

    <p>
        <label for="password">Password</label><br>

        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            autocomplete="new-password"
            required
        >
    </p>

    <button type="submit">Save User</button>

    <a href="/users">Cancel</a>
</form>

</body>
</html>