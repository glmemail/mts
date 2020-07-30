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
            $fluentd_id=!empty($view_json[7])?$view_json[7]:0;
            if ($fluentd_id==$k) {
                echo "<option value='".$k."'' selected>".$v."</option>";
            } else {
                echo "<option value='".$k."''>".$v."</option>";
            }
        }
        ?>
    </select>
    <!-- <input id="aaa" type="button" onclick="combaction()" value="aaa"/> -->
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="division1" name="division" type="radio" value="1"  checked="checked"  onchange="radochange()"/>一周</label>
    &nbsp;&nbsp;&nbsp;&nbsp;</label><label><input id="division2" name="division" type="radio" value="0" onchange="radochange()"/>24小时</label>
</div>
<div class="row">
<div class="col-md-4">
    <canvas id="myChart2" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas>
    <canvas id="myChart2_24" style="width: 322px; display: block; height: 160px;display: none" width="322" height="160" class="chartjs-render-monitor"></canvas>
</div>
<div class="col-md-4">
    <canvas id="myChart1" style="width: 322px; display: block; height: 160px;" width="322" height="160"></canvas>
    <canvas id="myChart1_24" style="width: 322px; display: block; height: 160px;display: none" width="322" height="160"></canvas>
</div>
<div class="col-md-4" id="msg">
    <!-- <canvas id="myChart3" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas> -->

    <div class="col-md-5"><div class="small-box bg-aqua">
        <div class="inner" id="message">
            <h3>{{$view_json[6]['msg_all_count']}}</h3>
            <p>Message</p>
        </div>
        <div class="icon">
            <i class="fa fa-comment"></i>
        </div>
        <a href="/index.php/admin/message" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="mail">
            <h3>{{ $view_json[6]['mail_all_count'] }}</h3>
            <p>Mail</p>
        </div>
        <div class="icon">
            <i class="fa fa-envelope"></i>
        </div>
        <a href="/index.php/admin/mail/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="phone">
            <h3>{{$view_json[6]['phone_all_count']}}</h3>

            <p>Phone</p>
        </div>
        <div class="icon">
            <i class="fa fa-phone"></i>
        </div>
        <a href="/index.php/admin/phone/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="wechat">
            <h3>{{$view_json[6]['wechat_all_count']}}</h3>
            <p>Wechat</p>
        </div>
        <div class="icon">
            <i class="fa fa-weixin"></i>
        </div>
        <a href="/index.php/admin/wechat/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>

</div>
<div class="col-md-4" id="msg_24" style="display: none">
    <!-- <canvas id="myChart3" style="width: 322px; display: block; height: 160px;" width="322" height="160" class="chartjs-render-monitor"></canvas> -->

    <div class="col-md-5"><div class="small-box bg-aqua">
        <div class="inner" id="message_24">
            <h3>{{$view_json[8]['msg_all_count_24']}}</h3>
            <p>Message</p>
        </div>
        <div class="icon">
            <i class="fa fa-comment"></i>
        </div>
        <a href="/index.php/admin/message" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="mail_24">
            <h3>{{$view_json[8]['mail_all_count_24']}}</h3>
            <p>Mail</p>
        </div>
        <div class="icon">
            <i class="fa fa-envelope"></i>
        </div>
        <a href="/index.php/admin/mail/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="phone_24">
            <h3>{{$view_json[8]['phone_all_count_24']}}</h3>

            <p>Phone</p>
        </div>
        <div class="icon">
            <i class="fa fa-phone"></i>
        </div>
        <a href="/index.php/admin/phone/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>
    <div class="col-md-5"><div class="small-box bg-green">
        <div class="inner" id="wechat_24">
            <h3>{{$view_json[8]['wechat_all_count_24']}}</h3>

            <p>Wechat</p>
        </div>
        <div class="icon">
            <i class="fa fa-weixin"></i>
        </div>
        <a href="/index.php/admin/wechat/{{ !empty($view_json[7])?$view_json[7]:0 }}" class="small-box-footer">
            更多&nbsp;
            <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div></div>

</div>
</div>
<div>
<?php
    $i=0;
    foreach ($view_json[3] as $k => $v) {
        echo "<div id='myChart1_".($i+1)."' class='box-body table-responsive no-padding' style='display: none'>";
        echo "<h2>".$view_json[3][$i]."</h2>";
        echo "<table class='table table-hover grid-table' style='border-collapse: collapse;'>";
        echo "<th class='column-id' style='width: 10%'>MSG_ID</th>";
        echo "<th class='column-id' style='width: 40%'>内容</th>";
        echo "<th class='column-id' style='width: 10%'>时间</th>";
        echo "<th class='column-id' style='width: 10%'>方式";
        echo "<select name='type_sel' onchange='combtype(this)'>";
        echo "<option value='0'>全部</option>";
        echo "<option value='1'>mail</option>";
        echo "<option value='2'>phone</option>";
        echo "<option value='3'>wechat</option>";
        echo "</select>";
        echo "</th>";
        echo "<th class='column-id' style='width: 10%'>Mail</th>";
        echo "<th class='column-id' style='width: 10%'>Phone</th>";
        echo "<th class='column-id' style='width: 10%'>Wechat</th>";
        foreach (!empty($view_json[4][$view_json[3][$i]])?$view_json[4][$view_json[3][$i]]:[] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['message_id']."</td>";
            echo "<td>".$v['message']."</td>";
            echo "<td>".date('yy-m-d H:i:s',strtotime($v['actiontime']))."</td>";
            echo "<td>";
            echo !empty($v['phone_type'])?"Phone<font size='5'>■</font><br/>":"Phone<font size='5'>□</font><br/>";
            echo !empty($v['phone_type'])?"<input name='phone' type='hidden' value='1'>":"<input name='phone' type='hidden' value='0'>";
            echo !empty($v['mail_type'])?"Mail<font size='5'>■</font><br/>":"Mail<font size='5'>□</font><br/>";
            echo !empty($v['mail_type'])?"<input name='mail' type='hidden' value='1'>":"<input name='mail' type='hidden' value='0'>";
            echo !empty($v['wechat_type'])?"Wechat<font size='5'>■</font><br/>":"Wechat<font size='5'>□</font><br/>";
            echo !empty($v['wechat_type'])?"<input name='wechat' type='hidden' value='1'>":"<input name='wechat' type='hidden' value='0'>";
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


    $i=0;
    foreach ($view_json[3] as $k => $v) {
        echo "<div id='myChart2_".($i+1)."' class='box-body table-responsive no-padding' style='display: none'>";
        echo "<h2>".$view_json[3][$i]."</h2>";
        echo "<table class='table table-hover grid-table' style='border-collapse: collapse;'>";
        echo "<th class='column-id' style='width: 10%'>MSG_ID</th>";
        echo "<th class='column-id' style='width: 50%'>内容</th>";
        echo "<th class='column-id' style='width: 40%'>时间</th>";
        foreach (!empty($view_json[4][$view_json[3][$i]])?$view_json[4][$view_json[3][$i]]:[] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['message_id']."</td>";
            echo "<td>".$v['message']."</td>";
            echo "<td>".date('yy-m-d H:i:s',strtotime($v['actiontime']))."</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        $i++;
    }

    $i=0;
    $j=23;
    foreach ($view_json[10] as $k => $v) {
        echo "<div id='myChart1_24_".($i+1)."' class='box-body table-responsive no-padding' style='display: none'>";
        echo "<h2>".$view_json[2][$j]."</h2>";
        echo "<table class='table table-hover grid-table' style='border-collapse: collapse;'>";
        echo "<th class='column-id' style='width: 10%'>MSG_ID</th>";
        echo "<th class='column-id' style='width: 40%'>内容</th>";
        echo "<th class='column-id' style='width: 10%'>时间</th>";
        echo "<th class='column-id' style='width: 10%'>方式";
        echo "<select name='type_sel' onchange='combtype(this)'>";
        echo "<option value='0'>全部</option>";
        echo "<option value='1'>mail</option>";
        echo "<option value='2'>phone</option>";
        echo "<option value='3'>wechat</option>";
        echo "</select>";
        echo "</th>";
        echo "<th class='column-id' style='width: 10%'>Mail</th>";
        echo "<th class='column-id' style='width: 10%'>Phone</th>";
        echo "<th class='column-id' style='width: 10%'>Wechat</th>";
        foreach (!empty($view_json[9][$view_json[10][$j]])?$view_json[9][$view_json[10][$j]]:[] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['message_id']."</td>";
            echo "<td>".$v['message']."</td>";
            echo "<td>".date('yy-m-d H:i:s',strtotime($v['actiontime']))."</td>";
            echo "<td>";
            echo !empty($v['phone_type'])?"Phone<font size='5'>■</font><br/>":"Phone<font size='5'>□</font><br/>";
            echo !empty($v['phone_type'])?"<input name='phone' type='hidden' value='1'>":"<input name='phone' type='hidden' value='0'>";
            echo !empty($v['mail_type'])?"Mail<font size='5'>■</font><br/>":"Mail<font size='5'>□</font><br/>";
            echo !empty($v['mail_type'])?"<input name='mail' type='hidden' value='1'>":"<input name='mail' type='hidden' value='0'>";
            echo !empty($v['wechat_type'])?"Wechat<font size='5'>■</font><br/>":"Wechat<font size='5'>□</font><br/>";
            echo !empty($v['wechat_type'])?"<input name='wechat' type='hidden' value='1'>":"<input name='wechat' type='hidden' value='0'>";
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
        $j--;
    }

    $i=0;
    $j=23;
    foreach ($view_json[10] as $k => $v) {
        echo "<div id='myChart2_24_".($i+1)."' class='box-body table-responsive no-padding' style='display: none'>";
        echo "<h2>".$view_json[2][$j]."</h2>";
        echo "<table class='table table-hover grid-table' style='border-collapse: collapse;'>";
        echo "<th class='column-id' style='width: 10%'>MSG_ID</th>";
        echo "<th class='column-id' style='width: 40%'>内容</th>";
        echo "<th class='column-id' style='width: 10%'>时间</th>";
        foreach (!empty($view_json[9][$view_json[10][$j]])?$view_json[9][$view_json[10][$j]]:[] as $k => $v) {
            echo "<tr>";
            echo "<td>".$v['message_id']."</td>";
            echo "<td>".$v['message']."</td>";
            echo "<td>".date('yy-m-d H:i:s',strtotime($v['actiontime']))."</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
        $i++;
        $j--;
    }
?>
</div>
<script>
$(function () {

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
            },
            events : ["mousemove", "mouseout", "click"],
            onClick : function (event, bars){

                var activeElement = bars[0];   //当前被选中的元素
                var product = activeElement._model.label;
                // var datasetIndex = activeElement._datasetIndex;
                // alert(product);
                console.log(bars);
                var count3 = {{ count($view_json[3]) }};
                for (var x1=0;x1<count3;x1++)
                {
                    document.getElementById("myChart2_"+(x1+1)).style.display= "none";
                    if (activeElement._index==x1) {
                        document.getElementById("myChart1_"+(x1+1)).style.display= "block";
                    } else {
                        document.getElementById("myChart1_"+(x1+1)).style.display= "none";
                    }
                }
                var count3_24 = {{ count($view_json[10]) }};
                for (var x1=0;x1<count3_24;x1++)
                {
                    document.getElementById("myChart2_24_"+(x1+1)).style.display= "none";
                    document.getElementById("myChart1_24_"+(x1+1)).style.display= "none";
                }
            }
        }
    });



    var ctx2 = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        echo "'".$v."',";
                    }
                    ?>],
            datasets: [{
                label: '一周内告警信息',
                data: [
                    <?php
                    foreach ($view_json[3] as $k => $v) {
                        if (!empty($view_json[4][$v])) {
                            echo count($view_json[4][$v]).",";
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
                        echo "'rgba(0, 0, 255, 0.2)',";
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

                var count3 = {{ count($view_json[3]) }};
                for (var x1=0;x1<count3;x1++)
                {
                    document.getElementById("myChart1_"+(x1+1)).style.display= "none";
                    if (activeElement._index==x1) {
                        document.getElementById("myChart2_"+(x1+1)).style.display= "block";
                    } else {
                        document.getElementById("myChart2_"+(x1+1)).style.display= "none";
                    }
                }
                var count3_24 = {{ count($view_json[10]) }};
                for (var x1=0;x1<count3_24;x1++)
                {
                    document.getElementById("myChart2_24_"+(x1+1)).style.display= "none";
                    document.getElementById("myChart1_24_"+(x1+1)).style.display= "none";
                }
            }
        }
    });


    var ctx_24 = document.getElementById("myChart1_24").getContext('2d');
    var myChart_24 = new Chart(ctx_24, {
        type: 'bar',
        data: {
            labels: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'".$view_json[10][$x]."',";
                    }
                    ?>],
            datasets: [{
                label: 'Mail',
                data: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        if (!empty($view_json[11][$view_json[10][$x]]['mail_count'])) {
                            echo $view_json[11][$view_json[10][$x]]['mail_count'].",";
                        }else{
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'rgba(255, 99, 132, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
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
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        if (!empty($view_json[11][$view_json[10][$x]]['phone_count'])) {
                            echo $view_json[11][$view_json[10][$x]]['phone_count'].",";
                        }else{
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'rgba(54, 162, 235, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
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
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        if (!empty($view_json[11][$view_json[10][$x]]['wechat_count'])) {
                            echo $view_json[11][$view_json[10][$x]]['wechat_count'].",";
                        }else{
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                    ],
                backgroundColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'rgba(255, 206, 86, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
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
            },
            events : ["mousemove", "mouseout", "click"],
            onClick : function (event, bars){
                var activeElement = bars[0];   //当前被选中的元素
                console.log(bars);
                // var product = activeElement._model.label;

                var count3 = {{ count($view_json[3]) }};
                for (var x1=0;x1<count3;x1++)
                {
                    document.getElementById("myChart1_"+(x1+1)).style.display= "none";
                    document.getElementById("myChart2_"+(x1+1)).style.display= "none";
                }
                var count3_24 = {{ count($view_json[10]) }};
                for (var x1=0;x1<count3_24;x1++)
                {
                    document.getElementById("myChart2_24_"+(x1+1)).style.display= "none";
                    if (activeElement._index==x1) {
                        document.getElementById("myChart1_24_"+(x1+1)).style.display= "block";
                    } else {
                        document.getElementById("myChart1_24_"+(x1+1)).style.display= "none";
                    }
                }
            }
        }
    });

    var ctx2_24 = document.getElementById("myChart2_24").getContext('2d');
    var myChart2_24 = new Chart(ctx2_24, {
        type: 'bar',
        data: {
            labels: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'".$view_json[10][$x]."',";
                    }
                    ?>],
            datasets: [{
                label: '24小时内告警信息',
                data: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        if (!empty($view_json[9][$view_json[10][$x]])) {
                            echo count($view_json[9][$view_json[10][$x]]).",";
                        }else{
                            $c=0;
                            echo $c.",";
                        }
                    }
                    ?>
                ],
                backgroundColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'rgba(0, 0, 255, 0.2)',";
                    }
                    ?>
                ],
                borderColor: [
                    <?php
                    for ($x=(count($view_json[10])-1); $x>=0; $x--) {
                        echo "'rgba(54, 162, 235, 1)',";
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
            },
            events : ["mousemove", "mouseout", "click"],
            onClick : function (event, bars){
                var activeElement = bars[0];   //当前被选中的元素
                var product = activeElement._model.label;
                // console.log(activeElement);
                // alert(activeElement._index);
                var count3 = {{ count($view_json[3]) }};
                for (var x1=0;x1<count3;x1++)
                {
                    document.getElementById("myChart1_"+(x1+1)).style.display= "none";
                    document.getElementById("myChart2_"+(x1+1)).style.display= "none";
                }
                var count3_24 = {{ count($view_json[10]) }};
                for (var x1=0;x1<count3_24;x1++)
                {
                    document.getElementById("myChart1_24_"+(x1+1)).style.display= "none";
                    if (activeElement._index==x1) {
                        document.getElementById("myChart2_24_"+(x1+1)).style.display= "block";
                    } else {
                        document.getElementById("myChart2_24_"+(x1+1)).style.display= "none";
                    }
                }
            }
        }
    });





});

function combaction(){
    //获取被选中的option标签
    var vs = document.getElementById("fluentd_id").value

    if (vs=="0"){
        location.href = '/index.php/admin/chartjs';
    } else {
        location.href = '/index.php/admin/chartjs/' + vs;
    }

}


function combtype(obj){
    //获取被选中的option标签
    var index = obj.value;
    var type_sel= document.getElementsByName("type_sel");
    for (var i = 0; i < type_sel.length; i++) {
        type_sel[i].options[index].selected=true;
    }
    var mail= document.getElementsByName("mail");
    var phone= document.getElementsByName("phone");
    var wechat= document.getElementsByName("wechat");
    // alert(mail);
    for (var i = 0; i < mail.length; i++) {
        var o = mail[i].parentElement.parentElement;
        // alert(o);
        o.style.display= "";
    }
    if (index==1) {
        for (var i = 0; i < mail.length; i++) {
            if (mail[i].value=="0") {
                var o = mail[i].parentElement.parentElement;
                o.style.display= "none"
            }
        }
    }
    if (index==2) {
        for (var i = 0; i < phone.length; i++) {
            if (phone[i].value=="0") {
                var o = phone[i].parentElement.parentElement;
                o.style.display= "none"
            }
        }

    }
    if (index==3) {
        for (var i = 0; i < wechat.length; i++) {
            if (wechat[i].value=="0") {
                var o = wechat[i].parentElement.parentElement;
                o.style.display= "none"
            }
        }

    }

}
function radochange(){

    var count3 = {{ count($view_json[3]) }};
    for (var x1=0;x1<count3;x1++)
    {
        document.getElementById("myChart1_"+(x1+1)).style.display= "none";
        document.getElementById("myChart2_"+(x1+1)).style.display= "none";
    }
    var count3_24 = {{ count($view_json[10]) }};
    for (var x1=0;x1<count3_24;x1++)
    {
        document.getElementById("myChart2_24_"+(x1+1)).style.display= "none";
        document.getElementById("myChart1_24_"+(x1+1)).style.display= "none";
    }
    var division = $("input[name='division']:checked").val();
    if (division=='1') {
        document.getElementById("myChart1").style.display= "";
        document.getElementById("myChart2").style.display= "";
        document.getElementById("msg").style.display= "";
        document.getElementById("myChart1_24").style.display= "none";
        document.getElementById("myChart2_24").style.display= "none";
        document.getElementById("msg_24").style.display= "none";
    }
    if (division=='0') {
        document.getElementById("myChart1").style.display= "none";
        document.getElementById("myChart2").style.display= "none";
        document.getElementById("msg").style.display= "none";
        document.getElementById("myChart1_24").style.display= "";
        document.getElementById("myChart2_24").style.display= "";
        document.getElementById("msg_24").style.display= "";
    }
}
</script>
