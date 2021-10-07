<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <h5>Chỉnh sửa Survey</h5>

                <form action="" method="post">
                    <?php foreach ($survey  as $item) { ?>
                        <div class="form-group">
                            <label for="">Question</label>
                            <textarea name="question" id="" class="form-control" cols="30" rows="5"><?= h($item->question) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="2"><?= h($item->description) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category_id" id="" class="form-control">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= h($category->id) ?>" <?php if ($category->id == $item->category_id) { ?> selected <?php } ?>><?= h($category->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Type Select</label>
                            <input class="form-control" value="<?php if ($item->type_select == 1) { ?> Only Answer <?php } else { ?>Muti Answer <?php } ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Created</label>
                            <input class="form-control" value="<?= $item->created ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Modified</label>
                            <input class="form-control" value="<?= $item->modified ?>" readonly>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>