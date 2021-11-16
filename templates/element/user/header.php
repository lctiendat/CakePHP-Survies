<?php
$this->disableAutoLayout();
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey - Online market statistics </title>
    <link rel="icon" href="https://i0.wp.com/s1.uphinh.org/2021/10/28/test-survey-icon-on-white-vector.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/main.css">
    <style>

    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg ftco_navbar bg-dark ftco-navbar-dark p-3 fixed-top" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="/"><img src="https://i0.wp.com/s1.uphinh.org/2021/10/28/test-survey-icon-on-white-vector.png" height="50px" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars text-white"></span> <span class="text-white">Menu</span>
                </button>
                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto mr-md-3">
                        <?php if (!isset($_SESSION['arrUserSession'])) { ?>
                            <li class="nav-item"><a href="/auths/register" class="nav-link">Register</a></li>
                            <li class="nav-item"><a href="/auths/login" class="nav-link">Log in</a></li>
                        <?php } else { ?>
                            <li class="dropdown nav-item d-md-flex align-items-center">
                                <a href="#" class="dropdown-toggle nav-link d-flex align-items-center icon-cart p-0" id="dropdown04" data-toggle="dropdown" aria-expanded="false">
                                    <i style="font-size: 30px;" class="fa fa-user-circle"></i>
                                    <b class="caret"></b>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right text-dark" aria-labelledby="dropdown04">
                                    <?php if ($_SESSION['arrUserSession']['role'] == 9) { ?>
                                        <a href="/admin" class="dropdown-item text-dark"><i class="fa fa-user-cog"></i> Admin system</a>
                                    <?php } ?>
                                    <a href="/auths/changeinfor" class="dropdown-item text-dark"><i class="fa fa-exchange-alt"></i> Change infor</a>
                                    <a href="/auths/changepass" class="dropdown-item text-dark"><i class="fa fa-exchange-alt"></i> Change password</a>
                                    <a href="/auths/history" class="dropdown-item text-dark"><i class="fa fa-history"></i> Voting history</a>
                                    <a href="/auths/logout" class="dropdown-item text-dark"><i class="fa fa-sign-out-alt"></i> Logout</a>

                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script>

    </script>