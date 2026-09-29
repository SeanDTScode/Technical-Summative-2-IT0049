<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading">
    <div><h1>Sales History</h1><p>Completed POS transactions.</p></div>
    <a class="button primary" href="<?= base_url('sales/new') ?>">Record Sale</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>Date</th><th>Product</th><th>Customer</th><th>Staff</th><th>Quantity</th><th>Total</th></tr></thead>
    <tbody>
    <?php foreach ($sales as $sale): ?>
        <tr>
            <td><?= esc($sale['created_at']) ?></td>
            <td><?= esc($sale['product_name']) ?></td>
            <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
            <td><?= esc($sale['staff_name']) ?></td>
            <td><?= esc($sale['quantity']) ?></td>
            <td>₱<?= number_format((float) $sale['total_price'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if ($sales === []): ?><tr><td colspan="6">No sales recorded.</td></tr><?php endif; ?>
    </tbody>
</table>
</div>
<?= $this->endSection() ?>

