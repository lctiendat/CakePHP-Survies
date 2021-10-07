<?= $this->element('user/header') ?>
<?php
$nameCategory = '';
foreach ($getCategoryForId as $item) {
    $nameCategory = $item->name;
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
    </style>
</head>

<body>

    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row p-5">
            <div class="col-md-12">
                <?= $this->Flash->render() ?>
                <div class="card p-5" style="background:#F8F8FF;border-radius: 30px;border: 0;">
                    <div class="row banner">
                        <div class="col-md-6">
                            <h1> NỀN TẢNG <span style="color: #26ba99;">KHẢO SÁT</span> </h1>
                            <p>Ngiên cứu thị trường</p>
                            <span style="color: darkgrey;">Chúng tôi chuyên khảo sát thị trường </span> </br>
                            <a href="#survey"><button>Tham gia khảo sát</button></a>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="https://khaosat.me/assets/images/landing_page_top_image.webp?v=2021-10-02-04-05" width="70%" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h1 style="font-size:32px;text-transform: uppercase;font-weight: bolder;"> khảo sát về <?= $nameCategory ?> </h1>
                </center>
                <center>
                    <div style="width: 100px; height: 10px;background: #26ba99;border-radius: 5px;"></div>
                </center>
            </div>
        </div>
       
        <div class="row mt-5" id="survey">
            <?php foreach ($survies as $survy) {
            ?>
                <div class="col-md-4 mt-5">
                    <div class="card p-4" style="border-radius: 30px ;border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);">
                        <span style="color: #424242;border-left: 5px solid #26ba99;border-spacing: 15px;
                   "> <span class="ml-2" style="font-size: 14px;"><?= $survy->category ?></span></span>
                        <a href="/category/<?= $survy->category_id ?>/question/<?= $survy->id ?>" class="text-decoration-none">
                            <h6 class="pt-3 pb-4 mt-2" style="font-weight: bolder;color:black;"><?= $survy->question ?></h6>
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
        <?php if (count($survies) > 6) { ?>
            <div class="row mb-5">
                <div class="col-md-12">
                    <ul class="pagination mt-5 justify-content-end">
                        <?= $this->Paginator->prev("<<") ?>
                        <?= $this->Paginator->next(">>") ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <!-- <div class="row mt-5">
            <div class="col-md-12">
                <center>
                    <h1 style="font-size:32px;text-transform: uppercase;font-weight: bolder;"> đăng ký nhận thông tin từ
                        chúng tôi </h1>
                </center>
                <center>
                    <div style="width: 100px; height: 10px;background: #26ba99;border-radius: 5px;"></div>
                </center>
                <div class="row">
                    <div class="col-md-7 mx-auto">
                        <div class="row mt-5">
                            <div class="col-md-8">
                                <input type="email" name="" id="" placeholder="Email của bạn" class="w-100" style="font-size: 13px;text-indent: 10px; border: 1px solid #26ba99;background: white;border-radius: 10px;height: 40px;">
                            </div>
                            <div class="col-md-4">
                                <button style="background-image: linear-gradient(-30deg, #DC2424, #4A569D);border: 0; height: 40px;color: white;text-transform: uppercase;font-size: 13px;line-height: 40px;padding: 0 20px;">đăng
                                    ký</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="container footer pb-5 mt-5" style="border-top: 1px solid #26ba99;">
        <div class="row mt-5">
            <div class="col-md-4">
                <h5 style="text-transform: uppercase;font-size: 15px;letter-spacing: 3px;font-weight: bolder;">hỗ trợ
                    khách hàng</h5>
                <div class="mt-3" style="width:100px;height:2px;background-image: linear-gradient(-30deg, #DC2424, #4A569D)"></div>
                <h5 class="mt-2" style="text-transform: uppercase;font-size: 15px;letter-spacing: 3px;font-weight: bolder;">hotline
                </h5>
                <p style="font-size: 13px;">0766 667 020</p>
                <h5 class="mt-2" style="text-transform: uppercase;font-size: 15px;letter-spacing: 3px;font-weight: bolder;">email
                </h5>
                <p style="font-size: 13px;">lctiendat@gmail.com</p>
            </div>
            <div class="col-md-4">
                <h5 style="text-transform: uppercase;font-size: 15px;letter-spacing: 3px;font-weight: bolder;">về chúng
                    tôi</h5>
                <div class="mt-3 mb-3" style="width:100px;height:2px;background-image: linear-gradient(-30deg, #DC2424, #4A569D)"></div>
                <p style="font-size: 13px;">Hỏi đáp</p>
                <p style="font-size: 13px;">Bảo mật</p>

                <p style="font-size: 13px;">Điều khoản</p>

                <p style="font-size: 13px;">Blog</p>

            </div>
            <div class="col-md-4">
                <h5 style="text-transform: uppercase;font-size: 15px;letter-spacing: 3px;font-weight: bolder;" class="mb-4">kết nối
                </h5>
                <i class="fab fa-facebook-square" style="color: darkblue;font-size: 40px;"></i>
                <i class="fab fa-youtube-square ml-4" style="color: red;font-size: 40px;"></i>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="fixed-bottom float-right r-0">
                    <p id='toTop' class="r-0 float-right"><i class="fa fa-angle-up mr-5 text-white" style="background-image: linear-gradient(-30deg, #DC2424, #4A569D);padding:10px 20px"></i></p>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(() => {
        $(window).scroll(function() {
            if ($(this).scrollTop()) {
                $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });

        $("#toTop").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, 1000);
        });
    })
</script>

</html>