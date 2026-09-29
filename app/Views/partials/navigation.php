<nav>
    <a href="<?= base_url('/') ?>">Welcome</a> |
    <a href="<?= base_url('tasks') ?>">Task List</a> |
    <a href="<?= base_url('profile') ?>">Profile</a> |
    <a href="<?= base_url('about') ?>">About</a>

    <?php if (session()->get('isLoggedIn')): ?>
        | <a href="<?= base_url('tasks/new') ?>">New Task</a>
        | Logged in as <?= esc((string) session()->get('full_name')) ?>

        <form action="<?= base_url('logout') ?>" method="post" style="display: inline;">
            <?= csrf_field() ?>
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        | <a href="<?= base_url('login') ?>">Login</a>
    <?php endif; ?>
</nav>

<hr>

