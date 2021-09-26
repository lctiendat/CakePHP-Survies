<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
                        $i = 1;
                        foreach ($users as $user) { ?>
                            <tr>
                                <td><?= h($i++) ?></td>
                                <td><?= h($user->email) ?></td>
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
                                        <div class="col-md-6"><a href="../users/edit/<?= h($user->id) ?>"><i class="fa fa-pen"></i></a></div>
                                        <div class="col-md-6">
                                            <form method="post" action="/users/delete/<?= h($user->id) ?>">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button type="submit" class="bg-transparent border-0"> <i class="fa fa-trash text-primary"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php   } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>