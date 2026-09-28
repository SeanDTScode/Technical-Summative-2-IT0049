<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>POS Login</title>
</head>
<body>

<h1>POS Login</h1>

<?php if ($error = session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc($error) ?>
    </p>
<?php endif; ?>

<?php $errors = session()->getFlashdata('errors'); ?>

<?php if (! empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $validationError): ?>
            <li><?= esc($validationError) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/login" method="post">
    <?= csrf_field() ?>

    <p>
        <label for="username">Username</label><br>

        <input
            type="text"
            id="username"
            name="username"
            maxlength="50"
            value="<?= esc(old('username')) ?>"
            autocomplete="username"
            required
        >
    </p>

    <p>
        <label for="password">Password</label><br>

        <input
            type="password"
            id="password"
            name="password"
            autocomplete="current-password"
            required
        >
    </p>

    <button type="submit">Log In</button>
</form>

</body>
</html>