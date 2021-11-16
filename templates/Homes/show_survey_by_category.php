<?php

use App\Controller\HomesController;

$r = new HomesController;
?>
<?= $this->element('user/header') ?>
<style>
    ::placeholder {
        font-size: 13px;
    }

    .register label {
        font-size: 13px;
    }
    .register input {
        color: black !important;
    }
</style>
<div class="container">
    <div class="row" style="margin-top: 200px;">
        <div class="col-md-8 mx-auto">
            <?= $this->Flash->render() ?>
            <center>
                <h3><?= $nameCategory ?></h3>
            </center>
            <div class="card p-5">
                <?php if (isset($_SESSION['arrUserSession'])) { ?>
                    <form action="/savevoted/<?= $idCategory ?>/login" method="post">
                    <?php } else { ?>
                        <form action="/savevoted/<?= $idCategory ?>/notlogin" method="post">
                        <?php } ?>
                        <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?><?= trim($_SERVER['HTTP_REFERER']); ?> <?php } ?>">
                        <?php
                        $i = 0;
                        $j = 1;
                        foreach ($survies as $key => $item) {
                            $answer = $r->getAnswerBySurvey($item->id)
                        ?>
                            <input type="hidden" name="question[<?= ++$key ?>]" value="<?= $item->id ?>">
                            <p><b>Questions <?= $key ?> </b> : <?= $item->question ?></p>
                            <input type="hidden" name="type_select[<?= $j++ ?>]" value="<?= $item->type_select ?>">
                            <?php foreach ($answer as $item1) { ?>
                                <label for="<?= $i++ ?>"><input id="<?= $i - 1 ?>" type="<?php if ($item->type_select == 1) { ?>radio<?php } else { ?>checkbox<?php } ?>" name="answer[<?= $key ?>][]" value="<?= $item1->id ?>" <?php if (isset($_SESSION['arrUserSession']['user_id'])) {
                                                                                                                                                                                                                                        foreach ($getAnswerUser as $value) {
                                                                                                                                                                                                                                            if ($item1->id == $value->answer_id) { ?> checked <?php }
                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                    } ?> <?php if (isset($_SESSION['arrOldAnswer'])) {
                                                                                                                                                                                                                                                                                                foreach ($_SESSION['arrOldAnswer'] as $value) {
                                                                                                                                                                                                                                                                                                    if ($item1->id == $value) { ?> checked <?php }
                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                            ?>> <?= $item1->name ?></label> <br>
                            <?php } ?>
                        <?php }
                        if (isset($_SESSION['arrUserSession'])) { ?>
                            <button type="submit" class="btn btn-success float-right mt-3 border-0" style="width: 100px;background: #212529">Voted</button>
                        <?php } ?>
                        <?php if (isset($_SESSION['oldPage'])) { ?> <a <?php if ($_SESSION['oldPage'] == '') { ?> style="background: #212529;padding:10px 30px;font-size:14px;text-decoration:none;color:white;margin-top:17px" href="/" <?php } else { ?> href="<?= $_SESSION['oldPage'] ?>"> <?php }
                                                                                                                                                                                                                                                                                        } ?><button type="button" <?php if (!isset($_SESSION['oldPage'])) { ?> onclick="back()" <?php } ?> style="background: #212529;width: 100px;" class="btn btn-success mb-3 ml-3 float-left mt-3 border-0 backtoPrePage">
                            Back
                        </button></a>
            </div>
        </div>
        <?php if (!isset($_SESSION['arrUserSession'])) { ?>
            <div class="col-md-4 register">
                <p class="text-dark" style="font-size: 20px;font-weight:bold;text-align:center">Fill out the information to complete the survey</p>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter your email" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueEmail'])) { ?><?= trim($_SESSION['arrOldValueSession']['OldValueEmail']) ?><?php   }
                                                                                                                                                                                                                                                unset($_SESSION['arrOldValueSession']['OldValueEmail']) ?>">
                    <?php if (isset($_SESSION['errorEmail'])) { ?>
                        <p class="error"><?= $_SESSION['errorEmail']; ?></p>
                    <?php }
                    unset($_SESSION['errorEmail']) ?>
                </div>
                <div class="form-group">
                    <span></span>
                    <label for="">Phone</label>
                    <input type="text" name="phone" placeholder="Enter your phone" class="form-control" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValuePhone'])) { ?><?= trim($_SESSION['arrOldValueSession']['OldValuePhone']) ?>
<?php  }
                                                                                                                unset($_SESSION['arrOldValueSession']['OldValuePhone']) ?>">
                    <?php if (isset($_SESSION['errorPhone'])) { ?>
                        <p class="error"><?= $_SESSION['errorPhone']; ?></p>
                    <?php }
                    unset($_SESSION['errorPhone']) ?>
                </div>
                <div class="form-group position-relative">
                    <span class="float-left" style="font-size: 11px;color:red">* Password must include numbers, uppercase, lowercase, special characters and at least 8 characters</span>
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                    <span id="iconpassword" class="fa fa-eye float-right position-absolute" style="top: 38px; right:10px"></span>
                    <?php if (isset($_SESSION['errorPassword'])) { ?>
                        <p class="error"><?= $_SESSION['errorPassword']; ?></p>
                    <?php }
                    unset($_SESSION['errorPassword']) ?>
                </div>
                <div class="form-group float-right">
                    <button type="submit" class="btn btn-success">Voted</button>
                </div>
            </div>
        <?php } ?>
        </form>
    </div>
</div>
<?= $this->element('user/scriptBootstrap') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    '<?php if (isset($check_result)) { ?>'
    if ('<?php echo count($check_result) > 0 ?>') {
        Swal.fire({
            title: 'Bình chọn lại ?',
            text: "Bạn đã bình chọn câu trả lời này rồi. Bạn có muốn chọn lại ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có, tôi muốn',
            cancelButtonText: "Không",
        }).then((result) => {
            if (result.isConfirmed) {} else {
                <?php if (isset($_SESSION['oldPage'])) { ?>
                    <?php if ($_SESSION['oldPage'] == '') { ?>
                        window.location.href = "/";
                    <?php } else { ?>
                        window.location.href = '<?php echo $_SESSION['oldPage'] ?>'
                    <?php } ?>
                <?php } else { ?>
                    window.history.back();
                <?php } ?>
            }
        })
    }
    '<?php } ?>'
    $('#iconpassword').click((e) => {
        let typePassword = $('#password').attr('type')
        if (typePassword == 'password') {
            $('#password').attr('type', 'text')
            $('#iconpassword').attr('class', 'fa fa-eye-slash float-right position-absolute')
        } else {
            $('#password').attr('type', 'password')
            $('#iconpassword').attr('class', 'fa fa-eye float-right position-absolute')
        }
    })

    //function back
    function back() {
        <?php if (isset($_SESSION['oldPage'])) { ?>
            <?php if ($_SESSION['oldPage'] == '') { ?>
                window.location.href = "/";
            <?php } else { ?>
                window.history.back();
            <?php } ?>
        <?php } else { ?>
            window.history.back();
        <?php } ?>
    }

    // back to pre page
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name
        } else {

        }

    })
</script>