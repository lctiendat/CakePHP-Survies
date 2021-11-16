<?= $this->element('user/header') ?>

<body style="background: #f8f9fa;">
    <div class="container changeinfor mb-5" style="margin-top: 200px;">
        <div class="row">
            <?= $this->Flash->render() ?>
            <div class="col-md-12">
                <center>
                    <h1 style="font-size:32px;text-transform: uppercase;font-weight: bolder;"> Voted History </h1>
                </center>
                <center>
                    <div style="width: 100px; height: 10px;background: #26ba99;border-radius: 5px;"></div>
                </center>
            </div>
        </div>
        <?php if ($countCategoryChoose > 0) { ?>
            <div class="row mt-4">
                <div class="col-md-12 text-right">
                    <form action="#survey">
                        <input type="text" name="key" style="border: 1px solid #ccc;height:40px" value="<?php if (isset($_SESSION['valueSearch'])) { ?><?= trim($_SESSION['valueSearch'])  ?><?php }
                                                                                                                                                                                            unset($_SESSION['valueSearch']) ?>">
                        <button type="submit" class="btn btn-primary" style="background: #212529;height: 40px !important;
    border-radius: 0 !important;margin-top:-4px">Search</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        <div class="row mt-4">
            <?php if (isset($_SESSION['searchError'])) { ?>
                <div class="col-md-9 mx-auto">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $_SESSION['searchError']; ?>

                    </div>
                </div>
                <div class="col-md-9 mx-auto">
                    <button type="submit" class="btn text-white float-left backtoPrePage" style="background: #212529;border-radius:0">Back <i class="fa fa-undo-alt"></i></button>
                </div>
            <?php }
            ?>
            <?php if ($countCategoryChoose > 0) { ?>
                <?php if (isset($result)) {
                    if (count($result) > 0) {
                        foreach ($result as $item) {
                ?>
                            <div class="col-md-9 mx-auto mt-3">
                                <div class="card p-3" style="border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);border-left: 5px solid #26ba99;">
                                    <div class="row">
                                        <div class="col-10">
                                            <a href="/<?= $item->id ?>/question" class="text-decoration-none">
                                                <h6 class="pt-2 pb-2 mt-2 text-dark"><?= $item->name ?> </h6>
                                            </a>
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-check-circle mt-3" style="color: blue;font-size:25px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    }
                } else { ?>
                    <?php foreach ($categories as $item) {
                    ?>
                        <div class="col-md-9 mx-auto mt-3">
                            <div class="card p-3" style="border: 0;box-shadow: 5px 5px 50px rgb(0 0 0 / 10%);border-left: 5px solid #26ba99;">
                                <div class="row">
                                    <div class="col-10">
                                        <a href="/<?= $item->id ?>/question" class="text-decoration-none">
                                            <h6 class="pt-2 pb-2 mt-2 text-dark"><?= $item->name ?> </h6>
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa fa-check-circle mt-3" style="color: blue;font-size:25px"></i>
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
                    if ($countCategoryChoose > PAGE_COUNT_CLIENT) { ?>
                <ul class="pagination float-right mt-2">
                    <?= $this->Paginator->prev("Prev") ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next("Next") ?>
                </ul>
            <?php }
            ?>
        <?php }
        ?>
    <?php } else { ?>
        <div class="row w-100 mb-5">
            <div class="col-md-12">
                <center>
                    <h3>You have not voted any answer yet</h3>
                </center>
            <?php }  ?>
            <div class="row" <?php
                                if (isset($_SESSION['searchError'])) { ?> style="display: none;" <?php }
                                                                                                unset($_SESSION['searchError'])  ?>>
                <div class="col-md-12">
                    <button type="button" class="btn text-white float-left backtoPrePage" style="background: #212529;border-radius:0">Back <i class="fa fa-undo-alt"></i></button>
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
</body>
<?= $this->element('user/scriptBootstrap') ?>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $(document).ready(() => {
        $('.back').click((e) => {
            e.preventDefault();
            window.location.href = '/';
        })
    })
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name
        } else {
            window.history.back()
        }
    })
</script>