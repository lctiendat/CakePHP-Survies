<?= $this->element('admin/header') ?>
<?php
if (isset($countResult)) {
    $countResultSort = $countResult;
} ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List User</h6>
        </div>
        <?php if ($getQualityUser == 0) { ?>
            <center>
                <h3 class="p-3">Have not user</h3>
            </center>
        <?php } else { ?>
            <div class="card-body">
                <form action="" method="get">
                    <input type="text" name="key" value="<?php if (isset($_SESSION['valueSearch'])) { ?><?= trim($_SESSION['valueSearch'])  ?><?php }
                                                                                                                                            unset($_SESSION['valueSearch']) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <div class="table-responsive mt-4">
                    <?= $this->Flash->render() ?>
                    <table class="table table-bordered text-center" data-sort='asc' id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id', 'ID'); ?></th>
                                <th><?= $this->Paginator->sort('email', 'Email'); ?></th>
                                <th><?= $this->Paginator->sort('phone', 'Phone'); ?></th>
                                <th>Status</th>
                                <th>Role</th>
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
                                    foreach ($result as $key => $item) {
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
                                            <td><?= $item->email ?></td>
                                            <td><?= $item->phone ?></td>
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
                                                    <div class="col-md-12"><a href="/admin/users/edit/<?= $item->id ?>"><i class="fa fa-pen"></i></a></div>

                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                }
                            } else { ?>
                                <?php
                                foreach ($users as $user) {
                                ?>
                                    <tr>
                                        <td><?= $pageStart++ ?></td>
                                        <td><?= $user->email ?></td>
                                        <td><?= $user->phone ?></td>
                                        <td><span class="badge badge-success p-2"><?= $user->str_status ?></span>
                                        </td>
                                        <td><span class="badge badge-danger p-2"><?= $user->str_role ?></span>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12"><a href="/admin/users/edit/<?= $user->id ?>"><i data-placement="top" title="Edit" data-toggle="tooltip" data-placement="top" class="fa fa-pen"></i></a></div>

                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <?php if (isset($result)  && !isset($_GET['sort'])) { ?>
                        <button class="btn btn-primary float-left back">Back <i data-placement="top" title="Edit" data-toggle="tooltip" data-placement="top" class="fa fa-undo-alt"></i></button>
                    <?php
                    } ?>
                    <?php if (isset($result)) {
                        $countResult = $countResultSort;
                        if ($result != [] && $countResult > 10) { ?>
                            <ul class="pagination float-right">
                                <?= $this->Paginator->prev("Prev") ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next("Next") ?>
                            </ul>
                    <?php }
                    }
                    ?>
                    <?php if (isset($users) && !isset($result)) {
                        if ($getQualityUser > 10) { ?>
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
    let sort = url_current.searchParams.get('sort')
    let direction = url_current.searchParams.get('direction')
    let dataSort = ["id", 'email', "phone"]
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