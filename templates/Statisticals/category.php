<?php
$this->disableAutoLayout();

echo $this->element('admin/header');
$categoryName = '';
foreach ($category as $item) {
    $categoryName = $item->name;
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow p-5 mb-4 text-center">
        <?php if ($result > 0) { ?>
            <canvas id="myChart" style="width:100%;max-width:50%; display: block;
    margin: 0 auto;"></canvas>
        <?php } else { ?>
            <div class="text-center">
                <h5>Danh mục này chưa có câu hỏi</h5>
            </div>
        <?php } ?>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>
<script>
    var xValues = ["Survies"];
    var yValues = ['<?= $result ?>'];
    var barColors = ["red", "green","blue","orange","brown"];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Statistics of the number of surveis by " + '<?= $categoryName ?>' + " "
            }
        }
    });
</script>