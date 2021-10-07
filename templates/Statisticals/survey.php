<?php
$this->disableAutoLayout();

echo $this->element('admin/header');
$surveyName = '';
$count = [];
$answers = [];
$char2 = [];
foreach ($countEachAnswerBySurvey as $item) {
    array_push($count, $item->count);
}
foreach ($countEachAnswerBySurvey as $item) {
    array_push($answers, [
        'value' => $item->count,
        'name' => $item->name
    ]);
}
foreach ($countEachAnswerBySurvey as $item) {
    array_push($char2, [
        'name' => $item->name,
        'type' => 'bar',
        'label' => 'labelOption',
        'emphasis' => [
            'focus' => 'series'
        ],
        'data' => [$item->count]
    ]);
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow p-5 mb-4 text-center">
        <?php if (count($count) > 0) { ?>
            <button type="button" class="btn btn-outline-primary btn-rounded float-right mb-3" name="btnChange" style="width: 300px;" data-mdb-ripple-color="dark">
                Thay đổi giao diện thống kê
            </button>
            <?php foreach ($survey as $item) { ?>
                <h6>Thống kê dữ liệu kết quả khảo sát của <?= $item->question ?> </h6>
            <?php } ?>
            <div id="main1" style="width: 600px;height:400px;margin:0 auto;display:none"></div>
            <div id="main" style="width: 800px;height:600px;margin:0 auto;display:block"></div>
        <?php } else { ?>
            <div class="text-center">
                <h5>Câu hỏi này chưa có ai khảo sát</h5>
            </div>
        <?php } ?>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php echo $this->element('admin/footer') ?>
<script>
    var chartDom = document.getElementById('main');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b}: {c} ({d}%)'
        },

        series: [{
                name: 'Access From',
                type: 'pie',
                selectedMode: 'single',
                radius: [0, '30%'],
                label: {
                    position: 'inner',
                    fontSize: 14
                },
                labelLine: {
                    show: false
                }
            },
            {
                name: 'Access From',
                type: 'pie',
                radius: ['45%', '60%'],
                labelLine: {
                    length: 30
                },
                label: {
                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                    backgroundColor: '#F6F8FC',
                    borderColor: '#8C8D8E',
                    borderWidth: 1,
                    borderRadius: 4,
                    rich: {
                        a: {
                            color: '#6E7079',
                            lineHeight: 22,
                            align: 'center'
                        },
                        hr: {
                            borderColor: '#8C8D8E',
                            width: '100%',
                            borderWidth: 1,
                            height: 0
                        },
                        b: {
                            color: '#4C5058',
                            fontSize: 14,
                            fontWeight: 'bold',
                            lineHeight: 33
                        },
                        per: {
                            color: '#fff',
                            backgroundColor: '#4C5058',
                            padding: [3, 4],
                            borderRadius: 4
                        }
                    }
                },
                data: <?php echo json_encode($answers) ?>
            }
        ]
    };

    option && myChart.setOption(option);
    var app = {};

    var chartDom1 = document.getElementById('main1');
    var myChart1 = echarts.init(chartDom1);
    var option1;

    const posList = [
        'left',
        'right',
        'top',
        'bottom',
        'inside',
        'insideTop',
        'insideLeft',
        'insideRight',
        'insideBottom',
        'insideTopLeft',
        'insideTopRight',
        'insideBottomLeft',
        'insideBottomRight'
    ];
    app.configParameters = {
        rotate: {
            min: -90,
            max: 90
        },
        align: {
            options1: {
                left: 'left',
                center: 'center',
                right: 'right'
            }
        },
        verticalAlign: {
            options1: {
                top: 'top',
                middle: 'middle',
                bottom: 'bottom'
            }
        },
        position: {
            options1: posList.reduce(function(map, pos) {
                map[pos] = pos;
                return map;
            }, {})
        },
        distance: {
            min: 0,
            max: 100
        }
    };
    app.config = {
        rotate: 90,
        align: 'left',
        verticalAlign: 'middle',
        position: 'insideBottom',
        distance: 15,
        onChange: function() {
            const labelOption = {
                rotate: app.config.rotate,
                align: app.config.align,
                verticalAlign: app.config.verticalAlign,
                position: app.config.position,
                distance: app.config.distance
            };
            myChart1.setOption({
                series: [{
                        label: labelOption
                    },
                    {
                        label: labelOption
                    },
                    {
                        label: labelOption
                    },
                    {
                        label: labelOption
                    }
                ]
            });
        }
    };
    const labelOption = {
        show: true,
        position: app.config.position,
        distance: app.config.distance,
        align: app.config.align,
        verticalAlign: app.config.verticalAlign,
        rotate: app.config.rotate,
        formatter: '{c}  {name|{a}}',
        fontSize: 16,
        rich: {
            name: {}
        }
    };
    option1 = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },

        toolbox: {
            show: true,
            orient: 'vertical',
            left: 'right',
            top: 'center',
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: true,
                    readOnly: false
                },
                magicType: {
                    show: true,
                    type: ['line', 'bar', 'stack']
                },
                restore: {
                    show: true
                },
                saveAsImage: {
                    show: true
                }
            }
        },
        xAxis: [{
            type: 'category',
            axisTick: {
                show: false
            }
        }],
        yAxis: [{
            type: 'value'
        }],
        series: <?php echo json_encode($char2) ?>
    };

    option1 && myChart1.setOption(option1);

    $(document).ready(() => {
        $('button[name="btnChange"]').click(() => {
            $('#main').toggle();
            $('#main1').toggle();

        })
    })
</script>