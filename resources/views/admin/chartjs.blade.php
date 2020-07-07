<style> 
    .all{
        display:-moz-box; /* Firefox */
        display:-webkit-box; /* Safari and Chrome */
        display:box;
        width:600px;
        height: 600px;
        border:1px solid black;
    }

    .item{
        -moz-box-flex:1.0; /* Firefox */
        /*-webkit-box-flex:1.0; /* Safari and Chrome */*/
        box-flex:1.0;

   text-overflow: ellipsis;
    display: -webkit-box; /*//将元素设为盒子伸缩模型显示*/
    -webkit-box-orient: vertical; /*//伸缩方向设为垂直方向*/
    -webkit-line-clamp: 4;  /*//超出3行隐藏，并显示省略号 */
    width: 130px;
    background: #00F7DE;
    line-height:20px;max-height:80px;
    height: 80px;
    border: 1px solid #000000;
    }

</style>
<div>
    <select id="fluentd_id" onchange="combaction()">
        <option value="0" >请选择</option>
        <?php
        foreach ($view_json[1] as $k => $v) {
            // $select=
            if (!empty($view_json[7])?$view_json[7]:0==$k) {
                echo "<option value='".$k."'' selected>".$v."</option>";
            } else {
                echo "<option value='".$k."''>".$v."</option>";
            }
        }
        ?>
    </select>
    <!-- <input id="aaa" type="button" onclick="combaction()" value="aaa"/> -->
</div>
<div class="row">
<div class="col-md-4">
    <canvas id="myChart1" style="width: 322px; display: block; height: 160px;" width="322" height="160"></canvas>
</div>
<div class="col-md-4">
    <canvas id="myChart2" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas>
</div>
<div class="col-md-4">
    <!-- <canvas id="myChart3" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas> -->

        <?php
        // use Encore\Admin\Widgets\Box;
        // $content='Counts : ';
        // $box = new Box('Message', $content.count($view_json[4]));
        // $box->removable();
        // $box->collapsable();
        // $box->style('info');
        // $box->solid();
        // // $box->scrollable();
        // echo $box;
        // $box = new Box('Mail', $content.count($view_json[0]['MAIL']));
        // $box->removable();
        // $box->collapsable();
        // $box->style('info');
        // $box->solid();
        // // $box->scrollable();
        // echo $box;
        // $box = new Box('Phone', $content.count($view_json[0]['PHONE']));
        // $box->removable();
        // $box->collapsable();
        // $box->style('info');
        // $box->solid();
        // // $box->scrollable();
        // echo $box;
        // $box = new Box('Wechat', $content.count($view_json[0]['WECHAT']));
        // $box->removable();
        // $box->collapsable();
        // $box->style('info');
        // $box->solid();
        // // $box->scrollable();
        // echo $box;
        ?>
    <div class="col-md-5"><div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{$view_json[6]['msg_all_count']}}</h3>
            <p>Message</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="/admin/message" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner">
            <h3>{{count(!empty($view_json[0]['MAIL'])?$view_json[0]['MAIL']:[])}}</h3>
            <p>Mail</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="/admin/mail" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner">
            <h3>{{count(!empty($view_json[0]['PHONE'])?$view_json[0]['PHONE']:[])}}</h3>

            <p>Phone</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="/admin/message" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner">
            <h3>{{count(!empty($view_json[0]['WECHAT'])?$view_json[0]['WECHAT']:[])}}</h3>

            <p>Wechat</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="/admin/wechat" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>

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
        foreach (!empty($view_json[0]['MAIL'])?$view_json[0]['MAIL']:[] as $k1 => $v1) {
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
        foreach (!empty($view_json[0]['PHONE'])?$view_json[0]['PHONE']:[] as $k1 => $v1) {
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
        foreach (!empty($view_json[0]['WECHAT'])?$view_json[0]['WECHAT']:[] as $k1 => $v1) {
            echo "<tr>";
            echo "<td>".$v1['wechat_to']."</td>";
            echo "<td>".$v1['actiontime']."</td>";
            echo "<td>".$v1['sysid']." ".$v1['svrid']." ".$v1['subsysid']." ".$v1['cmpid']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<?php
    $i=0;
    foreach ($view_json[3] as $k => $v) {
        echo "<div id='index".($i+1)."' class='box-body table-responsive no-padding' style='display: none'>";
        echo "<h2>".$view_json[3][$i]."</h2>";
        echo "<table class='table table-hover grid-table'>";
        echo "<th class='column-id' style='width: 50%'>内容</th>";
        echo "<th class='column-id' style='width: 10%'>时间</th>";
        echo "<th class='column-id' style='width: 10%'>方式</th>";
        echo "<th class='column-id' style='width: 10%'>Mail</th>";
        echo "<th class='column-id' style='width: 10%'>Phone</th>";
        echo "<th class='column-id' style='width: 10%'>Wechat</th>";
        foreach (!empty($view_json[4][$view_json[3][$i]])?$view_json[4][$view_json[3][$i]]:[] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['message']."</td>";
            echo "<td>".date('yy-m-d H:i:s',strtotime($v['actiontime']))."</td>";
            echo "<td>";
            echo !empty($v['phone_type'])?"Phone<font size='5'>■</font><br/>":"Phone<font size='5'>□</font><br/>";
            echo !empty($v['mail_type'])?"Mail<font size='5'>■</font><br/>":"Mail<font size='5'>□</font><br/>";
            echo !empty($v['wechat_type'])?"Wechat<font size='5'>■</font><br/>":"Wechat<font size='5'>□</font><br/>";
            echo "</td>";
            echo "<td>";

            for ($x=0; $x<count($v['msg_action']); $x++) {
                if (!empty($v['msg_action'][$x]['mail_to'])) {
                    echo $v['msg_action'][$x]['mail_to']."<br/>";
                }
            }
            echo "</td>";
            echo "<td>";
            $x1=0;
            for ($x=0; $x<count($v['msg_action']); $x++) {
                if (!empty($v['msg_action'][$x]['phone_number'])) {
                    echo "<font size='3'>".($x1+1)."</font>：".$v['msg_action'][$x]['phone_number'];
                    $phone_dtmf=!empty($v['msg_action'][$x]['phone_dtmf'])?$v['msg_action'][$x]['phone_dtmf']:"";
                    if ($phone_dtmf=="2") {
                    // echo !empty($v['msg_action'][$x]['phone_dtmf'])?"<font size='4'>▲</font>":"";
                        echo "<font size='2'> 当番处理</font>";
                    } else if ($phone_dtmf=="0") {
                        echo "<font size='2'> 接通未处理</font>";
                    } else {
                        echo "<font size='2'> 未接通</font>";
                    }
                    echo "<br/>";
                    $x1++;
                }
            }
            echo "</td>";
            echo "<td>";
            for ($x=0; $x<count($v['msg_action']); $x++) {
                if (!empty($v['msg_action'][$x]['wechat_to'])) {
                    echo $v['msg_action'][$x]['wechat_to']."<br/>";
                }
            }
            echo "<td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        $i++;
    }
?>
<script>
$(function () {
    var ctx = document.getElementById("myChart1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["{{$view_json[3][0]}}", "{{$view_json[3][1]}}", "{{$view_json[3][2]}}", "{{$view_json[3][3]}}", "{{$view_json[3][4]}}", "{{$view_json[3][5]}}","{{$view_json[3][6]}}"],
            datasets: [{
                label: 'Mail',
                data: [
                    {{ !empty($view_json[5][$view_json[3][0]]['mail_count'])?$view_json[5][$view_json[3][0]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][1]]['mail_count'])?$view_json[5][$view_json[3][1]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][2]]['mail_count'])?$view_json[5][$view_json[3][2]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][3]]['mail_count'])?$view_json[5][$view_json[3][3]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][4]]['mail_count'])?$view_json[5][$view_json[3][4]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][5]]['mail_count'])?$view_json[5][$view_json[3][5]]['mail_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][6]]['mail_count'])?$view_json[5][$view_json[3][6]]['mail_count']:0 }}
                    ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
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
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 1
            },
            {
                label: 'Phone',
                data: [
                    {{ !empty($view_json[5][$view_json[3][0]]['phone_count'])?$view_json[5][$view_json[3][0]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][1]]['phone_count'])?$view_json[5][$view_json[3][1]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][2]]['phone_count'])?$view_json[5][$view_json[3][2]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][3]]['phone_count'])?$view_json[5][$view_json[3][3]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][4]]['phone_count'])?$view_json[5][$view_json[3][4]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][5]]['phone_count'])?$view_json[5][$view_json[3][5]]['phone_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][6]]['phone_count'])?$view_json[5][$view_json[3][6]]['phone_count']:0 }}
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
            },
            {
                label: 'Wechat',
                data: [
                    {{ !empty($view_json[5][$view_json[3][0]]['wechat_count'])?$view_json[5][$view_json[3][0]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][1]]['wechat_count'])?$view_json[5][$view_json[3][1]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][2]]['wechat_count'])?$view_json[5][$view_json[3][2]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][3]]['wechat_count'])?$view_json[5][$view_json[3][3]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][4]]['wechat_count'])?$view_json[5][$view_json[3][4]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][5]]['wechat_count'])?$view_json[5][$view_json[3][5]]['wechat_count']:0 }},
                    {{ !empty($view_json[5][$view_json[3][6]]['wechat_count'])?$view_json[5][$view_json[3][6]]['wechat_count']:0 }}
                    ],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
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
            },
            events : ["mousemove", "mouseout", "click"],
            onClick : function (event, bars){
                var activeElement = bars[0];   //当前被选中的元素
                var product = activeElement._model.label;
                // console.log(bars);
                document.getElementById("mail").style.display= "none";
                document.getElementById("phone").style.display= "none";
                document.getElementById("wechat").style.display= "none";
                var count3 = {{ count($view_json[3]) }};
                for (var x1=0;x1<count3;x1++)
                {
                    if (activeElement._index==x1) {
                        document.getElementById("index"+(x1+1)).style.display= "block";
                    } else {
                        document.getElementById("index"+(x1+1)).style.display= "none";
                    }
                }
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
                {{ count(!empty($view_json[4][$view_json[3][0]])?$view_json[4][$view_json[3][0]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][1]])?$view_json[4][$view_json[3][1]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][2]])?$view_json[4][$view_json[3][2]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][3]])?$view_json[4][$view_json[3][3]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][4]])?$view_json[4][$view_json[3][4]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][5]])?$view_json[4][$view_json[3][5]]:[]) }},
                {{ count(!empty($view_json[4][$view_json[3][6]])?$view_json[4][$view_json[3][6]]:[]) }}
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
                // console.log(activeElement);
                // alert(activeElement._index);
                document.getElementById("mail").style.display= "none";
                document.getElementById("phone").style.display= "none";
                document.getElementById("wechat").style.display= "none";
                if (activeElement._index==0) {
                    document.getElementById("index1").style.display= "block";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "none";
                }
                if (activeElement._index==1) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "block";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "none";
                }
                if (activeElement._index==2) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "block";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "none";
                }
                if (activeElement._index==3) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "block";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "none";
                }
                if (activeElement._index==4) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "block";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "none";
                }
                if (activeElement._index==5) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "block";
                    document.getElementById("index7").style.display= "none";
                }
                 if (activeElement._index==6) {
                    document.getElementById("index1").style.display= "none";
                    document.getElementById("index2").style.display= "none";
                    document.getElementById("index3").style.display= "none";
                    document.getElementById("index4").style.display= "none";
                    document.getElementById("index5").style.display= "none";
                    document.getElementById("index6").style.display= "none";
                    document.getElementById("index7").style.display= "block";
                }
            }
        }
    });




});

function combaction(){
    //获取被选中的option标签
    var vs = document.getElementById("fluentd_id").value

    // alert(vs);
    // window.location.href = 'admin/chartjs/combaction?id=1';
    if (vs=="0"){
        location.href = '/admin/chartjs';
    } else {
        location.href = '/admin/chartjs/' + vs;
    }

}
</script>
