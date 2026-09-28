<nav>
    <a href="/">Home</a> |
    <a href="/about">About</a>

    <?php if (session()->get('isLoggedIn')): ?>
        |
        <a href="/customers">Customers</a>
        |
        <a href="/users">Users</a>

        <span>
            | Logged in as
            <?= esc(session()->get('full_name')) ?>
        </span>

        <form
            action="/logout"
            method="post"
            style="display: inline;"
        >
            <?= csrf_field() ?>

            <button type="submit">
                Log Out
            </button>
        </form>
    <?php else: ?>
        |
        <a href="/login">Log In</a>
    <?php endif; ?>
</nav>

<hr>