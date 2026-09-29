<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading"><div><h1>Record Sale</h1><p>Stock is deducted only after a successful transaction.</p></div></div>
<?= view('partials/errors') ?>
<form class="panel form-grid" action="<?= base_url('sales') ?>" method="post">
    <?= csrf_field() ?>
    <label>Product
        <select name="product_id" required>
            <option value="">Select a product</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= esc($product['id']) ?>" <?= old('product_id') == $product['id'] ? 'selected' : '' ?>>
                    <?= esc($product['name']) ?> — ₱<?= number_format((float) $product['price'], 2) ?>
                    (<?= esc($product['stock_quantity']) ?> available)
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Customer (optional)
        <select name="customer_id">
            <option value="">Walk-in customer</option>
            <?php foreach ($customers as $customer): ?>
                <option value="<?= esc($customer['id']) ?>" <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>>
                    <?= esc($customer['full_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Quantity
        <input name="quantity" type="number" min="1" step="1" required value="<?= esc(old('quantity', '1')) ?>">
    </label>
    <div class="form-actions">
        <button class="primary" type="submit">Complete Sale</button>
        <a class="button" href="<?= base_url('sales') ?>">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>

