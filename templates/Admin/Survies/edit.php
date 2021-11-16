<?= $this->element('admin/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <h5>Edit Survey</h5>
                <form action="" method="post">
                    <?php foreach ($survey  as $item) { ?>
                        <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?> <?php } ?>">
                        <div class="form-group">
                            <label for="">Question</label>
                            <textarea name="question" id="" class="form-control" cols="30" rows="5"><?php if (isset($_SESSION['questionError'])) { ?><?= $_SESSION['questionError']  ?><?php } else { ?><?= $item->question ?><?php }
                                                                                                                                                                                                                            unset($_SESSION['questionError']) ?></textarea>
                            <?php if (isset($errors['question'])) { ?>
                                <p class="error"><?= reset($errors['question']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="2"><?php if (isset($_SESSION['descriptionError'])) { ?><?= $_SESSION['descriptionError']  ?><?php } else { ?><?= $item->description ?><?php }
                                                                                                                                                                                                                                        unset($_SESSION['descriptionError']) ?></textarea>
                            <?php if (isset($errors['description'])) { ?>
                                <p class="error"><?= reset($errors['description']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <input type="text" name="key" class="float-right" id="search" onkeyup="filter()">
                            <select name="category_id" id="select" class="form-control" multiple>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= $category->id ?>" <?php if ($category->id == $item->category_id) { ?> selected <?php } ?>><?= $category->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Type Select</label>
                            <input class="form-control" value="<?php if ($item->type_select == 1) { ?> Only Answer <?php } else { ?>Muti Answer <?php } ?>" readonly>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-primary float-right backtoPrePage" onclick="backPrePage()">Back <i class="fa fa-undo-alt"></i></button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->element('admin/footer') ?>
<script>
    function filter() {
        var keyword = $('#search').val().toLowerCase();
        var select = document.getElementById("select");
        for (var i = 0; i < select.length; i++) {
            var txt = select.options[i].text.toLowerCase();
            if (!txt.match(keyword)) {
                $(select.options[i]).attr('disabled', 'disabled').hide();
            } else {
                $(select.options[i]).removeAttr('disabled').show();
            }
        }
    }
</script>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name + '/admin/survies'
        } else {}
    })
</script>