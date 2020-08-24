<div class="col-md-4">
    <canvas id="myChart1" style="width: 322px; display: block; height: 160px;" width="322" height="160"></canvas>
<!--     <input type="button" name="chartjs" value="chartjs" onclick="chartjsclick()"> -->
</div>
<script>
    // function chartjsclick() {
$(function () {
        // alert("aaaaa");
        var ctx = document.getElementById("myChart1").getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'".$v."',";
                    }
                    ?>
                    ],
            datasets: [{
                label: 'Mail',
                data: [
                    <?php
                    $x=count($view_json[3]);
                    foreach ($view_json[3] as $k => $v) {
                        if (!empty($view_json[5][$v]['mail_count'])) {
                             echo $view_json[5][$v]['mail_count'].",";
                        } else {
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(255, 99, 132, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(255,99,132,1)',";
                    }
                    ?>
                ],
                borderWidth: 1
            },
            {
                label: 'Phone',
                data: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        if (!empty($view_json[5][$v]['phone_count'])) {
                             echo $view_json[5][$v]['phone_count'].",";
                        } else {
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(54, 162, 235, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(54, 162, 235, 1)',";
                    }
                    ?>
                ],
                borderWidth: 1
            },
            {
                label: 'Wechat',
                data: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        if (!empty($view_json[5][$v]['wechat_count'])) {
                             echo $view_json[5][$v]['wechat_count'].",";
                        } else {
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(255, 206, 86, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'rgba(255, 206, 86, 1)',";
                    }
                    ?>
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
</script>
