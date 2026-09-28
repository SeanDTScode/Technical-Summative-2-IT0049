<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Accounts</title>
</head>
<body>

<?= view('navigation') ?>

<h1>Customer Accounts</h1>

<p><a href="/customers/new">Add New Customer</a></p>

<?php if ($message = session()->getFlashdata('message')): ?>
    <p style="color: green;"><?= esc($message) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['id']) ?></td>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone']) ?></td>
                <td>
                    <a href="/customers/<?= esc($customer['id']) ?>/edit">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>