<?= $this->element('user/header') ?>

<body style="background: #f8f9fa;">

    <div class="container" style="margin-top:200px">
        <div class="row changeinfor">
            <div class="col-md-5 mx-auto p-5" style="border:2px solid #26ba99;border-radius:20px">
                <?= $this->Flash->render() ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <?php foreach ($get_user as $user) { ?>
                        <div class="form-group">
                            <div class="img-wrapper">
                                <center>
                                    <img src="/img/avatar/<?= $user->avatar ?>" alt="" class="rounded-circle img-responsive" style="border: 2px solid white;width:150px;height:150px;  position: relative;">
                                </center>
                                <div class="img-overlay">
                                    <input type="file" name="avatar" class="position-absolute btn bg-transparent border-0 " style="color: transparent;left:135px;top:150px;border:0">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?><?php } ?>">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" readonly value="<?= $user->email ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" onkeypress='validate(event)' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="phone" value="<?php if (isset($_SESSION['arrOldValueSession']['OldValuePhone'])) { ?><?= h($_SESSION['arrOldValueSession']['OldValuePhone']) ?><?php  } else { ?><?= h($user->phone) ?><?php }
                                                                                                                                                                                                                                                                                                                                                                                                                            unset($_SESSION['arrOldValueSession']['OldValuePhone']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" id="" rows="3" class="form-control"><?php if (isset($_SESSION['arrOldValueSession']['OldValueAddress'])) { ?><?= h($_SESSION['arrOldValueSession']['OldValueAddress']) ?>
                        <?php  } else { ?><?= $user->address ?><?php }
                                                                                            unset($_SESSION['arrOldValueSession']['OldValueAddress']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn  text-white" style="background: #212529;border-radius:0">Change</button>
                            <a href="<?php if (isset($_SESSION['oldPage'])) { ?><?php echo $_SESSION['oldPage'] ?><?php } ?>"><button style="background: #212529;border-radius:0" type="button" class="btn btn-primary float-right <?php if (!isset($_SESSION['oldPage'])) { ?> back <?php } ?> ">Back <i class="fa fa-undo-alt"></i></button></a>
                        </div>
                    <?php   } ?>
                </form>
            </div>
        </div>
    </div>
</body>
<?= $this->element('user/scriptBootstrap') ?>
<script>
    $(document).ready(() => {
        $('.back').click((e) => {
            e.preventDefault();
            window.history.back();
        })
    })

    // click once button
    $('button[type="submit"]').click((e) => {
        e.preventDefault()
        $('button[type="submit"]')
            .attr('disabled', 'disabled');
        $(e.target).parents('form').submit()
    })

    function validate(evt) {
        var theEvent = evt || window.event;
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    $(window).on('load', () => {
        document.querySelector('input[type="file"]').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.querySelector('img.rounded-circle');
                img.onload = () => {
                    URL.revokeObjectURL(img.src);
                }
                img.src = URL.createObjectURL(this.files[0]);
            }
        });
    })
</script>