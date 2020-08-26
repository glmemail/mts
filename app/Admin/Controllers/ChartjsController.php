<?php

namespace App\Admin\Controllers;

use App\Models\Fluentd;
use App\Models\Message;
use App\Models\Action_info;
use App\Models\Aliivr;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use DB;
use DateTime;

class ChartjsController extends Controller
{
    public function index(Content $content)
    {
        $grid = new Grid(new Action_info());
        // $g = $grid->model()->groupBy('actiontype')->get()->pluck('count', 'actiontype')->toArray();
        // $g = $grid->model()->get()->groupBy('actiontype')->toArray();
        $user = Auth::guard('admin')->user();
        // $fluentd = Fluentd::select(array('keyname'))
        //     ->get()
        //     ->groupBy('keyname');
        $fluentd = Fluentd::select(array('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id'))
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('keyid');
        // $svrid = "";
        $fluentd_json = json_decode($fluentd,true);
        $s = [];
        $sysid="";
        $svrid="";
        $subsysid="";
        $cmpid="";
        foreach ($fluentd_json as $k => $v) {
            $s[$k] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
            if ($sysid=="") {
                $sysid="'".$v[0]['sysid']."'";
            } else {
                $sysid=$sysid.","."'".$v[0]['sysid']."'";
            }
            if ($svrid=="") {
                $svrid="'".$v[0]['svrid']."'";
            } else {
                $svrid=$svrid.","."'".$v[0]['svrid']."'";
            }
            if ($subsysid=="") {
                $subsysid="'".$v[0]['subsysid']."'";
            } else {
                $subsysid=$subsysid.","."'".$v[0]['subsysid']."'";
            }
            if ($cmpid=="") {
                $cmpid="'".$v[0]['cmpid']."'";
            } else {
                $cmpid=$cmpid.","."'".$v[0]['cmpid']."'";
            }
        }
        $fluentd_sel = $s;
        $showtime=date("Y-m-d",strtotime("-6 day"));
        $showtime24=date("Y-m-d H:i",strtotime("-1 day"));
        $weeks=[];
        for ($x=6; $x>=0; $x--) {
            $day_str="-".$x." day";
            $weeks[]=date("Y-m-d",strtotime($day_str));
        }
        $hour=[];
        $ymdhour=[];
        for ($x=0; $x<24; $x++) {
            $hour_str="-".$x." hour";
            $hour[]=date("H:00",strtotime($hour_str));
            $ymdhour[]=date("Y-m-d H:00",strtotime($hour_str));
        }
        $msg_arr=[];
        $msg_count=[];
        $mail_all_count=0;
        $phone_all_count=0;
        $wechat_all_count=0;

        $msg_arr_24=[];
        $msg_count_24=[];
        $mail_all_count_24=0;
        $phone_all_count_24=0;
        $wechat_all_count_24=0;

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." message_view mv ";
        $sql = $sql." where ";
        $sql = $sql." mv.actiontime > '".$showtime."' ";
        $sql = $sql." and mv.user_id ='".$user['username']."' ";
        $message_all = DB::select($sql);
        $msg_all_count = count($message_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." message_view mv ";
        $sql = $sql." where ";
        $sql = $sql." mv.actiontime > '".$showtime24."' ";
        $sql = $sql." and mv.user_id ='".$user['username']."' ";
        $message_all_24 = DB::select($sql);
        $msg_all_count_24 = count($message_all_24);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." mail_info mi ";
        $sql = $sql." where ";
        $sql = $sql." mi.actiontime > '".$showtime."' ";
        $sql = $sql." and mi.sys_id in ( ".$sysid." )";
        $sql = $sql." and mi.svr_id in ( ".$svrid." )";
        $sql = $sql." and mi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and mi.cmp_id in ( ".$cmpid." )";
        $mail_all = DB::select($sql);
        $mail_all_count = count($mail_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." mail_info mi ";
        $sql = $sql." where ";
        $sql = $sql." mi.actiontime > '".$showtime24."' ";
        $sql = $sql." and mi.sys_id in ( ".$sysid." )";
        $sql = $sql." and mi.svr_id in ( ".$svrid." )";
        $sql = $sql." and mi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and mi.cmp_id in ( ".$cmpid." )";
        $mail_all_24 = DB::select($sql);
        $mail_all_count_24 = count($mail_all_24);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." phone_info pi ";
        $sql = $sql." where ";
        $sql = $sql." pi.actiontime > '".$showtime."' ";
        $sql = $sql." and pi.sys_id in ( ".$sysid." )";
        $sql = $sql." and pi.svr_id in ( ".$svrid." )";
        $sql = $sql." and pi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and pi.cmp_id in ( ".$cmpid." )";
        $phone_all = DB::select($sql);
        $phone_all_count = count($phone_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." phone_info pi ";
        $sql = $sql." where ";
        $sql = $sql." pi.actiontime > '".$showtime24."' ";
        $sql = $sql." and pi.sys_id in ( ".$sysid." )";
        $sql = $sql." and pi.svr_id in ( ".$svrid." )";
        $sql = $sql." and pi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and pi.cmp_id in ( ".$cmpid." )";
        $phone_all_24 = DB::select($sql);
        $phone_all_count_24 = count($phone_all_24);


        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." wechat_info wi ";
        $sql = $sql." where ";
        $sql = $sql." wi.actiontime > '".$showtime."' ";
        $sql = $sql." and wi.sys_id in ( ".$sysid." )";
        $sql = $sql." and wi.svr_id in ( ".$svrid." )";
        $sql = $sql." and wi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and wi.cmp_id in ( ".$cmpid." )";
        $wechat_all = DB::select($sql);
        $wechat_all_count = count($wechat_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." wechat_info wi ";
        $sql = $sql." where ";
        $sql = $sql." wi.actiontime > '".$showtime24."' ";
        $sql = $sql." and wi.sys_id in ( ".$sysid." )";
        $sql = $sql." and wi.svr_id in ( ".$svrid." )";
        $sql = $sql." and wi.sub_sys_id in ( ".$subsysid." )";
        $sql = $sql." and wi.cmp_id in ( ".$cmpid." )";
        $wechat_all_24 = DB::select($sql);
        $wechat_all_count_24 = count($wechat_all_24);

        for ($x=0; $x<$msg_all_count; $x++) {
            $date = new DateTime($message_all[$x]->actiontime);
            $ymd = $date->format('Y-m-d');
            $sql = $this->selectActioninfo_sql($message_all[$x]->id);
            $msg = DB::select($sql);
            // var_dump($msg);
            $m=[];
            $msg_action=[];
            $mail_type="";
            $wechat_type="";
            $phone_type="";
            for ($y=0; $y<count($msg); $y++) {
                if ($msg[$y]->ai_actiontype=="MAIL") {
                    $mail_type="MAIL";
                    if (!empty($msg_count[$ymd]['mail_count'])) {
                        $msg_count[$ymd]['mail_count']++;
                    } else {
                        $msg_count[$ymd]['mail_count']=1;
                    }
                    // $mail_all_count++;
                }
                if ($msg[$y]->ai_actiontype=="PHONE") {
                    $phone_type="PHONE";
                    if (!empty($msg_count[$ymd]['phone_count'])) {
                        $msg_count[$ymd]['phone_count']++;
                    } else {
                        $msg_count[$ymd]['phone_count']=1;
                    }
                    // $phone_all_count++;
                }
                if ($msg[$y]->ai_actiontype=="WECHAT") {
                    $wechat_type="WECHAT";
                    if (!empty($msg_count[$ymd]['wechat_count'])) {
                        $msg_count[$ymd]['wechat_count']++;
                    } else {
                        $msg_count[$ymd]['wechat_count']=1;
                    }
                    // $wechat_all_count++;
                }
                $t=[];
                $t['phone_number']=$msg[$y]->pi_phone_number;
                $t['phone_dtmf']=$msg[$y]->pi_dtmf;
                $t['phone_status_code']=$msg[$y]->pi_status_code;
                $t['mail_to']=$msg[$y]->mi_mail_to;
                $t['wechat_to']=$msg[$y]->wi_wechat_to;

                $msg_action[]=$t;
            }
            $m['message_id']=$message_all[$x]->id;
            $m['message']=$message_all[$x]->message;
            $m['actiontime']=$message_all[$x]->actiontime;
            $m['mail_type']=$mail_type;
            $m['phone_type']=$phone_type;
            $m['wechat_type']=$wechat_type;
            $m['msg_action']=$msg_action;
            $msg_arr[$ymd][]=$m;
        }
        for ($x=0; $x<$msg_all_count_24; $x++) {
            $date = new DateTime($message_all_24[$x]->actiontime);
            $ymdh = $date->format("H:00");
            $sql = $this->selectActioninfo_sql($message_all_24[$x]->id);
            $msg = DB::select($sql);
            $m=[];
            $msg_action=[];
            $mail_type="";
            $wechat_type="";
            $phone_type="";
            // $mail_count=0;
            // $phone_count=0;
            // $wechat_count=0;
            for ($y=0; $y<count($msg); $y++) {
                if ($msg[$y]->ai_actiontype=="MAIL") {
                    $mail_type="MAIL";
                    if (!empty($msg_count_24[$ymdh]['mail_count'])) {
                        $msg_count_24[$ymdh]['mail_count']++;
                    } else {
                        $msg_count_24[$ymdh]['mail_count']=1;
                    }
                    // $mail_all_count_24++;
                }
                if ($msg[$y]->ai_actiontype=="PHONE") {
                    $phone_type="PHONE";
                    if (!empty($msg_count[$ymdh]['phone_count'])) {
                        $msg_count_24[$ymdh]['phone_count']++;
                    } else {
                        $msg_count_24[$ymdh]['phone_count']=1;
                    }
                    // $phone_all_count_24++;
                }
                if ($msg[$y]->ai_actiontype=="WECHAT") {
                    $wechat_type="WECHAT";
                    if (!empty($msg_count_24[$ymdh]['wechat_count'])) {
                        $msg_count_24[$ymdh]['wechat_count']++;
                    } else {
                        $msg_count_24[$ymdh]['wechat_count']=1;
                    }
                    // $wechat_all_count_24++;
                }
                $t=[];
                $t['phone_number']=$msg[$y]->pi_phone_number;
                $t['phone_dtmf']=$msg[$y]->pi_dtmf;
                $t['phone_status_code']=$msg[$y]->pi_status_code;
                $t['mail_to']=$msg[$y]->mi_mail_to;
                $t['wechat_to']=$msg[$y]->wi_wechat_to;
                $msg_action[]=$t;
            }
            $m['message_id']=$message_all_24[$x]->id;
            $m['message']=$message_all_24[$x]->message;
            $m['actiontime']=$message_all_24[$x]->actiontime;
            $m['mail_type']=$mail_type;
            $m['phone_type']=$phone_type;
            $m['wechat_type']=$wechat_type;
            $m['msg_action']=$msg_action;
            $msg_arr_24[$ymdh][]=$m;
        }
        $msg_all_counts=[];
        $msg_all_counts['msg_all_count']=$msg_all_count;
        $msg_all_counts['mail_all_count']=$mail_all_count;
        $msg_all_counts['phone_all_count']=$phone_all_count;
        $msg_all_counts['wechat_all_count']=$wechat_all_count;
        $msg_all_counts_24=[];
        $msg_all_counts_24['msg_all_count_24']=$msg_all_count_24;
        $msg_all_counts_24['mail_all_count_24']=$mail_all_count_24;
        $msg_all_counts_24['phone_all_count_24']=$phone_all_count_24;
        $msg_all_counts_24['wechat_all_count_24']=$wechat_all_count_24;
        $view_json=[];
        $view_json[]=[];                        // index=0
        $view_json[]=$fluentd_sel;              // index=1
        $view_json[]=$ymdhour;                  // index=2
        $view_json[]=$weeks;                    // index=3 一周内日期List
        $view_json[]=$msg_arr;                  // index=4
        $view_json[]=$msg_count;                // index=5
        $view_json[]=$msg_all_counts;           // index=6 一周内msg_counts
        $view_json[]=0;                         // index=7 24小时内msg_counts
        $view_json[]=$msg_all_counts_24;        // index=8 一周内msg_counts
        $view_json[]=$msg_arr_24;               // index=9
        $view_json[]=$hour;                     // index=10
        $view_json[]=$msg_count_24;             // index=11

        $view_json[]=$mail_all;                 // index=12
        $view_json[]=$mail_all_24;              // index=13
        $view_json[]=$phone_all;                // index=14
        $view_json[]=$phone_all_24;             // index=15
        $view_json[]=$wechat_all;               // index=16
        $view_json[]=$wechat_all_24;            // index=17
        // var_dump($view_json[6]['msg_all_count']);
        // var_dump($view_json[8]['msg_all_count_24']);
        // var_dump($view_json[0]);
        // var_dump($view_json[1]);
        // var_dump($view_json[2]);
        // var_dump($view_json[3]);
        // var_dump($view_json[4]);
        // var_dump($view_json[5]);
        // var_dump($view_json[6]);
        // var_dump($view_json[7]);
        // var_dump($view_json[8]);
        // var_dump($view_json[9]);
        // var_dump($view_json[10]);
        return $content
            ->header('信息查询')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }

    public function combaction(Request $request)
    {

        $fluentd_id =$request['fluentd_id'];
        $user = Auth::guard('admin')->user();
        $fluentd = Fluentd::select(array('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id'))
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('keyid');
        $fluentd_json = json_decode($fluentd,true);
        $s = [];
        foreach ($fluentd_json as $k => $v) {
            $s[$k] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
        }
        $fluentd_sel = $s;
        $showtime=date("Y-m-d",strtotime("-6 day"));
        $showtime24=date("Y-m-d H:i",strtotime("-1 day"));
        $weeks=[];
        for ($x=6; $x>=0; $x--) {
            $day_str="-".$x." day";
            $weeks[]=date("Y-m-d",strtotime($day_str));
        }

        $hour=[];
        $ymdhour=[];
        for ($x=0; $x<24; $x++) {
            $hour_str="-".$x." hour";
            $hour[]=date("H:00",strtotime($hour_str));
            $ymdhour[]=date("Y-m-d H:00",strtotime($hour_str));
        }
        $msg_arr=[];
        $msg_count=[];
        $mail_all_count=0;
        $phone_all_count=0;
        $wechat_all_count=0;

        $msg_arr_24=[];
        $msg_count_24=[];
        $mail_all_count_24=0;
        $phone_all_count_24=0;
        $wechat_all_count_24=0;

        $sql="select * from fluentd "." where fluentd.keyid = ".$fluentd_id;
        $sel_fluentd = DB::select($sql);
        // var_dump($sel_fluentd[0]->sysid);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." m.id,m.message,m.actiontime,m.sysid,m.svrid,m.subsysid,m.cmpid ";
        $sql = $sql." from ";
        $sql = $sql." message m ";
        $sql = $sql." join action_info ai on ";
        $sql = $sql." ai.message_id = m.id ";
        $sql = $sql." where ";
        $sql = $sql." m.actiontime > '".$showtime."' ";
        $sql = $sql." and m.sysid = '".$sel_fluentd[0]->sysid."' ";
        $sql = $sql." and m.svrid = '".$sel_fluentd[0]->svrid."' ";
        $sql = $sql." and m.subsysid = '".$sel_fluentd[0]->subsysid."' ";
        $sql = $sql." and m.cmpid = '".$sel_fluentd[0]->cmpid."' ";
        $sql = $sql." group by ";
        $sql = $sql." m.id ";
        $message_all = DB::select($sql);
        $msg_all_count = count($message_all);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." mail_info mi ";
        $sql = $sql." where ";
        $sql = $sql." mi.actiontime > '".$showtime."' ";
        $sql = $sql." and mi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and mi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and mi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and mi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $mail_all = DB::select($sql);
        $mail_all_count = count($mail_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." mail_info mi ";
        $sql = $sql." where ";
        $sql = $sql." mi.actiontime > '".$showtime24."' ";
        $sql = $sql." and mi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and mi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and mi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and mi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $mail_all_24 = DB::select($sql);
        $mail_all_count_24 = count($mail_all_24);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." phone_info pi ";
        $sql = $sql." where ";
        $sql = $sql." pi.actiontime > '".$showtime."' ";
        $sql = $sql." and pi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and pi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and pi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and pi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $phone_all = DB::select($sql);
        $phone_all_count = count($phone_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." phone_info pi ";
        $sql = $sql." where ";
        $sql = $sql." pi.actiontime > '".$showtime24."' ";
        $sql = $sql." and pi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and pi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and pi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and pi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $phone_all_24 = DB::select($sql);
        $phone_all_count_24 = count($phone_all_24);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." wechat_info wi ";
        $sql = $sql." where ";
        $sql = $sql." wi.actiontime > '".$showtime."' ";
        $sql = $sql." and wi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and wi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and wi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and wi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $wechat_all = DB::select($sql);
        $wechat_all_count = count($wechat_all);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." wechat_info wi ";
        $sql = $sql." where ";
        $sql = $sql." wi.actiontime > '".$showtime24."' ";
        $sql = $sql." and wi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        $sql = $sql." and wi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        $sql = $sql." and wi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        $sql = $sql." and wi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        $sql = $sql." order by actiontime desc";
        $wechat_all_24 = DB::select($sql);
        $wechat_all_count_24 = count($wechat_all_24);

        for ($x=0; $x<$msg_all_count; $x++) {
            $date = new DateTime($message_all[$x]->actiontime);
            $ymd = $date->format('Y-m-d');
            $sql = $this->selectActioninfo_sql($message_all[$x]->id);
            $msg = DB::select($sql);
            // var_dump($msg[0]);
            $m=[];
            $msg_action=[];
            $mail_type="";
            $wechat_type="";
            $phone_type="";
            $mail_count=0;
            $phone_count=0;
            $wechat_count=0;
            for ($y=0; $y<count($msg); $y++) {
                if ($msg[$y]->ai_actiontype=="MAIL") {
                    $mail_type="MAIL";
                    if (!empty($msg_count[$ymd]['mail_count'])) {
                        $msg_count[$ymd]['mail_count']++;
                    } else {
                        $msg_count[$ymd]['mail_count']=1;
                    }
                    // $mail_all_count++;
                }
                if ($msg[$y]->ai_actiontype=="PHONE") {
                    $phone_type="PHONE";
                    if (!empty($msg_count[$ymd]['phone_count'])) {
                        $msg_count[$ymd]['phone_count']++;
                    } else {
                        $msg_count[$ymd]['phone_count']=1;
                    }
                    // $phone_all_count++;
                }
                if ($msg[$y]->ai_actiontype=="WECHAT") {
                    $wechat_type="WECHAT";
                    if (!empty($msg_count[$ymd]['wechat_count'])) {
                        $msg_count[$ymd]['wechat_count']++;
                    } else {
                        $msg_count[$ymd]['wechat_count']=1;
                    }
                    // $wechat_all_count++;
                }
                $t=[];
                $t['phone_number']=$msg[$y]->pi_phone_number;
                $t['phone_dtmf']=$msg[$y]->pi_dtmf;
                $t['phone_status_code']=$msg[$y]->pi_status_code;
                $t['mail_to']=$msg[$y]->mi_mail_to;
                $t['wechat_to']=$msg[$y]->wi_wechat_to;
                $msg_action[]=$t;
            }
            $m['message_id']=$message_all[$x]->id;
            $m['message']=$message_all[$x]->message;
            $m['actiontime']=$message_all[$x]->actiontime;
            $m['mail_type']=$mail_type;
            $m['phone_type']=$phone_type;
            $m['wechat_type']=$wechat_type;
            $m['msg_action']=$msg_action;
            $msg_arr[$ymd][]=$m;
        }
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." m.id,m.message,m.actiontime,m.sysid,m.svrid,m.subsysid,m.cmpid ";
        $sql = $sql." from ";
        $sql = $sql." message m ";
        $sql = $sql." join action_info ai on ";
        $sql = $sql." ai.message_id = m.id ";
        $sql = $sql." where ";
        $sql = $sql." m.actiontime > '".$showtime24."' ";
        $sql = $sql." and m.sysid = '".$sel_fluentd[0]->sysid."' ";
        $sql = $sql." and m.svrid = '".$sel_fluentd[0]->svrid."' ";
        $sql = $sql." and m.subsysid = '".$sel_fluentd[0]->subsysid."' ";
        $sql = $sql." and m.cmpid = '".$sel_fluentd[0]->cmpid."' ";
        $sql = $sql." group by ";
        $sql = $sql." m.id ";
        $message_all_24 = DB::select($sql);
        $msg_all_count_24 = count($message_all_24);
        for ($x=0; $x<$msg_all_count_24; $x++) {
            $date = new DateTime($message_all_24[$x]->actiontime);
            $ymdh = $date->format("H:00");
            $sql = $this->selectActioninfo_sql($message_all_24[$x]->id);
            $msg = DB::select($sql);
            $m=[];
            $msg_action=[];
            $mail_type="";
            $wechat_type="";
            $phone_type="";
            // $mail_count=0;
            // $phone_count=0;
            // $wechat_count=0;
            for ($y=0; $y<count($msg); $y++) {
                if ($msg[$y]->ai_actiontype=="MAIL") {
                    $mail_type="MAIL";
                    if (!empty($msg_count_24[$ymdh]['mail_count'])) {
                        $msg_count_24[$ymdh]['mail_count']++;
                    } else {
                        $msg_count_24[$ymdh]['mail_count']=1;
                    }
                    // $mail_all_count_24++;
                }
                if ($msg[$y]->ai_actiontype=="PHONE") {
                    $phone_type="PHONE";
                    if (!empty($msg_count[$ymdh]['phone_count'])) {
                        $msg_count_24[$ymdh]['phone_count']++;
                    } else {
                        $msg_count_24[$ymdh]['phone_count']=1;
                    }
                    // $phone_all_count_24++;
                }
                if ($msg[$y]->ai_actiontype=="WECHAT") {
                    $wechat_type="WECHAT";
                    if (!empty($msg_count_24[$ymdh]['wechat_count'])) {
                        $msg_count_24[$ymdh]['wechat_count']++;
                    } else {
                        $msg_count_24[$ymdh]['wechat_count']=1;
                    }
                    // $wechat_all_count_24++;
                }
                $t=[];
                $t['phone_number']=$msg[$y]->pi_phone_number;
                $t['phone_dtmf']=$msg[$y]->pi_dtmf;
                $t['phone_status_code']=$msg[$y]->pi_status_code;
                $t['mail_to']=$msg[$y]->mi_mail_to;
                $t['wechat_to']=$msg[$y]->wi_wechat_to;
                $msg_action[]=$t;
            }
            $m['message_id']=$message_all_24[$x]->id;
            $m['message']=$message_all_24[$x]->message;
            $m['actiontime']=$message_all_24[$x]->actiontime;
            $m['mail_type']=$mail_type;
            $m['phone_type']=$phone_type;
            $m['wechat_type']=$wechat_type;
            $m['msg_action']=$msg_action;
            $msg_arr_24[$ymdh][]=$m;
        }
        $msg_all_counts=[];
        $msg_all_counts['msg_all_count']=$msg_all_count;
        $msg_all_counts['mail_all_count']=$mail_all_count;
        $msg_all_counts['phone_all_count']=$phone_all_count;
        $msg_all_counts['wechat_all_count']=$wechat_all_count;
        $msg_all_counts_24=[];
        $msg_all_counts_24['msg_all_count_24']=$msg_all_count_24;
        $msg_all_counts_24['mail_all_count_24']=$mail_all_count_24;
        $msg_all_counts_24['phone_all_count_24']=$phone_all_count_24;
        $msg_all_counts_24['wechat_all_count_24']=$wechat_all_count_24;
        $view_json=[];
        $view_json[]=[];                        // index=0
        $view_json[]=$fluentd_sel;              // index=1
        $view_json[]=$ymdhour;                  // index=2
        $view_json[]=$weeks;                    // index=3 一周内日期List
        $view_json[]=$msg_arr;                  // index=4
        $view_json[]=$msg_count;                // index=5
        $view_json[]=$msg_all_counts;           // index=6 一周内msg_counts
        $view_json[]=$fluentd_id;               // index=7 24小时内msg_counts
        $view_json[]=$msg_all_counts_24;        // index=8 一周内msg_counts
        $view_json[]=$msg_arr_24;               // index=9
        $view_json[]=$hour;                     // index=10
        $view_json[]=$msg_count_24;             // index=11

        $view_json[]=$mail_all;                 // index=12
        $view_json[]=$mail_all_24;              // index=13
        $view_json[]=$phone_all;                // index=14
        $view_json[]=$phone_all_24;             // index=15
        $view_json[]=$wechat_all;               // index=16
        $view_json[]=$wechat_all_24;            // index=17
        // var_dump($view_json[2]);
        // var_dump($view_json[3]);
        // var_dump($view_json[4]);
        // var_dump($view_json[5]);
        // var_dump($view_json[6]);
        // var_dump($view_json[7]);
        // var_dump($view_json[8]);
        // var_dump($view_json[10]);
        // var_dump($view_json[14]);
        // var_dump($view_json[16]);
        // var_dump($view_json[17]);
        $content = new Content();
        return $content
            ->header('信息查询')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }
    public function selectActioninfo_sql($id)
    {
            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." ai.message_id as ai_message_id, ";
            $sql = $sql." ai.phone_id as ai_phone_id, ";
            $sql = $sql." ai.mail_id as ai_mail_id, ";
            $sql = $sql." ai.wechat_id as ai_wechat_id, ";
            $sql = $sql." ai.code4 as ai_code4, ";
            $sql = $sql." ai.code5 as ai_code5, ";
            $sql = $sql." ai.code6 as ai_code6, ";
            $sql = $sql." ai.actiontype as ai_actiontype, ";
            $sql = $sql." ai.actiontime as ai_actiontime,  ";
            $sql = $sql." pi.call_id as pi_call_id, ";
            $sql = $sql." pi.sys_id as pi_sys_id, ";
            $sql = $sql." pi.svr_id as pi_svr_id, ";
            $sql = $sql." pi.sub_sys_id as pi_sub_sys_id, ";
            $sql = $sql." pi.cmp_id as pi_cmp_id, ";
            $sql = $sql." pi.rule_cond as pi_rule_cond, ";
            $sql = $sql." pi.phone_number as pi_phone_number, ";
            $sql = $sql." pi.requestid as pi_requestid, ";
            $sql = $sql." pi.code as pi_code, ";
            $sql = $sql." pi.message as pi_message, ";
            $sql = $sql." pi.actiontime as pi_actiontime, ";
            $sql = $sql." pi.dtmf as pi_dtmf, ";
            $sql = $sql." pi.duration as pi_duration, ";
            $sql = $sql." pi.status_code as pi_status_code, ";
            $sql = $sql." mi.id as mi_id, ";
            $sql = $sql." mi.sys_id as mi_sys_id, ";
            $sql = $sql." mi.svr_id as mi_svr_id, ";
            $sql = $sql." mi.sub_sys_id as mi_sub_sys_id, ";
            $sql = $sql." mi.cmp_id as mi_cmp_id, ";
            $sql = $sql." mi.mail_to as mi_mail_to, ";
            $sql = $sql." mi.mail_from as mi_mail_from, ";
            $sql = $sql." mi.contact_name as mi_contact_name, ";
            $sql = $sql." mi.actiontime as mi_actiontime, ";
            $sql = $sql." wi.id as wi_id, ";
            $sql = $sql." wi.sys_id as wi_sys_id, ";
            $sql = $sql." wi.svr_id as wi_svr_id, ";
            $sql = $sql." wi.sub_sys_id as wi_sub_sys_id, ";
            $sql = $sql." wi.cmp_id as wi_cmp_id, ";
            $sql = $sql." wi.wechat_to as wi_wechat_to, ";
            $sql = $sql." wi.qy_id as wi_qy_id, ";
            $sql = $sql." wi.qy_secret as wi_qy_secret, ";
            $sql = $sql." wi.qy_agent_id as wi_qy_agent_id, ";
            $sql = $sql." wi.group_flg as wi_group_flg, ";
            $sql = $sql." wi.contact_name as wi_contact_name, ";
            $sql = $sql." wi.actiontime as wi_actiontime";
            $sql = $sql." from ";
            $sql = $sql." action_info ai ";
            $sql = $sql." left join phone_info pi on ";
            $sql = $sql." pi.call_id = ai.phone_id ";
            $sql = $sql." left join mail_info mi on ";
            $sql = $sql." mi.id = ai.mail_id ";
            $sql = $sql." left join wechat_info wi on ";
            $sql = $sql." wi.id = ai.wechat_id ";
            $sql = $sql." where ";
            $sql = $sql." message_id = ".$id." ";
        return $sql;
    }
}
