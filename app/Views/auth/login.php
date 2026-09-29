<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Login</h1>

<?= view('partials/errors') ?>

<form action="<?= base_url('login') ?>" method="post">
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

    <button type="submit">Login</button>
</form>

<?= $this->endSection() ?>

