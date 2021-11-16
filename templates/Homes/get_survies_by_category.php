<?= $this->element('user/header') ?>
<?php
$nameCategory = '';
foreach ($getCategoryForId as $item) {
    $nameCategory = $item->name;
}
?>
<div class="container" id="survey">
    <div class="row">
        <?= $this->Flash->render() ?>
        <div class="col-md-12">
            <center>
                <h1> SURVEY ON <?= $nameCategory ?> </h1>
            </center>
            <center>
                <div></div>
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <form action="#survey">
                <input type="text" name="key" style="border: 1px solid #ccc;height:40px" value="<?php if (isset($_SESSION['valueSearch'])) { ?><?= trim($_SESSION['valueSearch'])  ?><?php }
                                                                                                                                                                                    unset($_SESSION['valueSearch']) ?>">
                <button type="submit" class="btn btn-primary" style="background: #212529;height: 40px !important;
    border-radius: 0 !important;margin-top:-5px">Search</button>
            </form>
        </div>
    </div>
    <div class="row mt-2">
        <?php if (isset($_SESSION['searchError'])) { ?>
            <div class="col-md-9 mx-auto">
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $_SESSION['searchError']; ?>
                </div>
            </div>
            <div class="col-md-9 mx-auto">
                <button type="submit" class="btn text-white float-left back" style="background: #212529;border-radius:0">Back <i class="fa fa-undo-alt"></i></button>
            </div>
        <?php }
        ?>
        <?php
        if (isset($result)) {
            if (count($result) > 0) {
                foreach ($result as $item) { ?>
                    <div class="col-md-9 mx-auto mt-3">
                        <div class="card p-3" style="border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);">
                            <div class="row">
                                <div class="col-10">
                                    <span style="color: #424242;border-left: 5px solid #26ba99;border-spacing: 15px;
                   "> <span class="ml-2" style="font-size: 14px;"><?= $item->category ?></span></span>
                                    <a href="/category/<?= $item->category_id ?>/question/<?= $item->id ?>" class="text-decoration-none">
                                        <h6 class="pt-3 pb-2 mt-2" style="font-weight: bolder;color:black;font-size:15px;"><?= $item->question ?> </h6>
                                    </a>
                                </div>
                                <div class="col-2">
                                    <?php if (isset($_SESSION['arrUserSession']['email'])) {
                                        foreach ($user_check as $item1) {
                                            if ($item->id == $item1->survey_id) { ?> <i style="font-size: 45px;" title="Đã trả lời" class="mt-3 fa fa-check-circle text-success"></i> <?php }
                                                                                                                                                                                }
                                                                                                                                                                            } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            }
        } else { ?>
            <?php foreach ($survies as $survy) {
            ?>
                <div class="col-md-9 mx-auto mt-3">
                    <div class="card p-3" style="border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);">
                        <div class="row">
                            <div class="col-10">
                                <span style="color: #424242;border-left: 5px solid #26ba99;border-spacing: 15px;
                   "> <span class="ml-2" style="font-size: 14px;"><?= $survy->category ?></span></span>
                                <a href="/category/<?= $survy->category_id ?>/question/<?= $survy->id ?>" class="text-decoration-none">
                                    <h6 class="pt-2 pb-2 mt-2" style="font-weight: bolder;color:black;font-size:15px"><?= $survy->question ?></h6>
                                </a>
                            </div>
                            <div class="col-2">
                                <?php if ($survy->user_check != NULL) { ?>
                                    <div class="col-2">
                                        <i title="Đã trả lời" style="font-size: 45px;" class="fa fa-check-circle text-success mt-3"></i>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>

    </div>
    <?php if (isset($result)) {
        if ($result != [] && $countResult > PAGE_COUNT_CLIENT) { ?>
            <ul class="pagination float-right mt-2">
                <?= $this->Paginator->prev("Prev") ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next("Next") ?>
            </ul>
    <?php }
    }
    ?>
    <?php if (isset($survies) && !isset($result)) {
        if ($getQualitySurvies > PAGE_COUNT_CLIENT) { ?>
            <ul class="pagination float-right mt-2">
                <?= $this->Paginator->prev("Prev") ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next("Next") ?>
            </ul>
    <?php }
    }
    ?>
    <div class="row" <?php if (isset($_SESSION['searchError'])) { ?> style="display: none;" <?php }
                                                                                        unset($_SESSION['searchError'])  ?>>
        <div class="col-md-12 mx-auto">
            <button type="button" class="btn text-white float-left back mt-2 backtoPrePage" style="background: #212529;border-radius:0">Back <i class="fa fa-undo-alt"></i></button>
        </div>
    </div>
</div>
<div class="container footer pb-5 mt-5" style="border-top: 1px solid #26ba99;">
    <div class="row mt-5">
        <div class="col-md-4 col-6">
            <h5>CUSTOMER SUPPORT</h5>
            <div class="mt-3"></div>
            <h5 class="mt-2">hotline</h5>
            <p>0766 667 020</p>
            <h5 class="mt-2">email</h5>
            <p>lctiendat@gmail.com</p>
        </div>
        <div class="col-md-4 col-6">
            <h5>about us</h5>
            <div class="mt-3 mb-3"></div>
            <p>Q&A</p>
            <p>Security</p>
            <p>Rules</p>
            <p>Blog</p>
        </div>
        <div class="col-md-4">
            <h5 class="mb-4">connection</h5>
            <i class="fab fa-facebook-square"></i>
            <i class="fab fa-youtube-square ml-4"></i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="fixed-bottom float-right r-0">
                <p id='toTop' class="r-0 float-right"><i class="fa fa-angle-up mr-5 text-white"></i></p>
            </div>
        </div>
    </div>
</div>

</body>
<?= $this->element('user/scriptBootstrap') ?>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
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
        $('.back').click((e) => {
            e.preventDefault();
            if (document.referrer == '') {
                window.location.href = url_domain_name
            } else {
                window.history.back()
            }
        })
        $('.backtoPrePage').click(() => {
            if (document.referrer == '') {
                window.location.href = url_domain_name
            } else {}
        })

    })
</script>

</html>