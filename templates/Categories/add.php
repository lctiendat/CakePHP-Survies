<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <h5>Thêm Category</h5>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                        <?php if (isset($errors['name'])) { ?>
                            <p class="error"><?= reset($errors['name']); ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
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