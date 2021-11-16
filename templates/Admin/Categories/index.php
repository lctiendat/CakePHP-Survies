<?= $this->element('admin/header') ?>
<?php if (isset($countResult)) {
    $countResultSort = $countResult;
} ?>
<div class="container-fluid">
    <div class="card shadow mb-4 p-3">
        <p> <?= $this->Flash->render() ?></p>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Category</h6>
            <a href="/admin/categories/add"> <button class="btn btn-primary mb-3 float-right">Add</button> </a>
        </div>
        <?php if ($getQualityCategories == 0) { ?>
            <center>
                <h3 class="p-3">Not have Category</h3>
            </center>
        <?php } else { ?>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="" method="get">
                        <input type="text" name="key" value="<?php if (isset($_SESSION['valueSearch'])) { ?><?= trim($_SESSION['valueSearch'])  ?><?php }
                                                                                                                                                unset($_SESSION['valueSearch']) ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <table class="table table-bordered text-center mt-3" data-sort='asc' id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id', 'ID'); ?></th>
                                <th name="name"><?= $this->Paginator->sort('name'); ?></th>
                                <th><?= $this->Paginator->sort('created'); ?></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable1">
                            <?php
                            if (isset($result)) {
                                if (count($result) > 0) {
                                    if (isset($_GET['page'])) {
                                        $countResult1 = $countResult - (($_GET['page'] - 1) . '0');
                                    }
                                    foreach ($result as  $item) {
                            ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php if (isset($_GET['direction']) && $_GET['direction'] == 'desc' && $_GET['sort'] == 'id') {
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
                                            <td><?= $item->name ?></td>
                                            <td><?= $item->created ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6"><a data-placement="top" title="Edit" data-toggle="tooltip" data-placement="top" href="/admin/categories/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>
                                                    <div class="col-md-6">
                                                        <form method="post" action="/admin/categories/delete/<?= $item->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <button type="submit" class="bg-transparent border-0"> <i data-placement="top" title="Remove" data-toggle="tooltip" data-placement="top" class="fa fa-trash text-primary"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                }
                            } else { ?>
                                <?php
                                foreach ($categories as $category) {
                                ?>
                                    <tr class="row1">
                                        <td><?= $pageStart++ ?></td>
                                        <td><?= $category->name ?></td>
                                        <td><?= $category->created ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6"><a data-placement="top" title="Edit" data-toggle="tooltip" data-placement="top" href="/admin/categories/edit/<?= $category->id ?>"><i class="fa fa-pen"></i></a></div>
                                                <div class="col-md-6">
                                                    <form method="post" action="/admin/categories/delete/<?= $category->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
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
                    <?php if (isset($result) && !isset($_GET['sort'])) {
                    ?>
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
                    <?php if (isset($categories) && !isset($result)) {
                        if ($getQualityCategories > PAGE_COUNT_ADMIN) { ?>
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
    let dataSort = ['id', 'name', 'created']
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