<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
</head>
<body>

<?= view('navigation') ?>

<h1>Edit Customer</h1>

<?= view('partials/errors') ?>

<form
    action="/customers/<?= esc($customer['id']) ?>/update"
    method="post"
>
    <?= csrf_field() ?>

    <p>
        <label for="full_name">Full Name</label><br>
        <input
            type="text"
            id="full_name"
            name="full_name"
            maxlength="100"
            value="<?= old('full_name', $customer['full_name']) ?>"
            required
        >
    </p>

    <p>
        <label for="email">Email</label><br>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?= old('email', $customer['email']) ?>"
            required
        >
    </p>

    <p>
        <label for="phone">Phone</label><br>
        <input
            type="text"
            id="phone"
            name="phone"
            maxlength="20"
            value="<?= old('phone', $customer['phone']) ?>"
        >
    </p>

    <button type="submit">Update Customer</button>
    <a href="/customers">Cancel</a>
</form>

</body>
</html>