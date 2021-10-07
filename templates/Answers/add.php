<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <h5>Thêm Answer</h5>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Survey</label>
                        <select name="survey_id" id="" class="form-control">
                            <?php foreach ($survies as $survey) { ?>
                                <option value="<?= $survey->id ?>"><?= $survey->question ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Answer</label>

                        <input type="text" class="form-control" name="name[]">

                        <?php if (isset($errors['name'])) { ?>
                            <p class="error"><?= reset($errors['name']); ?></p>
                        <?php } ?>
                    </div>
                    <div id="more"></div>
                    <span class="fa fa-plus mt-1" id="add"></span><span id="del" class="fa fa-trash ml-3 mt-1"></span>

                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>


<script>
    var answers = [];
    $(document).ready(() => {
        $('#add').click(() => {
            answers.push('<div class="form-group"> <input type="text" class="form-control" name="name[]"></div>');
            $('#more').html(answers);

        })
        $('#del').click(() => {
            answers.pop();
            $('#more').html(answers);
        })
    })
</script>