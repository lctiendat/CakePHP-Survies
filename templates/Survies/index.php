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
                <a href="../survies/add"> <button class="btn btn-primary mb-3 float-right">Add</button> </a>
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Time End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Time End</th>
                        <th>Action</th>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($survies as $survy) { ?>
                            <tr>
                                <td><?= h($i++) ?></td>
                                <td><?= h($survy->question) ?></td>
                                <td><?php if ($survy->status == 1) { ?>
                                        <span class="badge badge-secondary p-2">Disable</span>
                                    <?php } else { ?>
                                        <span class="badge badge-success p-2">Enable</span>
                                    <?php } ?>
                                </td>
                                <td><?= h($survy->category_name) ?></td>
                                <td><?= h($survy->created) ?></td>
                                <td><?= h($survy->time_end) ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><a href="../survies/edit/<?= h($survy->id) ?>"><i class="fa fa-pen"></i></a></div>
                                        <div class="col-md-6">
                                            <form method="post" action="/survies/delete/<?= h($survy->id) ?>">
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