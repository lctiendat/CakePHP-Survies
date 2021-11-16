<?= $this->element('admin/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <?= $this->Flash->render() ?>
                <h5>Add Survey</h5>
                <form action="" method="post">
                    <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?><?php } ?>">
                    <div class="form-group">
                        <label for="">Question</label>
                        <textarea name="question" id="" class="form-control" cols="30" rows="5"><?php if (isset($_SESSION['questionError'])) { ?><?= $_SESSION['questionError']  ?><?php }
                                                                                                                                                                                unset($_SESSION['questionError']) ?></textarea>
                        <?php if (isset($errors['question'])) { ?>
                            <p class="error"><?= reset($errors['question']); ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="form-control" cols="30" rows="2"><?php if (isset($_SESSION['descriptionError'])) { ?><?= $_SESSION['descriptionError']  ?><?php }
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
                    <div class="form-group ">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-primary float-right backtoPrePage" onclick="backPrePage()">Back <i class="fa fa-undo-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->element('admin/footer') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $(document).ready(() => {
        $('#select option:first').prop('selected', true);
    })

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
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name + '/admin/survies'
        } else {

        }
    })
</script>