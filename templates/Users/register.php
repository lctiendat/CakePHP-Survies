<?php
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom styles for this template-->
    <link href="/css/admin/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <!-- <form class="user" action="/Auth/register" method="post"> -->
                            <form class="user" action="" method="post">

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" name="phone" id="exampleInputEmail" placeholder="Your Phone">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="re_password" id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <input type="hidden" name="created" value="<?= date('Y-m-d h:m:s') ?>">
                                <input type="hidden" name="modified" value="<?= date('Y-m-d h:m:s') ?>">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/admin/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(() => {
            $('button[type="submit"]').click((e) => {
                e.preventDefault()
                let email = $('input[name="email"]').val();
                let phone = $('input[name="phone"]').val();
                let password = $('input[name="password"]').val();
                let repassword = $('input[name="re_password"]').val();
                if (email == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Email chưa được điền !',
                    })
                } else if (phone == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Phone chưa được điền!',
                    })
                } else if (password == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Passwword chưa được điền!',
                    })
                } else if (repassword == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: ' Re Password chưa được điền',
                    })
                } else if (repassword != password) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mật khẩu nhập lại không giống !',
                    })
                } else {
                    $.ajax({
                        url: '/Auth/register',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            email: email,
                            phone: phone,
                            password: password,
                        },
                        success(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Oops...',
                                text: 'ok',
                            })
                        },
                        error(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'cc',
                            })
                        },
                    })
                }
            })
        })
    </script>
</body>

</html>