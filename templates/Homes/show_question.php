<?= $this->element('user/header') ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-7 mx-auto">
            <div class="mx-0 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="far fa-file-alt fa-4x mb-3 text-primary"></i>
                            <p>
                                <?php foreach ($survies as $survey) { ?>
                                    <strong>
                                        <?= $survey->question ?>
                                    </strong>
                            </p>
                            <p style="font-size: 13px;">
                                <?= $survey->description ?>
                            </p>

                        </div>
                        <hr />
                    <?php } ?>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <form class="px-4" action="/result/saveNoLogin/<?= $survey->id ?>" method="POST">
                        <?php } else { ?>
                            <form class="px-4" action="/result/save/<?= $survey->id ?>" method="POST">
                            <?php } ?>
                            <p class="text-center"><strong>Your rating:</strong></p>
                            <?php foreach ($answers as $answer) { ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="<?= $answer->type_select == 1 ? "checkbox" : "radio" ?>" name="answer_id" id="radioExample1" value="<?= $answer->id ?>" />
                                    <label class="form-check-label" for="radioExample1">
                                        <?= $answer->name ?>
                                    </label>
                                </div>
                            <?php } ?>
                    </div>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal Heading</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" placeholder="Email Address" style="border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="phone" id="exampleInputEmail" placeholder="Your Phone" style="border: 1px solid #ccc;">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="Password" style="border: 1px solid #ccc;">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="re_password" id="exampleRepeatPassword" placeholder="Repeat Password" style="border: 1px solid #ccc;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="created" value="<?= date('Y-m-d h:m:s') ?>">
                                    <input type="hidden" name="modified" value="<?= date('Y-m-d h:m:s') ?>">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Submit
                                    </button>
                                    <hr>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Submit
                            </button> <?php } else { ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        <?php } ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->element('user/footer') ?>