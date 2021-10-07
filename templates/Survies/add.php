<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <?= $this->Flash->render() ?>
                <h5>Thêm Survey</h5>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Question</label>
                        <textarea name="question" id="" class="form-control" cols="30" rows="5"></textarea>
                        <?php if (isset($errors['question'])) { ?>
                            <p class="error"><?= reset($errors['question']); ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="form-control" cols="30" rows="2"></textarea>
                        <?php if (isset($errors['description'])) { ?>
                            <p class="error"><?= reset($errors['description']); ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="category_id" id="" class="form-control">
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Type Select</label>
                        <select name="type_select" class="form-control" id="">
                            <option value="1">Only Answer</option>
                            <option value="2">Muti Answers</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
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