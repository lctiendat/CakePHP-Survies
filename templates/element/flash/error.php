<?php

/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="col-md-12 mx-auto">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" onclick="this.classList.add('hidden')">&times;</button>
        <?= $message ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(() => {
        setTimeout(() => {
            $('.alert').hide();
        }, 5000);
    })
</script>