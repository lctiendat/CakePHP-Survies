<?= $this->element('user/header') ?>
<div class="container" style="margin-top:200px">
    <div class="row changeinfor">
        <div class="col-md-5 mx-auto">
            <?= $this->Flash->render() ?>
            <form action="" method="post" enctype="multipart/form-data">

                <?php foreach ($get_user as $user) { ?>
                    <div class="form-group">
                        <div class="img-wrapper">
                            <center>
                                <img src="/img/avatar/<?= $user->avatar ?>" alt="" class="rounded-circle" class="img-responsive" style="border: 2px solid white;width:150px;height:150px;  position: relative;">
                            </center>
                            <div class="img-overlay">
                                <input type="file" name="avatar" class="position-absolute btn bg-transparent border-0 " style="color: transparent;left:165px;top:60px;border:0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" readonly value="<?= $user->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="number" class="form-control" name="phone" value="<?= $user->phone ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address" id="" rows="3" class="form-control"><?= $user->address ?></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Password <a class="text-white" href="/Auth/changepass">Change pass</a></label>
                        <input type="password" class="form-control" name="password">
                    </div> -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn  text-white" style="background-image: linear-gradient(-30deg, #DC2424, #4A569D);
">Change</button>
                    </div>
                <?php   } ?>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(() => {
        $('input[type="file"]').on('change', function() {
            $(this).closest('form').submit();
        });
    })
</script>