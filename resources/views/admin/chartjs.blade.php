
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
            },
            events : ["mousemove", "mouseout", "click"],
            onClick : function (event, bars){
                             var activeElement = bars[0];   //当前被选中的元素
                             var product = activeElement._model.label;
                             console.log(activeElement);
                             alert(activeElement);
                             //load_version_chart(product);
                         }
        }
    });
});
</script>
