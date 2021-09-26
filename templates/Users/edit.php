<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
            <p> <?= $this->Flash->render() ?></p>
                <?= $this->Form->create($user) ?>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" readonly name="email" value="<?= h($user->email) ?>">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="number" class="form-control" name="phone" value="<?= h($user->phone) ?>">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" value="<?= h($user->password) ?>">
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" class="form-control" name="address" value="<?= h($user->address) ?>">
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" id="" class="form-control">
                        <option value="1" <?php if ($user->status == 1) { ?> selected <?php } ?>>Disable</option>
                        <option value="2" <?php if ($user->status == 2) { ?> selected <?php } ?>>Enable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Role</label>
                    <select name="role" id="" class="form-control">
                        <option value="1" <?php if ($user->role == 1) { ?> selected <?php } ?>>User</option>
                        <option value="2" <?php if ($user->role == 2) { ?> selected <?php } ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>