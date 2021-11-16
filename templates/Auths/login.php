<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->element('user/headerAuth') ?>
    <title>Login</title>
</head>

<body class="bg-gradient-primary">
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row p-5">
            <div class="col-md-8 mx-auto">
                <div class="card p-5" style="background:#F8F8FF;border-radius: 30px;border: 0;">
                    <div class="row banner">
                        <div class="col-md-6">
                            <h1 class="mt-5"> DO NOT HAVE <span style="color: #26ba99;">AN ACCOUNT</span> </h1>
                            <a href="/auths/register"><button>CREATE AN ACCOUNT</button></a>
                        </div>
                        <div class="col-md-6" style="border-left:  1px solid gray;">
                            <a href="/" style="background: #212529;border:0" class="btn btn-primary float-lèt mt-3 ml-3">On the homepage <i class="fa fa-long-arrow-alt-left"></i></a>
                            <div class="p-5">
                                <?= $this->Flash->render() ?>
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" action="" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueEmail'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueEmail'] ?>
<?php  }
                                                                                                                                                                                                                unset($_SESSION['arrOldValueSession']['OldValueEmail']) ?>">
                                        <span id="resultEmail"></span>

                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" id="password-field" id="" placeholder="Password">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-dark mr-2"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="margin-top:0">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/auths/forget">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/auths/register">Create an Account!</a>
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
    $("#password-field").on("blur", validatePassword);
</script>