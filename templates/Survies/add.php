<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
            <p> <?= $this->Flash->render() ?></p>
                <?= $this->Form->create($survy) ?>
                <div class="form-group">
                    <label for="">Question</label>
                    <textarea name="question" id="" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" id="" class="form-control" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Category</label>
                    <select name="category_id" id="" class="form-control">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= h($category->id) ?>"><?= h($category->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="user_id" value="1">
                <input type="hidden" name="created" value="<?= date('Y-m-d h:m:s') ?>">
                <input type="hidden" name="modified" value="<?= date('Y-m-d h:m:s') ?>">
                <div class="form-group">
                    <label for="">Time End</label>
                    <input type="datetime-local" class="form-control" name="time_end">
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