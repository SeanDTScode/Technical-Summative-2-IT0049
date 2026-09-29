<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="page-heading">
    <div><h1>Staff</h1><p>Manage staff accounts and profile images.</p></div>
    <a class="button primary" href="<?= base_url('users/new') ?>">Add Staff</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>Avatar</th><th>Username</th><th>Full name</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <?php
        $hasAvatar = ! empty($user['avatar'])
            && is_file(FCPATH . 'uploads/avatars/' . basename($user['avatar']));
        $avatarUrl = $hasAvatar
            ? base_url('uploads/avatars/' . rawurlencode($user['avatar']))
            : base_url('images/avatar-placeholder.svg');
        ?>
        <tr>
            <td><img class="avatar" src="<?= esc($avatarUrl) ?>" alt=""></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['full_name']) ?></td>
            <td><?= esc($user['created_at']) ?></td>
            <td class="actions">
                <a class="button" href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a>
                <?php if ((int) session()->get('user_id') !== (int) $user['id']): ?>
                    <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="post"
                          onsubmit="return confirm('Delete this staff account?');">
                        <?= csrf_field() ?><button class="button danger" type="submit">Delete</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?= $this->endSection() ?>

