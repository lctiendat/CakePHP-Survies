<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <h5>Chỉnh sửa Category</h5>
                <form action="" method="post">
                    <?php foreach ($category as $item) { ?>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="<?= $item->name ?>">
                            <?php if (isset($errors['name'])) { ?>
                                <p class="error"><?= reset($errors['name']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Created</label>
                            <input class="form-control" value="<?= $item->created ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Modified</label>
                            <input class="form-control" value="<?= $item->modified ?>" readonly>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>