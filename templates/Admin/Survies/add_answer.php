<?php
$id_Survey = '';
echo $this->element('admin/header') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card p-5">
                <h5>Add Answer</h5>
                <form action="" method="post">
                    <input type="hidden" name="prePage" value="<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                            <?= $_SERVER['HTTP_REFERER']; ?><?php } ?>">
                    <div class="form-group">
                        <label for="">Survey</label>
                        <?php foreach ($survey as $item) {
                            $id_Survey = $item->id;
                        ?>
                            <input type="text" name="" id="" value="<?= $item->question ?>" class="form-control" readonly>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="">Answer</label>
                        <input type="text" class="form-control inputArr" name="name[]">

                        <?php if (isset($errors['name'])) { ?>
                            <p class="error"><?= reset($errors['name']); ?></p>
                        <?php } ?>
                    </div>
                    <div id="more"></div>
                    <span class="fa fa-plus mt-1" id="add"></span><span id="del" class="fa fa-trash ml-3 mt-1"></span>

                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-primary float-right" <?php if (isset($result)) {
                                                                                    ?> style="display: none;" <?php } ?> onclick="window.location.href='/admin/survies'">Back <i class="fa fa-undo-alt"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card p-5">
                <p> <?= $this->Flash->render() ?></p>
                <?php if ($countAnswer == 0) { ?>
                    <center>
                        <h5>Survey have not Answer</h5>
                    </center>
                <?php  } else { ?>
                    <table class="table table-bordered text-center mt-3" data-sort='asc' id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Answer</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($answers as $key => $answer) { ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $answer->name ?></td>
                                    <td><?= $answer->created ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6"><a href="/admin/answers/edit/<?= $answer->id ?>"><i class="fa fa-pen"></i></a></div>
                                            <div class="col-md-6">
                                                <form method="post" action="/admin/survies/<?= $id_Survey ?>/delete/<?= $answer->id ?>" onSubmit="if(!confirm('Bạn có chắc muốn xóa không ?')){return false;}">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <button type="submit" class="bg-transparent border-0"> <i class="fa fa-trash text-primary"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->element('admin/footer') ?>
<script>
    var answers = [];
    $(document).ready(() => {
        $('#add').click(() => {
            $('#more').append('<div class="form-group"> <input type="text" class="form-control inputArr" name="name[]"></div>')
        })
        $('#del').click((e) => {
            e.preventDefault()
            if ($('#more').find('input').length < 1) {
                alert('Không thể xóa')
            } else {
                if (confirm('Bạn có chắc muốn xóa không ?')) {
                    $('.inputArr').last().remove();
                }
            }
        })

    })
</script>