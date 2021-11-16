<?= $this->element('user/header') ?>
<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -27px;
        position: relative;
        z-index: 2;

    }
</style>

<body style="background: #f8f9fa;">
    <div class="container changeinfor" style="margin-top: 200px;">
        <div class="row">
            <div class="col-md-5 mx-auto p-5" style="border:2px solid #26ba99;border-radius:20px">
                <center>
                    <h5 class="text-dark">Change Password</h5>
                </center>
                <?= $this->Flash->render() ?>
                <form action="" method="post">
                    <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?><?php } ?>">
                    <div class="form-group">
                        <label for="">Old password</label>
                        <input type="password" id="password-field" class="form-control" name="old_password" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueOldPassword'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueOldPassword'] ?>
<?php  }
                                                                                                                    unset($_SESSION['arrOldValueSession']['OldValueOldPassword']) ?>">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                    </div>
                    <div class="form-group">
                        <span class="float-left p-0" style="font-size: 13px;color:red">* Password must include numbers, uppercase, lowercase, special characters and at least 8 characters</span>
                        <label for="">New password</label>
                        <input type="password" id="password-field1" class="form-control" name="new_password" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueNewPassword'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueNewPassword'] ?>
<?php  }
                                                                                                                    unset($_SESSION['arrOldValueSession']['OldValueNewPassword']) ?>">
                        <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Enter the password new password</label>
                        <input type="password" id="password-field2" class="form-control" name="renew_password" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueReNewPassword'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueReNewPassword'] ?>
<?php  }
                                                                                                                        unset($_SESSION['arrOldValueSession']['OldValueReNewPassword']) ?>">
                        <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn
                     text-white" style="background: #212529;border-radius:0">Change</button>
                        <button onclick="window.location.href='/'" style="background: #212529;border-radius:0" type="button" class="btn btn-primary float-right ">Back <i class="fa fa-undo-alt"></i></button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?= $this->element('user/scriptBootstrap') ?>
<script>
    $(document).ready(() => {
        $('.back').click((e) => {
            e.preventDefault();
            window.history.back();
        })
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