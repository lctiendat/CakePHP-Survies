<?= $this->element('admin/header') ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Answer</h6>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <input type="text" name="key" value="<?php if (isset($_SESSION['valueSearch'])) { ?> <?= trim($_SESSION['valueSearch'])  ?> <?php }
                                                                                                                                        unset($_SESSION['valueSearch']) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <a href="/admin/answers/add"> <button class="btn btn-primary mb-3 float-right">Add</button> </a>
            <div class="table-responsive">
                <p> <?= $this->Flash->render() ?></p>
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Survey</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result)) {
                            if (count($result) > 0) {
                                $i = 1;
                                if (isset($_GET['page'])) {
                                    $i = $_GET['page'] . '0' + $i - 10;
                                }
                                foreach ($result as $item) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $item->name ?></td>
                                        <td> <?php if (strlen($item->question) > 50) { ?>
                                                <?= mb_strimwidth($item->question, 0, 50) . '...'  ?>
                                            <?php } else { ?>
                                                <?= $item->question ?>
                                            <?php  } ?>
                                        <td><?= $item->created ?></td>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6"><a href="/admin/answers/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>
                                                <div class="col-md-6">
                                                    <form method="post" action="/admin/answers/delete/<?= $item->id ?>">
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
                            if (isset($_GET['page'])) {
                                $i = $_GET['page'] . '0' + $i - 10;
                            }
                            foreach ($answers as $answer) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $answer->name ?></td>
                                    <td> <?php if (strlen($answer->question) > 50) { ?>
                                            <?= mb_strimwidth($answer->question, 0, 50) . '...'  ?>
                                        <?php } else { ?>
                                            <?= $answer->question ?>
                                        <?php  } ?>
                                    </td>
                                    <td><?= $answer->created ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6"><a href="/admin/answers/edit/<?= $answer->id ?>"><i class="fa fa-pen"></i></a></div>
                                            <div class="col-md-6">
                                                <form method="post" action="/admin/answers/delete/<?= $answer->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
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
                <?php if (isset($result)) { ?>
                    <a href="/admin/answers"> <button class="btn btn-primary float-left back">Back <i class="fa fa-undo-alt"></i></button>
                    <?php
                } ?>
                    <?php if ($countQualityAnswers > 10) { ?>
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
</div>
<?= $this->element('admin/footer') ?>