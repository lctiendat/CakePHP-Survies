<?= $this->element('admin/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <form action="" method="post">
                    <h5>Edit Answer</h5>
                    <?php foreach ($answer as $item) { ?>
                        <div class="form-group">
                            <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?><?php } ?>">
                            <label for="">Answer</label>
                            <input type="text" class="form-control" name="name" value="<?php if (isset($_SESSION['nameError'])) { ?><?= $_SESSION['nameError']  ?><?php } else { ?><?= $item->name ?><?php }
                                                                                                                                                                                                    unset($_SESSION['nameError'])
                                                                                                                                                                                                        ?>">
                            <?php if (isset($errors['name'])) { ?>
                                <p class="error"><?= reset($errors['name']); ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-primary float-right backtoPrePage" onclick="backPrePage()">Back <i class="fa fa-undo-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $this->element('admin/footer') ?>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name + '/admin/survies'
        } else {}
    })
</script>