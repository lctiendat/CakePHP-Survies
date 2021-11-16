<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->element('user/headerAuth') ?>
    <title>Register</title>
</head>

<body class="bg-gradient-primary">


    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row p-5">
            <div class="col-md-9 mx-auto">
                <div class="card p-5" style="background:#F8F8FF;border-radius: 30px;border: 0;">
                    <div class="row banner">
                        <div class="col-md-5 col-6">
                            <h1 class="mt-5"> DO YOU ALREADY HAVE<span style="color: #26ba99;"> AN ACCOUNT</span> </h1>
                            <a href="/auths/login"><button>LOG IN NOW</button></a>
                        </div>
                        <div class="col-md-7 col-6" style="border-left:  1px solid gray;">
                            <a href="/" style="background: #212529;border:0" class="btn btn-primary float-left mt-3 ml-3">On the homepage <i class="fa fa-long-arrow-alt-left"></i></a>
                            <div class="p-5">
                                <div class="text-center">
                                    <h3 class="font-weight-bold text-gray-900 mb-4 mt-4">Create an Account!</h3>
                                </div>
                                <?= $this->Flash->render() ?>
                                <form class="user" action="" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" id="email" placeholder="Email Address" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueEmail'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueEmail'] ?>
<?php  }
                                                                                                                                                                unset($_SESSION['arrOldValueSession']['OldValueEmail']) ?>">
                                        <span id="resultEmail"></span>
                                    </div>
                                    <?php if (isset($errors['email'])) { ?>
                                        <p class="error"><?= reset($errors['email']); ?></p>
                                    <?php } ?>
                                    <div class="form-group">
                                        <input type="text" onkeypress='validate(event)' class="form-control form-control-user" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="phone" id="phone" placeholder="Your Phone" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValuePhone'])) { ?><?= $_SESSION['arrOldValueSession']['OldValuePhone'] ?>
<?php  }
                                                                                                                                                                                                                                                                                                                        unset($_SESSION['arrOldValueSession']['OldValuePhone']) ?>">
                                        <span id="resultPhone"></span>
                                    </div>
                                    <?php if (isset($errors['phone'])) { ?>
                                        <p class="error w-100"><?= reset($errors['phone']); ?></p>
                                    <?php } ?>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <span style="font-size: 13px;color:red">* Password must include numbers, uppercase, lowercase, special characters and at least 8 characters</span>
                                            <input type="password" class="form-control form-control-user" name="password" id="password-field" placeholder="Your password">
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                                            <span id="resultPassword" style="display: none;"></span>
                                        </div>
                                        <?php if (isset($errors['password'])) { ?>
                                            <p class="error mt-3 ml-3 w-100"><?= reset($errors['password']); ?></p>
                                        <?php } ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="margin-top:0">
                                        Register Account
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/auths/login">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</body>
<?= $this->element('user/scriptBootstrap') ?>

</html>
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
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

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
            $("#email").css('border', '1px solid green')
        } else {
            $result.text("❌");
            $result.css("color", "red");
            $result.css("fontSize", "13px");
            $("#email").css('border', '1px solid red')

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
            $("#phone").css('border', '1px solid red')
        } else {
            resultPhone.text("✔");
            resultPhone.css("color", "green");
            resultPhone.css("fontSize", "13px");
            $("#phone").css('border', '1px solid green')
        }
    }

    function regExpPassword(password) {
        const regexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/
        return regexp.test(password)
    }

    function validatePassword() {
        let password = $('#password-field').val();
        if (regExpPassword(password) == false) {
            $('#resultPassword').show();
            $('#password-field').css('border', '1px solid red');
            $('#password-field').css("fontSize", "13px");
        } else {
            $('#resultPassword').hide();
            $('.toggle-password').show()
            $('#password-field').css('border', '1px solid green');
            $('#password-field').css("fontSize", "13px");
        }
    }
    $("#email").on("blur", validateEmail);
    $("#phone").on("blur", validatePhone);
    $("#password-field").on("blur", validatePassword);
</script>