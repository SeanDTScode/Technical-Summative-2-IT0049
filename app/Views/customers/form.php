<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $editing = $customer !== null; ?>
<div class="page-heading"><div><h1><?= $editing ? 'Edit Customer' : 'New Customer' ?></h1></div></div>
<?= view('partials/errors') ?>
<form class="panel form-grid" action="<?= $editing ? base_url('customers/' . $customer['id']) : base_url('customers') ?>" method="post">
    <?= csrf_field() ?>
    <label>Full name
        <input name="full_name" maxlength="100" required value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>">
    </label>
    <label>Email
        <input name="email" type="email" maxlength="100" required value="<?= esc(old('email', $customer['email'] ?? '')) ?>">
    </label>
    <label>Phone
        <input name="phone" maxlength="20" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>">
    </label>
    <div class="form-actions">
        <button class="primary" type="submit"><?= $editing ? 'Update Customer' : 'Create Customer' ?></button>
        <a class="button" href="<?= base_url('customers') ?>">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>

