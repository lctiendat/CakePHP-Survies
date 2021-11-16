<?= $this->element('admin/header') ?>
<style>

</style>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <p> <?= $this->Flash->render() ?></p>
            <form action="" method="post">
                <div class="card p-3">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary float-right backtoPrePage" onclick="backPrePage()">Back <i class="fa fa-undo-alt"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="">Category</label>
                        <textarea rows="1" name="category" class="form-control" oninput="auto_height(this)"><?php if (isset($_SESSION['nameError'])) { ?><?= $_SESSION['nameError']  ?><?php } ?><?php
                                                                                                                                                                                                    unset($_SESSION['nameError']) ?></textarea>

                    </div>
                </div>
                <div class="card p-3 mt-3 card0">
                    <div class="form-group p-3">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" name="question[0]" class="form-control" value="Question has no title"></br>
                            </div>
                            <div class="col-md-3">
                                <select name="type_select[0]" id="selectId0" class="form-control" onchange="changeType(0)">
                                    <option value="1">Radio</option>
                                    <option value="2">Checkbox</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <i style="font-size: 20px;" class="fa fa-trash mt-2" id="deleteSurvey0" onclick="deleteSurvey(this.id)"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <input type="radio" class="form-control type">
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="answer[0][]" class="form-control" value="Option">
                            </div>
                            <div class="col-md-1">
                                <i style="font-size:30px;font-weight: normal;" class="fa fa-times mt-1" onclick="deleteAnswer(this.id)" id="answer0"></i>
                            </div>
                        </div>
                        <div id="moreAnswer0"></div>
                        <div class="row mt-2">
                            <div class="col-md-1">
                                <input type="radio" class="form-control type">
                            </div>
                            <div class="col-md-10 mt-2">
                                <span class="text-secondary" id="moreOptions" onclick="addAnswer(0)"> More option
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="moreSurvey"></div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <button id="addSurvey" type="button" class="btn btn-primary">Add Survey</button>
                    </div>
                    <div class="col-md-6">
                        <button class="float-right btn btn-primary">Add Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?= $this->element('admin/footer') ?>
<script>
    const url_domain_name = '<?= URL_DOMAIN_NAME  ?>'
    $('.backtoPrePage').click(() => {
        if (document.referrer == '') {
            window.location.href = url_domain_name + '/admin/categories'
        } else {}
    })
</script>
<script>
    function auto_height(elem) {
        /* javascript */
        elem.style.height = "1px";
        elem.style.height = (elem.scrollHeight) + "px";
    }
    $('.type').attr('disabled', true)
    $('input').focus((e) => {
        $(e.target).css('cssText', 'border-bottom: 2px solid rgb(114, 72, 185) !important')
    })
    $('input').blur((e) => {
        $(e.target).css('cssText', 'border-bottom: 1px solid gray !important')
    })
    $('input[name="answer"]').blur((e) => {
        $(e.target).css('cssText', 'border: 0 !important')
    })
    let i = 1;

    function deleteAnswer(i) {
        $('#' + i).closest('div.row').remove()
    }
    $('#addSurvey').click((e) => {
        $('#moreSurvey').append(`<div class="card card${i} p-3 mt-3">
                        <div class="form-group p-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="question[${i}]" class="form-control" value="Question has no title"></br>
                                </div>
                                <div class="col-md-3">
                                    <select name="type_select[${i}]" id="selectId${i}" class="form-control" onchange="changeType(${i})">
                                        <option value="1">Radio</option>
                                        <option value="2">Checkbox</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size: 20px;" class="fa fa-trash mt-2" id="deleteSurvey${i}" onclick="deleteSurvey(this.id)"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <input type="radio" class="form-control type" disabled>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="answer[${i}][]" class="form-control" value="Option">
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size:30px;font-weight: normal;" class="fa fa-times mt-1"
                                        onclick="deleteAnswer(this.id)" id="answer${i}"></i>
                                </div>
                            </div>
                            <div id="moreAnswer${i}"></div>
                            <div class="row mt-2">
                                <div class="col-md-1">
                                    <input type="radio" class="form-control type" disabled>
                                </div>
                                <div class="col-md-10 mt-3">
                                    <span class="text-secondary" id="moreOptions" onclick="addAnswer(${i})"> More option </span>
                                </div>
                            </div>
                        </div>
                    </div>`)
        i++
    })

    function deleteSurvey(i) {
        $('#' + i).closest('div.card').remove()
    }

    function addAnswer(id) {
        let selectOption = $('#selectId' + id).val()
        if (selectOption == 1) {
            $('#moreAnswer' + id).append(` <div class="row mt-2">
                                <div class="col-md-1">
                                    <input type="radio" class="form-control type" disabled>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="answer[${id}][]" class="form-control" value="Option">
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size:30px;font-weight: normal;" class="fa fa-times mt-1" id="answer${i}" onclick="deleteAnswer(this.id)"></i>
                                </div>
                        </div>`)
        } else {
            $('#moreAnswer' + id).append(` <div class="row mt-2">
                                <div class="col-md-1">
                                    <input type="checkbox" class="form-control type" disabled>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="answer[${id}][]" class="form-control" value="Option">
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size:30px;font-weight: normal;" class="fa fa-times mt-1" id="answer${i}" onclick="deleteAnswer(this.id)"></i>
                                </div>
                        </div>`)
        }
        i++
        j++
    }

    function changeType(i) {
        let answer = $('.card' + i + ' input.type')
        let selectOption = $('#selectId' + i).val()
        if (selectOption == 1) {
            answer.prop("type", "radio");
        } else {
            answer.prop("type", "checkbox");
        }
    }
    console.log()
</script>