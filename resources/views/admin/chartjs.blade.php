
<div>
    <select>
        <option value="0">请选择</option>
        <?php
        // $arr=array($fluentd_sel);
        foreach ($fluentd_sel as $v) {
            echo "<option value='".$v."''>".$v."</option>";
        }
    ?>
    </select>
</div>
<div class="row">
<div class="col-md-4">
    <canvas id="myChart1" style="width: 322px; display: block; height: 160px;" width="322" height="160"></canvas>
</div>
<div class="col-md-4">
    <canvas id="myChart3" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas>
</div>
</div>
<script>
$(function () {
    var ctx = document.getElementById("myChart1").getContext('2d');
//     var myChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: ["Mail", "Phone", "Wechat", "SMS", "SSM", "Redmine"],
//             datasets: [{
//                 label: '# of Votes',
// 　　　　　　　　　　//数据类型 折线图
//                 type: "line",
//                 // data: [12, 19, 3, 5, 2, 3],
//                 data: [{{ $action_count[0] }}, {{ $action_count[1] }}, {{ $action_count[2] }}, 0, 0, 0],
//                 backgroundColor:'rgba(54, 162, 235, 0.1)',
//                 borderColor:'rgba(255,99,132,1)',
//                 borderWidth: 1
//             },{
//                 label: ["Mail", "Phone", "Wechat", "SMS", "SSM", "Redmine"],
// 　　　　　　　　　　//数据类型 柱状图
//                 type: "bar",
//                 data: [{{ $action_count[0] }}, {{ $action_count[1] }}, {{ $action_count[2] }}, 0, 0, 0],
//                 backgroundColor: [
//                     'rgba(255, 99, 132, 0.2)',
//                     'rgba(54, 162, 235, 0.2)',
//                     'rgba(255, 206, 86, 0.2)',
//                     'rgba(75, 192, 192, 0.2)',
//                     'rgba(153, 102, 255, 0.2)',
//                     'rgba(255, 159, 64, 0.2)'
//                 ],
//                 borderColor: [
//                     'red',
//                     'rgba(54, 162, 235, 1)',
//                     'rgba(255, 206, 86, 1)',
//                     'rgba(75, 192, 192, 1)',
//                     'rgba(153, 102, 255, 1)',
//                     'rgba(255, 159, 64, 1)'
//                 ],
//                 borderWidth: 1
//             }]
//         },

//         options: {
// 　　　　　　　　//显示数值
//             "animation": {
//                 "duration": 1,
//                 "onComplete": function() {
//                     var chartInstance = this.chart,
//                     ctx = chartInstance.ctx;

//                     ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
// 　　　　　　　　　　　　//设置字体颜色
//                     ctx.fillStyle = "black";
//                     ctx.textAlign = 'center';
//                     ctx.textBaseline = 'bottom';

//                     this.data.datasets.forEach(function(dataset, i) {
//                     var meta = chartInstance.controller.getDatasetMeta(i);
//                     meta.data.forEach(function(bar, index) {
//                         var data = dataset.data[index];
//                         ctx.fillText(data, bar._model.x, bar._model.y - 5);
//                     });
//                     });
//                 }
//             },
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero:true
//                     }
//                 }]
//             }
//         }
//     });


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Mail", "Phone", "Wechat", "SMS", "SSM", "Redmine"],
            datasets: [{
                label: '# of Votes',
                data: [{{ $action_count[0] }}, {{ $action_count[1] }}, {{ $action_count[2] }}, 0, 0, 0],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    var ctx3 = document.getElementById("myChart3").getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ["Mail", "Phone", "Wechat", "SMS", "SSM", "Redmine"],
            datasets: [{
                label: '# of Votes',
                data: [{{ $action_count[0] }}, {{ $action_count[1] }}, {{ $action_count[2] }}, 0, 0, 0],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
});

    // function randomScalingFactor() {
    //     return Math.floor(Math.random() * 100)
    // }
</script>
