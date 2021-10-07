<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <form action="" method="post">
                    <h5>Chỉnh sửa Answer</h5>
                    <?php foreach ($answer as $item) { ?>
                        <div class="form-group">
                            <label for="">Answer</label>
                            <input type="text" class="form-control" name="name" value="<?= $item->name  ?>">
                            <?php if (isset($errors['name'])) { ?>
                                <p class="error"><?= reset($errors['name']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Survey</label>
                            <select name="survey_id" id="" class="form-control">
                                <?php foreach ($survies as $survey) { ?>
                                    <option value="<?= $survey->id ?>" <?php if ($survey->id == $item->survey_id) { ?> selected <?php } ?>><?= $survey->question ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Created</label>
                            <input class="form-control" value="<?= $item->created ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Modified</label>
                            <input class="form-control" value="<?= $item->modified ?>" readonly>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
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

<!-- 
<script>
    $(document).ready(() => {
        $('button[type="submit"]').click((e) => {
            e.preventDefault();
            let name = $('input[name="name"]').val();
            $.ajax({
                type: 'POST',
                url: 'http://localhost/admin/categories/add',
                data: {
                    name: name
                },
                success(response) {
                    var getData = $.parseJSON(response);

                    console.log(getData)
                },
                error(response) {

                    console.log(response)
                },
                dataType: "json",
                contentType: "application/json"
            })
        })
    })
</script> -->