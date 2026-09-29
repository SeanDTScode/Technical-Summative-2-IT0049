<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tasks for Today') ?></title>
</head>
<body>

<?= view('partials/navigation') ?>

<?php if ($message = session()->getFlashdata('message')): ?>
    <p><?= esc($message) ?></p>
<?php endif; ?>

<?php if ($error = session()->getFlashdata('error')): ?>
    <p><?= esc($error) ?></p>
<?php endif; ?>

<?= $this->renderSection('content') ?>

</body>
</html>

