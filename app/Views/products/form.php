<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $editing = $product !== null; ?>
<div class="page-heading"><div><h1><?= $editing ? 'Edit Product' : 'New Product' ?></h1></div></div>
<?= view('partials/errors') ?>
<form class="panel form-grid" action="<?= $editing ? base_url('products/' . $product['id']) : base_url('products') ?>"
      method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label>Name
        <input name="name" maxlength="100" required value="<?= esc(old('name', $product['name'] ?? '')) ?>">
    </label>
    <label>Price
        <input name="price" type="number" min="0" step="0.01" required value="<?= esc(old('price', $product['price'] ?? '')) ?>">
    </label>
    <label>Stock quantity
        <input name="stock_quantity" type="number" min="0" step="1" required
               value="<?= esc(old('stock_quantity', $product['stock_quantity'] ?? '0')) ?>">
    </label>
    <label>Product image
        <input name="image" type="file" accept="image/jpeg,image/png" data-prepare-image="600" data-preview="#image-preview">
        <small>JPG or PNG, maximum 2 MB. The browser prepares a 600 × 600 copy.</small>
    </label>
    <?php
    $preview = $editing && ! empty($product['image'])
        ? base_url('uploads/products/' . rawurlencode($product['image']))
        : base_url('images/product-placeholder.svg');
    ?>
    <img id="image-preview" class="form-preview" src="<?= esc($preview) ?>" alt="Product preview">
    <div class="form-actions">
        <button class="primary" type="submit"><?= $editing ? 'Update Product' : 'Create Product' ?></button>
        <a class="button" href="<?= base_url('products') ?>">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?><script src="<?= base_url('assets/image-prep.js') ?>"></script><?= $this->endSection() ?>

