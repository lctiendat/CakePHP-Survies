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
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <style>
        body {
            background-image: linear-gradient(to bottom, white, #F8F8FF);
        }

        .banner h1 {
            font-weight: bolder;
            font-size: 50px;
        }

        .banner p {
            letter-spacing: 6px;
            font-size: 38px;
            font-weight: bolder;
        }

        .banner button {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            padding: 16px 48px;
            border-radius: 50px;
            border: none;
            color: #fff;
            box-shadow: 5px 5px 20px 0 rgb(0 0 0 / 20%);
            text-transform: uppercase;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            margin-top: 50px;
        }

        button:focus,
        input:focus {
            outline: none;
        }

        nav li a {
            color: white !important;
            font-size: 14px;
        }

        .next,
        .prev {
            border: 1px solid red;
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            padding: 5px 10px;
            border: 0;
        }

        .next a,
        .prev a {
            text-decoration: none;
            color: white;
        }

        .next {
            margin-left: 10px;
        }

        .disabled {
            background: gray !important;
        }

        .changeinfor input {
            font-size: 13px;
            text-indent: 10px;
            border: 1px solid #26ba99;
            background: white;
            height: 40px;
        }

        .changeinfor label {
            font-size: 13px;
            color: black;
        }

        .img-wrapper {
            position: relative;
            width: 100%;
        }

        .img-responsive {
            width: 100%;
            height: auto;
        }

        .img-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
        }

        .img-overlay:before {
            content: ' ';
            display: block;
            /* adjust 'height' to position overlay content vertically */
            height: 50%;
        }

        input #file-upload-button {
            color: red;
        }

        .banner h1 {
            font-weight: bolder;
            font-size: 50px;
        }

        .banner p {
            letter-spacing: 6px;
            font-size: 38px;
            font-weight: bolder;
        }

        .banner button {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            padding: 16px 48px;
            border-radius: 50px;
            border: none;
            color: #fff;
            box-shadow: 5px 5px 20px 0 rgb(0 0 0 / 20%);
            text-transform: uppercase;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            margin-top: 50px;
        }

        button:focus,
        input:focus {
            outline: none;
        }

        nav li a {
            color: white !important;
            font-size: 14px;
        }

        .next,
        .prev {
            border: 1px solid red;
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            padding: 5px 10px;
            border: 0;
        }

        .next a,
        .prev a {
            text-decoration: none;
            color: white;
        }

        .next {
            margin-left: 10px;
        }

        .disabled {
            background: gray !important;
        }

        .error {
            color: red;
            font-size: 13px !important;
        }

        .survey__question p {
            color: white;
            font-size: 22px;
            font-family: normal 75% Arial, Helvetica, sans-serif;
        }

      

        .survey__answer--main span {
            color: white;
            font-size: 14px;
        }

        .survey__answer--main {
            border: 1px solid white;
            padding: 10px;
            margin-top: 20px;
        }

        .survey__answer {
            margin-top: 30px;
        }

        .inputchecked {
            background: violet !important;
            color: white;
        }

        .footer button:first-child {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            border-radius: 20px;
            font-family: normal 75% Arial, Helvetica, sans-serif;
            font-size: 14px;
            padding: 10px 30px;
        }

        nav {
            border-bottom: 1px solid white;
        }

        nav ul li a {
            color: white !important;
        }

        .survey__answer--button button {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            color: white;
            border: 0;
            font-size: 14px;
            padding: 10px 20px;
            margin-top: 20px;
            float: right;
        }

        .survey__description {
            font-size: 13px;
            color: white;
        }

        input:checked+.survey__answer--main {
            background: wheat;
        }

        nav li a {
            color: white !important;
            font-size: 14px;
        }

        .register input {
            background: transparent;
            border: 1px solid white;
            color: white;
            font-size: 13px;
        }

        /* .register input::placeholder{
            color: #eee;
        } */
        .register button {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            border: 0;
            color: white;
            padding: 10px 20px;
            font-size: 13px;
        }

        button:focus,
        input:focus {
            outline: none;
        }

        .okoko {
            background: red !important;
        }

        input::placeholder {
            color: #ccc;
        }

        .banner h1 {
            font-weight: bolder;
            font-size: 50px;
        }

        .banner p {
            letter-spacing: 6px;
            font-size: 38px;
            font-weight: bolder;
        }

        .banner button {
            background-image: linear-gradient(-30deg, #DC2424, #4A569D);
            padding: 16px 48px;
            border-radius: 50px;
            border: none;
            color: #fff;
            box-shadow: 5px 5px 20px 0 rgb(0 0 0 / 20%);
            text-transform: uppercase;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            margin-top: 50px;
        }

        .banner label {
            color: black !important;
            float: left !important;
        }

        .banner input {
            font-size: 13px;
            text-indent: 10px;
            border: 1px solid #26ba99;
            background: white;
            border-radius: 10px;
            height: 45px;

        }

        .register input {
            background: transparent;
            width: 100%;
        }

        .register label {
            float: left;
        }

        .error {
            color: red;
            font-size: 13px !important;
            float: left;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top w-100" style="border-bottom:1px solid #eee;background-image: linear-gradient(-30deg, #DC2424, #4A569D);">
            <div class="row w-100">
                <div class="col-md-3 col-5">
                    <a class="navbar-brand" href="/"><img src="https://i0.wp.com/s1.uphinh.org/2021/10/02/logo-1.png" width="20%" alt="" class="ml-5"></a>
                </div>
                <div class="col-md-9 col-7">
                    <button class="navbar-toggler float-right border-0" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <img class="navbar-toggler-icon" src="https://img.icons8.com/ios/50/000000/menu--v1.png">
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                        <ul class="navbar-nav mr-5 p-2 justify-content-start mt-3">
                            <?php if (!isset($_SESSION['email'])) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/Auth/register">Đăng ký</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/Auth/login">Đăng nhập</a>
                                </li>
                            <?php } else { ?>
                                <div class="dropdown">
                                    <button class="bg-transparent border-0 text-white
   dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $_SESSION['email'] ?>
                                    </button>
                                    <div class="dropdown-menu border-0 mt-4" aria-labelledby="dropdownMenuButton">
                                        <?php if ($_SESSION['role'] == 2) { ?>
                                            <a class="dropdown-item" href="/admin">Quản trị hệ thống</a>
                                        <?php } ?>
                                        <a class="dropdown-item" href="/Auth/change">Thay đổi thông tin</a>
                                        <a class="dropdown-item" href="/Auth/changepass">Thay đổi mật khẩu</a>
                                        <a class="dropdown-item" href="/Auth/logout">Đăng xuất</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>