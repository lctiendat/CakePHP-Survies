<?= $this->element('user/header') ?>
<div class="container changeinfor" style="margin-top: 200px;">
    <div class="row">

        <div class="col-md-6 mx-auto">

            <center>
                <h5 class="text-dark">Thay đổi mật khẩu</h5>
            </center>
            <?= $this->Flash->render() ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" class="form-control" name="old_password">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="new_password">
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn
                     text-white" style="background-image: linear-gradient(-30deg, #DC2424, #4A569D);
">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>