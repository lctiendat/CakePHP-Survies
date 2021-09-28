<?= $this->element('user/header') ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="" method="post">
                <?php foreach ($get_user as $user) { ?>
                    <div class="text-center">
                        <img src="/img/avatar/<?= $user->avatar ?>" alt="" class="rounded-circle">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" readonly value="<?= $user->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?= $user->phone ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea name="address" id="" rows="3" class="form-control"><?= $user->address ?></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Old Password</label>
                                <input type="text" class="form-control" name="old_password">
                            </div>
                            <div class="col-md-6">
                                <label for="">New Password</label>
                                <input type="text" class="form-control" name="new_password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-warning text-white">Change</button>
                    </div>
                <?php   } ?>
            </form>
        </div>
    </div>
</div>

<?= $this->element('user/footer') ?>