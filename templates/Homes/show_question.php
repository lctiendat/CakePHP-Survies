<?= $this->element('user/header') ?>
<style>
    body {
        background-image: url(https://wallpaperaccess.com/full/279547.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<div class="container" style="margin-top: 150px;">
    <?= $this->Flash->render() ?>
    <div class="row" style="margin-top:100px">
        <div class="col-md-7 mx-auto survey">
            <div class="survey__question">
                <?php foreach ($survies as $survey) {
                    $type_select = $survey->type_select;
                ?>
                    <p> <?= $survey->question ?></p>
            </div>
            <div class="survey__answer">
                <span class="survey__description"> <?= $survey->description ?></span>
            <?php } ?>
            <?php if (!isset($_SESSION['email'])) { ?>
                <form action="/result/saveNoLogin/<?= $survey->id ?>" method="post">
                <?php } else { ?>
                    <form action="/result/save/<?= $survey->id ?>" method="post">
                    <? } ?>
                    <?php foreach ($answers as $answer) {
                    ?>
                        <div class="survey__answer--main">
                            <input type="<?php if ($type_select == 1) { ?>radio<?php } else { ?>checkbox<?php } ?>" name="answer_id[]" id="" value="<?= $answer->id ?>" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                                                            foreach ($getAnswerUser as $item) {
                                                                                                                                                                                if ($answer->id == $item->answer_id) { ?> checked <?php }
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                            } ?>> <span> <?= $answer->name ?>
                            </span>
                        </div>

                    <?php } ?>
                    <?php if (isset($_SESSION['email'])) { ?>
                        <div class="survey__answer--button">
                            <button type="submit" name="btn_binhchon">Bình chọn</button>
                        </div>
                    <?php } ?>
            </div>
        </div>
        <?php if (!isset($_SESSION['email'])) { ?>
            <div class="col-md-5 text-center register">
                <p class="text-white" style="font-size: 22px;">Điền đầy đủ thông tin để hoàn thành khảo sát</p>
                <div class="card p-5 bg-transparent border-0">
                    <div class="form-group">
                        <label for="" style="color: white;font-size: 13px;">Email</label>
                        <input type="email" name="email" id="" class="p-2 w-100" require aria-required placeholder="Email của bạn">
                        <?php if (isset($_SESSION['errorEmail'])) { ?>
                            <p class="error"><?= $_SESSION['errorEmail']; ?></p>
                        <?php }
                        unset($_SESSION['errorEmail']) ?>
                    </div>
                    <div class="form-group">
                        <label for="" style="color: white;font-size: 13px;">Số điện thoại</label>
                        <input type="number" name="phone" id="" class="p-2 w-100" placeholder="Số điện thoại của bạn">
                        <?php if (isset($_SESSION['errorPhone'])) { ?>
                            <p class="error"><?= $_SESSION['errorPhone']; ?></p>
                        <?php }
                        unset($_SESSION['errorPhone']) ?>
                    </div>
                    <div class="form-group">
                        <label for="" style="color: white;font-size: 13px;">Mật khẩu</label>
                        <input type="password" name="password" id="" class="p-2 w-100" placeholder="Mật khẩu của bạn của bạn">
                        <?php if (isset($_SESSION['errorPassword'])) { ?>
                            <p class="error"><?= $_SESSION['errorPassword']; ?></p>
                        <?php }
                        unset($_SESSION['errorPassword']) ?>
                    </div>

                    <div class="survey__answer--button">
                        <button type="submit" name="btn_binhchon">Bình chọn</button>
                    </div>
                <?php } ?>
                </form>
                </div>
            </div>
    </div>
</div>

<!-- <div class="container-fluid">
        <div class="row footer fixed-bottom">
            <div class="col-md-4">
                <button class="btn btn-success mb-3 ml-3 border-0">
                    Trước
                </button>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn btn-success mb-3 ml-3 border-0" style="border-radius:0">
                    1/100
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success mb-3 mr-3 border-0 float-right">
                    Tiếp
                </button>
            </div>
        </div>
    </div> -->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    '<?php if (isset($getAnswerUser)) { ?>'
    if ('<?php echo count($getAnswerUser) > 0 ?>') {
        Swal.fire({
            title: 'Bình chọn lại ?',
            text: "Bạn đã bình chọn câu trả lời này rồi. Bạn có muốn chọn lại ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có, tôi muốn',
            cancelButtonText: "Không",
        }).then((result) => {
            if (result.isConfirmed) {

            } else {
                window.location.href = '/';
            }
        })
    }
    '<?php } ?>'
</script>

</html>