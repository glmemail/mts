
<div>
    <select>
        <option value="0" onchange="#">请选择</option>
        <?php
        // $arr=array($view_json[1]);
        // var_dump($view_json[3]);
        foreach ($view_json[1] as $v) {
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
    <canvas id="myChart2" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas>
</div>
<div class="col-md-4">
    <canvas id="myChart3" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas>
</div>
</div>
<div id="mail" class="box-body table-responsive no-padding" style="display: none">
    <h2>Mail</h2>
    <table class="table table-hover grid-table">
        <th class="column-id" style="width: 33%">邮箱</th>
        <th class="column-id" style="width: 33%">时间</th>
        <th class="column-id" style="width: 33%">FluentdID</th>
        <?php
        // var_dump($actoninfo_json);
        // var_dump($view_json[0]);
        foreach ($view_json[0]['MAIL'] as $k1 => $v1) {
            echo "<tr>";
            echo "<td>".$v1['mail_to']."</td>";
            echo "<td>".$v1['actiontime']."</td>";
            echo "<td>".$v1['sysid']." ".$v1['svrid']." ".$v1['subsysid']." ".$v1['cmpid']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div id="phone" class="box-body table-responsive no-padding" style="display: none">
    <h2>Phone</h2>
    <table class="table table-hover grid-table">
        <th class="column-id" style="width: 33%">电话号码</th>
        <th class="column-id" style="width: 33%">时间</th>
        <th class="column-id" style="width: 33%">FluentdID</th>
        <?php
        foreach ($view_json[0]['PHONE'] as $k1 => $v1) {
            echo "<tr>";
            echo "<td>".$v1['phone_number']."</td>";
            echo "<td>".$v1['actiontime']."</td>";
            echo "<td>".$v1['sysid']." ".$v1['svrid']." ".$v1['subsysid']." ".$v1['cmpid']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div id="wechat" class="box-body table-responsive no-padding" style="display: none">
    <h2>Wechat</h2>
    <table class="table table-hover grid-table">
        <th class="column-id" style="width: 33%">微信号码</th>
        <th class="column-id" style="width: 33%">时间</th>
        <th class="column-id" style="width: 33%">FluentdID</th>
        <?php
        foreach ($view_json[0]['WECHAT'] as $k1 => $v1) {
            echo "<tr>";
            echo "<td>".$v1['wechat_to']."</td>";
            echo "<td>".$v1['actiontime']."</td>";
            echo "<td>".$v1['sysid']." ".$v1['svrid']." ".$v1['subsysid']." ".$v1['cmpid']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div id="index1" class="box-body table-responsive no-padding" style="display: none">
    <h2>Wechat</h2>
    <table class="table table-hover grid-table">
        <th class="column-id" style="width: 33%">微信号码</th>
        <th class="column-id" style="width: 33%">时间</th>
        <th class="column-id" style="width: 33%">FluentdID</th>
        <?php
        foreach ($view_json[2][$view_json[3][0]] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['wechat_to']."</td>";
            echo "<td>".$v['actiontime']."</td>";
            echo "<td>".$v['sysid']." ".$v['svrid']." ".$v['subsysid']." ".$v['cmpid']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<script>
$(function () {
    var ctx = document.getElementById("myChart1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["2020/01", "2020/02", "2020/03", "2020/04", "2020/05", "2020/06"],
            datasets: [{
                label: 'Mail',
                data: [1, 5, 9,16, 8, 4],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 1
            },
            {
                label: 'Phone',
                data: [3, 6, 4, 3, 6, 4],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            },
            {
                label: 'Wechat',
                data: [15, 7, 5, 15, 7, 5],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)'
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



    var ctx2 = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ["{{$view_json[3][0]}}", "{{$view_json[3][1]}}", "{{$view_json[3][2]}}", "{{$view_json[3][3]}}", "{{$view_json[3][4]}}", "{{$view_json[3][5]}}","{{$view_json[3][6]}}"],
            datasets: [{
                label: '一周内告警信息',
                data: [
                {{ count(!empty($view_json[2][$view_json[3][0]])?$view_json[2][$view_json[3][0]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][1]])?$view_json[2][$view_json[3][1]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][2]])?$view_json[2][$view_json[3][2]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][3]])?$view_json[2][$view_json[3][3]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][4]])?$view_json[2][$view_json[3][4]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][5]])?$view_json[2][$view_json[3][5]]:[]) }},
                {{ count(!empty($view_json[2][$view_json[3][6]])?$view_json[2][$view_json[3][6]]:[]) }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
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
                             // alert(activeElement._index);
                             // if (activeElement._index==0) {
                             //    document.getElementById("mail").style.display= "block";
                             //    document.getElementById("phone").style.display= "none";
                             //    document.getElementById("wechat").style.display= "none";
                             // } else if (activeElement._index==1) {
                             //    document.getElementById("mail").style.display= "none";
                             //    document.getElementById("phone").style.display= "block";
                             //    document.getElementById("wechat").style.display= "none";
                             // } else if (activeElement._index==2) {
                             //    document.getElementById("mail").style.display= "none";
                             //    document.getElementById("phone").style.display= "none";
                             //    document.getElementById("wechat").style.display= "block";
                             // }
                             //load_version_chart(product);
                         }
        }
    });




    var ctx3 = document.getElementById("myChart3").getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ["Mail", "Phone", "Wechat"],
            datasets: [{
                label: '# of Votes',
                data: [{{ count($view_json[0]["MAIL"]) }}, {{ count($view_json[0]["PHONE"]) }}, {{ count($view_json[0]["WECHAT"]) }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'

                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
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
                             // console.log(activeElement);
                             // alert(activeElement._index);
                             if (activeElement._index==0) {
                                document.getElementById("mail").style.display= "block";
                                document.getElementById("phone").style.display= "none";
                                document.getElementById("wechat").style.display= "none";
                             } else if (activeElement._index==1) {
                                document.getElementById("mail").style.display= "none";
                                document.getElementById("phone").style.display= "block";
                                document.getElementById("wechat").style.display= "none";
                             } else if (activeElement._index==2) {
                                document.getElementById("mail").style.display= "none";
                                document.getElementById("phone").style.display= "none";
                                document.getElementById("wechat").style.display= "block";
                             }
                             //load_version_chart(product);
                         }
        }
    });
});
</script>
