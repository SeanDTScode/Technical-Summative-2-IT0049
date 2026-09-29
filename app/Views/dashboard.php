<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading">
    <div><h1>Dashboard</h1><p>Point-of-Sale management overview</p></div>
    <a class="button primary" href="<?= base_url('sales/new') ?>">Record a Sale</a>
</div>
<section class="stats">
    <a class="stat" href="<?= base_url('products') ?>"><strong><?= esc($productCount) ?></strong><span>Products</span></a>
    <a class="stat" href="<?= base_url('customers') ?>"><strong><?= esc($customerCount) ?></strong><span>Customers</span></a>
    <a class="stat" href="<?= base_url('users') ?>"><strong><?= esc($userCount) ?></strong><span>Staff</span></a>
    <a class="stat" href="<?= base_url('sales') ?>"><strong><?= esc($saleCount) ?></strong><span>Sales</span></a>
</section>
<?= $this->endSection() ?>

