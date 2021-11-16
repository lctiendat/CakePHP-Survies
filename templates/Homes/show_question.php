<?= $this->element('user/header') ?>
<style>
    body {
        background: #f2f2f2 url(//prod-8f86.kxcdn.com/s1/web-templates/images/bg-body.jpeg) no-repeat center top;
    }

    .survey__answer--main label:hover {
        background-color: #eee;
    }

    .survey {
        border-top-left-radius: 37px 140px;
        border-top-right-radius: 23px 130px;
        border-bottom-left-radius: 110px 19px;
        border-bottom-right-radius: 120px 24px;
        border: 3px solid #ccc
    }

    .survey__question h1 {
        font-size: 23px;
        font-family: "Inter SemiBold", sans-serif;
        padding: 0 0 28 px;
        border-bottom: 1 px solid #e5e5e5;
        position: relative;
        font-weight: bold;

    }

    .survey__question {
        border-bottom: 1px solid #26ba99;
    }
</style>
<div class="container show_question" style="padding-bottom: 100px;">
    <div>
        <?= $this->Flash->render() ?>
    </div>
    <div class="row">
        <div class="col-md-7 mx-auto survey p-5">
            <div class="survey__question">
                <?php foreach ($survies as $survey) {
                    $type_select = $survey->type_select;
                ?>
                    <center>
                        <h1> <?= $survey->question ?></h1>
                    </center>
            </div>
            <div class="survey__answer">
                <span class="survey__description"> <?= $survey->description ?></span>
            <?php } ?>
            <?php if (!isset($_SESSION['arrUserSession']['email'])) { ?>
                <form action="/result/saveNoLogin/<?= $survey->id ?>" method="post">
                <?php } else { ?>
                    <form action="/result/save/<?= $survey->id ?>" method="post">
                        <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?> <?php } ?>">
                    <?php } ?>
                    <?php foreach ($answers as $answer) {
                    ?>
                        <div class="survey__answer--main">
                            <label>
                                <input type="<?php if ($type_select == 1) { ?>radio<?php } else { ?>checkbox<?php } ?>" name="answer_id[]" id="checkbox_id" value="<?= $answer->id ?>" <?php if (isset($_SESSION['arrUserSession']['user_id'])) {
                                                                                                                                                                                            foreach ($getAnswerUser as $item) {
                                                                                                                                                                                                if ($answer->id == $item->answer_id) { ?> checked <?php }
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                        } ?> <?php if (isset($_SESSION['arrOldValueSession']['OldValue'])) {
                                                                                                                                                                                                                                                    foreach ($_SESSION['arrOldValueSession']['OldValue'] as $item) {
                                                                                                                                                                                                                                                        if ($answer->id == $item) { ?> checked <?php }
                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                    } ?>> <span for="checkbox_id"> <?= $answer->name ?>
                                </span>
                            </label>
                        </div>
                    <?php } ?>
                    <?php if (isset($_SESSION['arrUserSession']['email'])) { ?>
                        <div class="survey__answer--button">
                            <?php if (isset($_SESSION['oldPage'])) { ?> <a <?php if ($_SESSION['oldPage'] == '') { ?> style="background: #212529;padding:10px 30px;font-size:14px;text-decoration:none;color:white;margin-top:17px" href="/" <?php } else { ?> href="<?= $_SESSION['oldPage'] ?>"> <?php }
                                                                                                                                                                                                                                                                                            } ?><button class="float-left backtoPrePage" type="button" <?php if (!isset($_SESSION['oldPage'])) { ?> onclick="back()" <?php } ?> style="background: #212529" class="btn btn-success mb-3 ml-3 border-0 backtoPrePage">
                                Back
                            </button></a>
                                <button class="float-right" style="background: #212529;height: 40px !important;
    border-radius: 0 !important" type="submit">Bình chọn</button>
                        </div>
                    <?php } ?>
            </div>
        </div>
        <?php if (!isset($_SESSION['arrUserSession']['email'])) { ?>
            <div class="col-md-5 text-center register mt-5">
                <p class="text-dark" style="font-size: 20px;font-weight:bold;text-align:center">Fill out the information to complete the survey</p>
                <div class="card p-5 bg-transparent border-0">
                    <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?> <?php } ?>">
                    <div class="form-group">
                        <span for="user" class="float-left mb-1">Email</span>
                        <input type="email" name="email" id="email" class="p-2 w-100 border text-dark" require aria-required placeholder="Email của bạn" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueEmail'])) { ?>
                                                                                                                                          <?= $_SESSION['arrOldValueSession']['OldValueEmail'] ?>
                                                                                                                                         <?php   }
                                                                                                                                                                unset($_SESSION['arrOldValueSession']['OldValueEmail']) ?>">
                        <?php if (isset($_SESSION['errorEmail'])) { ?>
                            <p class="error"><?= $_SESSION['errorEmail']; ?></p>
                        <?php }
                        unset($_SESSION['errorEmail']) ?>
                        <span id="resultEmail"></span>
                    </div>
                    <div class="form-group">
                        <span for="" class="float-left mb-1">Phone</span>
                        <input type="text" onkeypress='validate(event)' name="phone" id="phone" class="p-2 w-100 border text-dark" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Số điện thoại của bạn" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValuePhone'])) { ?><?= $_SESSION['arrOldValueSession']['OldValuePhone'] ?>
<?php  }
                                                                                                                                                                                                                                                                                                                unset($_SESSION['arrOldValueSession']['OldValuePhone']) ?>">
                        <?php if (isset($_SESSION['errorPhone'])) { ?>
                            <p class="error"><?= $_SESSION['errorPhone']; ?></p>
                        <?php }
                        unset($_SESSION['errorPhone']) ?>
                        <span id="resultPhone"></span>

                    </div>
                    <div class="form-group">
                        <span for="" class="float-left mb-1">Password</span> <br>
                        <span class="float-left" style="font-size: 13px;color:red">* Password must include numbers, uppercase, lowercase, special characters and at least 8 characters</span>
                        <input id="password-field" type="password" placeholder="Mật khẩu của bạn" class="p-2 w-100 border  text-dark" style="border-radius:0" name="password" value="">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                        <span id="resultPassword" style="display: none;"></span>
                        <?php if (isset($_SESSION['errorPassword'])) { ?>
                            <p class="error"><?= $_SESSION['errorPassword']; ?></p>
                        <?php }
                        unset($_SESSION['errorPassword']) ?>
                    </div>

                    <div class="survey__answer--button">
                        <?php if (isset($_SESSION['oldPage'])) { ?> <a <?php if ($_SESSION['oldPage'] == '') { ?> style="background: #212529;padding:10px 30px;font-size:14px;color:white;margin-top:18px; text-decoration:none" href="/" <?php } else { ?> href="<?= $_SESSION['oldPage'] ?>"> <?php }
                                                                                                                                                                                                                                                                                        } ?><button class="float-left backtoPrePage" type="button" <?php if (!isset($_SESSION['oldPage'])) { ?> onclick="back()" <?php } ?> class="btn btn-success mb-3 ml-3 border-0 backtoPrePage">
                            Back
                        </button></a>
                            <button type="submit" class="float-right">Bình chọn</button>
                    </div>
                <?php } ?>
                </form>
                </div>
            </div>
    </div>
</div>
</body>
<?= $this->element('user/scriptBootstrap') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // block submit muti
    $('button[type="submit"]').click(() => {
        $('button[type="submit"]').css('visibility', 'hidden');
    })
    // show alert want re voted
    '<?php if (isset($getAnswerUser)) { ?>'
    if ('<?php echo count($getAnswerUser) > 0 ?>') {
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
            if (result.isConfirmed) {

            } else {
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

    // show / hidden icon eye
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

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

    // validate
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'

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

    function regExpEmail(email) {
        const re = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]{2,}$/;
        return re.test(email);
    }

    function validateEmail() {
        const $result = $("#resultEmail");
        const email = $("#email").val();
        $result.text("");
        if (regExpEmail(email)) {
            $result.text("✔");
            $result.css("color", "green");
            $result.css("fontSize", "13px");
            $("#email").css('border', '1px solid green !important')

        } else {
            $result.text("❌");
            $result.css("color", "red");
            $result.css("fontSize", "13px");
            $("#email").css('border', '1px solid red !important')

        }
        return false;
    }

    function regExpPhone(phone) {
        const regexp = /^(((0))[0-9]{9})$/g;
        return regexp.test(phone);
    }

    function validatePhone() {
        let phone = $('#phone').val().trim();
        let resultPhone = $('#resultPhone');
        if (regExpPhone(phone) == false) {
            resultPhone.text("❌");
            resultPhone.css("color", "red");
            resultPhone.css("fontSize", "13px");
            $("#phone").css('border', '1px solid red !important')
        } else {
            resultPhone.text("✔");
            resultPhone.css("color", "green");
            resultPhone.css("fontSize", "13px");
            $("#phone").css('border', '1px solid green !important')
        }
    }

    function validatePassword() {
        let password = $('#password-field').val();

        if (password == '') {
            $('#resultPassword').show();
            $('.toggle-password').hide()
            $('#password-field').css('border', '1px solid red !important');
            $('#resultPassword').text("❌");
            $('#password-field').css("fontSize", "13px");
        } else {
            $('#resultPassword').hide();
            $('.toggle-password').show()
            $('#password-field').css('border', '1px solid green !important');
            $('#password-field').css("fontSize", "13px");
        }
    }
    $("#email").on("blur", validateEmail);
    $("#phone").on("blur", validatePhone);
    $("#password-field").on("blur", validatePassword);

    $('input[name="answer_id[]"]').change((e) => {
        const surveyId = window.location.pathname.split("/").pop()
        let arr1 = [];
        $.ajax({
            url: '/hihi',
            method: 'post',
            data: {
                id: surveyId
            },
            dataType: 'json',
            success(data) {
                data.forEach((e) => {
                    arr1.push(parseInt(e.count))
                })
                if (arr1 != '') {
                    let total = arr1.reduce((a, b) => a + b)
                    let newArr = [];
                    data.forEach((e) => {
                        newArr.push({
                            answer_id: e.answer_id,
                            cal: (e.count / total) * 100
                        })
                    })
                    console.log(newArr)
                }
            },
            error(data) {
                console.log(data)
            }
        })
    })
</script>

</html>