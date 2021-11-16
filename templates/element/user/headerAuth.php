<?php
$this->disableAutoLayout();
if (!isset($_SESSION)) {
    session_start();
}
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="/css/admin/sb-admin-2.min.css" rel="stylesheet">
<style>
    .error {
        font-size: 13px !important;
        color: red;
        font-weight: normal !important;
        letter-spacing: 0 !important;
    }

    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -30px;
        position: relative;
        z-index: 2;

    }

    #resultEmail,
    #resultPhone,
    #resultPassword {
        float: right;
        margin-left: -25px;
        margin-right: 10px;
        margin-top: -32px;
        position: relative;
        z-index: 2;
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
        background: #212529;
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

    button.close {
        padding: 0 !important;
        border: 0 !important;
        font-size: 0;
        color: transparent !important;
        background: transparent !important;
    }
</style>