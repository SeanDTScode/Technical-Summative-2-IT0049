<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $editing = $user !== null; ?>
<div class="page-heading"><div><h1><?= $editing ? 'Edit Staff Account' : 'New Staff Account' ?></h1></div></div>
<?= view('partials/errors') ?>
<form class="panel form-grid" action="<?= $editing ? base_url('users/' . $user['id']) : base_url('users') ?>"
      method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label>Username
        <input name="username" maxlength="50" required value="<?= esc(old('username', $user['username'] ?? '')) ?>">
    </label>
    <label>Full name
        <input name="full_name" maxlength="100" required value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>">
    </label>
    <label><?= $editing ? 'New password' : 'Password' ?>
        <input name="password" type="password" minlength="8" autocomplete="new-password" <?= $editing ? '' : 'required' ?>>
        <?php if ($editing): ?><small>Leave blank to retain the current password.</small><?php endif; ?>
    </label>
    <label>Avatar
        <input name="avatar" type="file" accept="image/jpeg,image/png" data-prepare-image="300" data-preview="#avatar-preview">
        <small>JPG or PNG, maximum 2 MB. The browser prepares a 300 × 300 copy.</small>
    </label>
    <?php
    $preview = $editing && ! empty($user['avatar'])
        ? base_url('uploads/avatars/' . rawurlencode($user['avatar']))
        : base_url('images/avatar-placeholder.svg');
    ?>
    <img id="avatar-preview" class="form-preview avatar-large" src="<?= esc($preview) ?>" alt="Avatar preview">
    <div class="form-actions">
        <button class="primary" type="submit"><?= $editing ? 'Update Staff' : 'Create Staff' ?></button>
        <a class="button" href="<?= base_url('users') ?>">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script src="<?= base_url('assets/image-prep.js') ?>"></script><?= $this->endSection() ?>

