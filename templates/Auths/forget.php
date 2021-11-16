<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->element('user/headerAuth') ?>
    <title>Forget Password</title>
</head>

<body class="bg-gradient-primary">
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row p-5">
            <div class="col-md-8 mx-auto">
                <div class="card p-5" style="background:#F8F8FF;border-radius: 30px;border: 0;">
                    <div class="row banner">
                        <div class="col-md-6">
                            <h1 class="mt-5"> BACK <span style="color: #26ba99;">LOG IN</span> </h1>
                            <a href="/auths/login"><button>LOG IN</button></a>
                        </div>
                        <div class="col-md-6" style="border-left:  1px solid gray;">
                        <a href="/" style="background: #212529;border:0" class="btn btn-primary float-left mt-3 ml-3">On the homepage <i class="fa fa-long-arrow-alt-left"></i></a>
                            <div class="p-5 mt-3">
                                <?= $this->Flash->render() ?>
                                <div class="text-center">
                                    <h3 class=" text-gray-900 mb-4">Reset Password!</h3>
                                </div>
                                <form class="user" action="" method="POST">
                                    <div class="form-group">
                                        <input type="email " name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." require value="<?php if (isset($_SESSION['arrOldValueSession']['OldValueEmail'])) { ?><?= $_SESSION['arrOldValueSession']['OldValueEmail'] ?>
<?php  }
                                                                                                                                                                                                                            unset($_SESSION['arrOldValueSession']['OldValueEmail']) ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" style="margin-top: 0;">
                                        Reset Password
                                    </button>
                                </form>
                                <div class="text-center">
                                    <a class="small" href="/auths/register">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</body>
<?= $this->element('user/scriptBootstrap') ?>

</html>