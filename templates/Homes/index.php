<?= $this->element('user/header') ?>

    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row p-5">
            <div class="col-md-12">
                <?= $this->Flash->render() ?>
                <div class="card p-5" style="background:#F8F8FF;border-radius: 30px;border: 0;">
                    <div class="row banner">
                        <div class="col-md-6">
                            <h1> NỀN TẢNG <span style="color: #26ba99;">KHẢO SÁT</span> </h1>
                            <p>Ngiên cứu thị trường</p>
                           
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
    <div class="container" id="survey">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h1 style="font-size:32px;text-transform: uppercase;font-weight: bolder;"> chúng tôi khảo sát những
                        gì </h1>
                </center>
                <center>
                    <div style="width: 100px; height: 10px;background: #26ba99;border-radius: 5px;"></div>
                </center>
            </div>
        </div>
        <div class="row mt-5">

            <?php foreach ($countSurveyInCategory as $category) { ?>
                <a href="/category/<?= $category->CategoryId ?>"><button type="button" class="btn btn-primary ml-3 bg-white text-dark" style="border: 1px solid black; border-radius:5px;padding: 5px 20px">
                        <?= $category->CategoryName ?> <span class="badge badge-dark text-white"><?= $category->count ?></span>
                    </button></a>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-right">
                <form action="#survey" method="post">
                    <input type="text" name="key" style="border: 1px solid #ccc;height:40px">
                    <button type="submit" class="btn btn-primary" style="background-image: linear-gradient(-30deg, #DC2424, #4A569D)">Search</button>
                </form>
            </div>
        </div>
        <div class="row mt-2" >
            <?php
            if (isset($result)) {
                if (count($result) > 0) {
                    $i = 1;
                    foreach ($result as $item) { ?>
                        <div class="col-md-4 mt-3">
                            <div class="card p-4" style="border-radius: 30px ;border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);">
                                <span style="color: #424242;border-left: 5px solid #26ba99;border-spacing: 15px;
                   "> <span class="ml-2" style="font-size: 14px;"><?= $item->category ?></span></span>
                                <a href="/category/<?= $item->category_id ?>/question/<?= $item->id ?>" class="text-decoration-none">
                                    <h6 class="pt-3 pb-4 mt-2" style="font-weight: bolder;color:black;"><?= $item->question ?></h6>
                                </a>
                            </div>
                        </div>
                <?php }
                }
            } else { ?>
                <?php foreach ($survies as $survy) {
                ?>
                    <div class="col-md-4 mt-3">
                        <div class="card p-4" style="border-radius: 30px ;border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);">
                            <span style="color: #424242;border-left: 5px solid #26ba99;border-spacing: 15px;
                   "> <span class="ml-2" style="font-size: 14px;"><?= $survy->category ?></span></span>
                            <a href="/category/<?= $survy->category_id ?>/question/<?= $survy->id ?>" class="text-decoration-none">
                                <h6 class="pt-3 pb-4 mt-2" style="font-weight: bolder;color:black;"><?= $survy->question ?></h6>
                            </a>
                        </div>
                    </div>
            <?php }
            } ?>

        </div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <ul class="pagination mt-5 justify-content-end">
                        <?= $this->Paginator->prev("<<") ?>
                        <?= $this->Paginator->next(">>") ?>
                    </ul>
                </div>
            </div>
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