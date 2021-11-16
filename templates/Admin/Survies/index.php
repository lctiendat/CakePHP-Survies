<?= $this->element('admin/header') ?>
<?php
if (isset($countResult)) {
    $countResultSort = $countResult;
}
?>
<div class="container-fluid">
    <div class="card shadow mb-4 p-3">
        <?= $this->Flash->render() ?>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Survey</h6>
            <a href="/admin/survies/add"> <button class="btn btn-primary mb-3 float-right">Add</button> </a>
        </div>
        <?php if ($countQualitySurvies == 0) { ?>
            <center>
                <h3 class="p-3">Have not Survey</h3>
            </center>
        <?php } else { ?>
            <div class="card-body">
                <form action="" method="get">
                    <input type="text" name="key" value="<?php if (isset($_SESSION['valueSearch'])) { ?><?= trim($_SESSION['valueSearch'])  ?><?php }
                                                                                                                                            unset($_SESSION['valueSearch']) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered " data-sort='asc' id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th><?= $this->Paginator->sort('Survies.id', 'ID'); ?></th>
                                <th><?= $this->Paginator->sort('question'); ?></th>
                                <th><?= $this->Paginator->sort('Categories.name', 'Category'); ?></th>
                                <th><?= $this->Paginator->sort('Survies.created', 'Created'); ?></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody id="dataTable1">
                            <?php
                            if (isset($result)) {
                                if (count($result) > 0) {
                                    if (isset($_GET['page'])) {
                                        $countResult1 = $countResult - (($_GET['page'] - 1) . '0');
                                    }
                                    foreach ($result as $key => $item) {
                            ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php if (isset($_GET['direction']) && $_GET['direction'] == 'desc' && $_GET['sort'] == 'Survies.id') {
                                                ?>
                                                    <?php if (isset($_GET['page'])) {
                                                    ?>
                                                        <?= $countResult1-- ?>
                                                    <?php } else {
                                                    ?>
                                                        <?= $countResult-- ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?= $pageStart++ ?>
                                                <?php } ?>
                                            </td>
                                            <td><?= mb_strimwidth($item->question, 0, 70, '...') ?></td>
                                            <td><?= $item->category ?></td>
                                            <td><?= $item->created ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md"><a data-placement="top" title="Add Answer" data-toggle="tooltip" data-placement="top" href="/admin/survies/<?= $item->id ?>/add"><i class="fa fa-plus"></i></a></div>
                                                    <?php if ($item->count != NULL) { ?>
                                                        <div class="col-md"><a data-placement="top" title="Statistical" data-toggle="tooltip" data-placement="top" href="/admin/statistical/survey/<?= $item->id ?>"><i class="fa fa-chart-bar"></i></a></div>
                                                    <?php } ?>
                                                    <div class="col-md"><a href="/admin/survies/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>
                                                    <div class="col-md">
                                                        <form method="post" action="/admin/survies/delete/<?= $item->id ?>">
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
                                foreach ($survies as $survy) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $pageStart++ ?></td>
                                        <td><?= mb_strimwidth($survy->question, 0, 70, '...') ?></td>
                                        <td><?= h($survy->category) ?></td>
                                        <td><?= $survy->created ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md"><a data-placement="top" title="Add Answer" data-toggle="tooltip" data-placement="top" href="/admin/survies/<?= $survy->id ?>/add"><i class="fa fa-plus"></i></a></div>
                                                <?php if ($survy->count != NULL) { ?>
                                                    <div class="col-md"><a data-placement="top" title="Statistical" data-toggle="tooltip" data-placement="top" href="/admin/statistical/survey/<?= $survy->id ?>"><i class="fa fa-chart-bar"></i></a></div>
                                                <?php } ?>
                                                <div class="col-md"><a data-placement="top" title="Edit" data-toggle="tooltip" data-placement="top" href="/admin/survies/edit/<?= $survy->id ?>"><i class="fa fa-pen"></i></a></div>
                                                <div class="col-md">
                                                    <form method="post" action="/admin/survies/delete/<?= $survy->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
                                                        <input type="hidden" name="_method" value="DELETE" />
                                                        <button type="submit" class="bg-transparent border-0"> <i data-placement="top" title="Remove" data-toggle="tooltip" data-placement="top" class="fa fa-trash text-primary"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <?php if (isset($result) && !isset($_GET['sort'])) { ?>
                        <button class="btn btn-primary float-left back">Back <i class="fa fa-undo-alt"></i></button>
                    <?php
                    } ?>
                    <?php if (isset($result)) {
                        $countResult = $countResultSort;
                        if ($result != [] && $countResult > PAGE_COUNT_ADMIN) { ?>
                            <ul class="pagination float-right">
                                <?= $this->Paginator->prev("Prev") ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next("Next") ?>
                            </ul>
                    <?php }
                    }
                    ?>
                    <?php if (isset($survies) && !isset($result)) {
                        if ($countQualitySurvies > PAGE_COUNT_ADMIN) { ?>
                            <ul class="pagination float-right">
                                <?= $this->Paginator->prev("Prev") ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next("Next") ?>
                            </ul>
                        <?php }
                        ?>
                </div>
            </div>
    <?php }
                } ?>
    </div>
</div>
</div>

</div>
</div>
<?= $this->element('admin/footer') ?>
<script>
    // color for colum choosed
    let url = window.location.href;
    let url_current = new URL(url)
    let sort = url_current.searchParams.get('sort');
    let direction = url_current.searchParams.get('direction');
    let dataSort = ["Survies.id", 'question', "Categories.name", 'Survies.created']
    for (let i = 0; i < dataSort.length; i++) {
        if (dataSort[i] == sort) {
            if (direction == 'asc') {
                $('#dataTable1 td:nth-child(' + (i + 1) + ')').css({
                    'background': 'black',
                    'color': 'white'
                })
                $('table thead th:nth-child(' + (i + 1) + ')').append('<i class ="fa fa-sort-down ml-1"></i>')
            }
            if (direction == 'desc') {
                $('#dataTable1 td:nth-child(' + (i + 1) + ')').css({
                    'background': '#770000',
                    'color': 'white'
                })
                $('table thead th:nth-child(' + (i + 1) + ')').append('<i class ="fa fa-sort-up ml-1"></i>')
            }
        }
    }
</script>