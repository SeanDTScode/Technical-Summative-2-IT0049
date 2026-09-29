<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading">
    <div><h1>Products</h1><p>Manage prices, stock, and product images.</p></div>
    <a class="button primary" href="<?= base_url('products/new') ?>">Add Product</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <?php
        $hasImage = ! empty($product['image'])
            && is_file(FCPATH . 'uploads/products/' . basename($product['image']));
        $imageUrl = $hasImage
            ? base_url('uploads/products/' . rawurlencode($product['image']))
            : base_url('images/product-placeholder.svg');
        ?>
        <tr>
            <td><img class="thumb" src="<?= esc($imageUrl) ?>" alt=""></td>
            <td><?= esc($product['name']) ?></td>
            <td>₱<?= number_format((float) $product['price'], 2) ?></td>
            <td><?= esc($product['stock_quantity']) ?></td>
            <td><?= esc($product['created_at']) ?></td>
            <td class="actions">
                <a class="button" href="<?= base_url('products/' . $product['id'] . '/edit') ?>">Edit</a>
                <form action="<?= base_url('products/' . $product['id'] . '/delete') ?>" method="post"
                      onsubmit="return confirm('Delete this product?');">
                    <?= csrf_field() ?><button class="button danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if ($products === []): ?><tr><td colspan="6">No products found.</td></tr><?php endif; ?>
    </tbody>
</table>
</div>
<?= $this->endSection() ?>

