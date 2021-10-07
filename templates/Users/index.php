<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách User</h6>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <input type="text" name="key">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="table-responsive mt-4">
                <?= $this->Flash->render() ?>
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tfoot>
                    <tbody>
                        <?php
                        if (isset($result)) {
                            if (count($result) > 0) {
                                $i = 1;
                                foreach ($result as $item) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $item->email ?></td>
                                        <td><?php if ($item->status == 1) { ?>
                                                <span class="badge badge-secondary p-2">Disable</span>
                                            <?php } else { ?>
                                                <span class="badge badge-success p-2">Enable</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php if ($item->role == 1) { ?>
                                                <span class="badge badge-warning p-2">User</span>
                                            <?php } else { ?>
                                                <span class="badge badge-danger p-2">Admin</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12"><a href="../users/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>

                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            }
                        } else { ?>
                            <?php
                            $i = 1;
                            foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?php if ($user->status == 1) { ?>
                                            <span class="badge badge-secondary p-2">Disable</span>
                                        <?php } else { ?>
                                            <span class="badge badge-success p-2">Enable</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php if ($user->role == 1) { ?>
                                            <span class="badge badge-warning p-2">User</span>
                                        <?php } else { ?>
                                            <span class="badge badge-danger p-2">Admin</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12"><a href="../users/edit/<?= $user->id ?>"><i class="fa fa-pen"></i></a></div>

                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
                <?php if (count($users) > 10) { ?>
                    <ul class="pagination float-right">
                        <?= $this->Paginator->prev("Prev") ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next("Next") ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>