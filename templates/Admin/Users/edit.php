<?= $this->element('admin/header') ?>
<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card p-5">
                <?= $this->Flash->render() ?>
                <h5>Edit User</h5>
                <form action="" method="post">
                    <?php foreach ($user as $item) { ?>
                        <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?> <?php } ?>">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" readonly value="<?= h($item->email) ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" onkeypress='validate(event)' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control" name="phone" value="<?php if (isset($_SESSION['phoneError'])) { ?> <?= $_SESSION['phoneError']  ?> <?php } else { ?><?= $item->phone ?><?php }
                                                                                                                                                                                                                                                                                                                                                                    unset($_SESSION['phoneError']) ?>">
                            <?php if (isset($errors['phone'])) { ?>
                                <p class="error"><?= reset($errors['phone']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label> </br>
                            <span style="font-size: 13px;color:red">* Password must include numbers, uppercase, lowercase, special characters and at least 8 characters</span>
                            <input type="password" class="form-control" name="password" id="password-field">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                            <?php if (isset($_SESSION['errorPassword'])) { ?>
                                <p class="error"><?= $_SESSION['errorPassword']; ?></p>
                            <?php }
                            unset($_SESSION['errorPassword']) ?>
                            <?php if (isset($errors['password'])) { ?>
                                <p class="error w-100"><?= reset($errors['password']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" id="" class="form-control" rows="5"><?php if (isset($_SESSION['addressError'])) { ?><?= trim($_SESSION['addressError'])  ?><?php } else { ?><?= trim($item->address) ?><?php }
                                                                                                                                                                                                                        unset($_SESSION['addressError']) ?></textarea>
                            <?php if (isset($errors['address'])) { ?>
                                <p class="error"><?= reset($errors['address']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="1" <?php if ($item->status == 1) { ?> selected <?php } ?>>Disable</option>
                                <option value="2" <?php if ($item->status == 2) { ?> selected <?php } ?>>Enable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" id="" class="form-control">
                                <option value="0" <?php if ($item->role == 0) { ?> selected <?php } ?>>User</option>
                                <option value="9" <?php if ($item->role == 9) { ?> selected <?php } ?>>Admin</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-primary float-right backtoPrePage" onclick="backPrePage()">Back <i class="fa fa-undo-alt"></i></button>
                    </div>
                    <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $this->element('admin/footer') ?>
<script>
    function validate(evt) {
        var theEvent = evt || window.event;
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    $(document).ready(() => {
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    })
</script>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name + '/admin/users'
        } else {}
    })
</script>