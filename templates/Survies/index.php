<?php
$this->disableAutoLayout();

echo $this->element('admin/header') ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Survey</h6>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <input type="text" name="key">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <a href="../survies/add"> <button class="btn btn-primary mb-3 float-right">Add</button> </a>
            <div class="table-responsive">
                <?= $this->Flash->render() ?>
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        <?php
                        if (isset($result)) {
                            if (count($result) > 0) {
                                $i = 1;
                                foreach ($result as $item) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $item->question ?></td>

                                        <td><?= $item->category ?></td>
                                        <td><?= $item->created ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4"><a href="/admin/statistical/survey/<?= $item->id ?>"><i class="fa fa-chart-bar"></i></a></div>
                                                <div class="col-md-4"><a href="../survies/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>
                                                <div class="col-md-4">
                                                    <form method="post" action="/survies/delete/<?= $item->id ?>">
                                                        <input type="hidden" name="_method" value="DELETE" />
                                                        <button type="submit" class="bg-transparent border-0"> <i class="fa fa-trash text-primary"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            }
                        } else { ?>
                            <?php
                            $i = 1;
                            foreach ($survies as $survy) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= mb_strimwidth($survy->question,0,100,'...') ?></td>

                                    <td><?= $survy->category ?></td>
                                    <td><?= $survy->created ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4"><a href="/admin/statistical/survey/<?= $survy->id ?>"><i class="fa fa-chart-bar"></i></a></div>
                                            <div class="col-md-4"><a href="../survies/edit/<?= $survy->id ?>"><i class="fa fa-pen"></i></a></div>
                                            <div class="col-md-4">
                                                <form method="post" action="/survies/delete/<?= $survy->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <button type="submit" class="bg-transparent border-0"> <i class="fa fa-trash text-primary"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
                    <ul class="pagination float-right">
                        <?= $this->Paginator->prev("Prev") ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next("Next") ?>
                    </ul>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>