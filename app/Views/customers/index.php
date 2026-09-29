<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading">
    <div><h1>Customers</h1><p>Manage customer account information.</p></div>
    <a class="button primary" href="<?= base_url('customers/new') ?>">Add Customer</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= esc($customer['full_name']) ?></td>
            <td><?= esc($customer['email']) ?></td>
            <td><?= esc($customer['phone'] ?? '—') ?></td>
            <td><?= esc($customer['created_at']) ?></td>
            <td class="actions">
                <a class="button" href="<?= base_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a>
                <form action="<?= base_url('customers/' . $customer['id'] . '/delete') ?>" method="post"
                      onsubmit="return confirm('Delete this customer? Past sales will remain as walk-in sales.');">
                    <?= csrf_field() ?><button class="button danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if ($customers === []): ?><tr><td colspan="5">No customers found.</td></tr><?php endif; ?>
    </tbody>
</table>
</div>
<?= $this->endSection() ?>

