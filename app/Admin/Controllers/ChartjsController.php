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
        // var_dump($fluentd_json);
        $s = [];
        foreach ($fluentd_json as $k => $v) {
            $s[] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
        }
        // var_dump($s);
        $fluentd_sel = $s;
        $actoninfo = Action_info::select(array('action_info.message_id', 'action_info.actiontype', 'action_info.actiontime', 'phone_info.phone_number', 'mail_info.mail_to', 'wechat_info.wechat_to', 'fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid'))
            ->join('message','action_info.message_id','=','message.id')
            ->join('fluentd',function ($join) {
                $join->on('message.sysid', '=', 'fluentd.sysid')
                    ->on('message.svrid', '=', 'fluentd.svrid')
                    ->on('message.subsysid', '=', 'fluentd.subsysid')
                    ->on('message.cmpid', '=', 'fluentd.cmpid');
                })
            ->join('user_fluentd',function ($join) {
                $join->on('fluentd.keyid', '=', 'user_fluentd.fluentd_keyid');
                })
            ->leftjoin('phone_info','action_info.phone_id','=','phone_info.call_id')
            ->leftjoin('mail_info','action_info.mail_id','=','mail_info.id')
            ->leftjoin('wechat_info','action_info.wechat_id','=','wechat_info.id')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('actiontype'); // 按actiontype分组
        // $days = Input::get('days', 7);
        // $range = Carbon::now()->subDays($days);
        $showtime=date("Y-m-d",strtotime("-7 day"));
        // var_dump($showtime);
        $actoninfo1 = Action_info::select(array('action_info.message_id', 'action_info.actiontype', 'action_info.actiontime', 'phone_info.phone_number', 'mail_info.mail_to', 'wechat_info.wechat_to', 'fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid'))
            ->join('message','action_info.message_id','=','message.id')
            ->join('fluentd',function ($join) {
                $join->on('message.sysid', '=', 'fluentd.sysid')
                    ->on('message.svrid', '=', 'fluentd.svrid')
                    ->on('message.subsysid', '=', 'fluentd.subsysid')
                    ->on('message.cmpid', '=', 'fluentd.cmpid');
                })
            ->join('user_fluentd',function ($join) {
                $join->on('fluentd.keyid', '=', 'user_fluentd.fluentd_keyid');
                })
            ->leftjoin('phone_info','action_info.phone_id','=','phone_info.call_id')
            ->leftjoin('mail_info','action_info.mail_id','=','mail_info.id')
            ->leftjoin('wechat_info','action_info.wechat_id','=','wechat_info.id')
            ->where('user_fluentd.user_id', $user['username'])
            ->where('action_info.actiontime','>=', $showtime)
            ->orderBy('actiontime', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->actiontime)->format('yy-m-d');
                });
        $weeks=[];
        for ($x=6; $x>=0; $x--) {
            $day_str="-".$x." day";
            $weeks[]=date("Y-m-d",strtotime($day_str));
        }
        // var_dump($weeks);
        $message = Message::select(array('message.id','message.message','action_info.message_id', 'action_info.actiontime', 'action_info.actiontype', 'phone_info.phone_number', 'phone_info.call_id', 'mail_info.mail_to', 'wechat_info.wechat_to', 'fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid'))
            ->leftjoin('action_info','action_info.message_id','=','message.id')
            ->leftjoin('fluentd',function ($join) {
                $join->on('message.sysid', '=', 'fluentd.sysid')
                    ->on('message.svrid', '=', 'fluentd.svrid')
                    ->on('message.subsysid', '=', 'fluentd.subsysid')
                    ->on('message.cmpid', '=', 'fluentd.cmpid');
                })
            ->join('user_fluentd',function ($join) {
                $join->on('fluentd.keyid', '=', 'user_fluentd.fluentd_keyid');
                })
            ->leftjoin('phone_info','action_info.phone_id','=','phone_info.call_id')
            ->leftjoin('mail_info','action_info.mail_id','=','mail_info.id')
            ->leftjoin('wechat_info','action_info.wechat_id','=','wechat_info.id')
            ->where('user_fluentd.user_id', $user['username'])
            ->where('message.actiontime','>=', $showtime)
            ->orderBy('actiontime', 'asc')
            ->orderBy('message.id', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->actiontime)->format('yy-m-d');
                });

        $actoninfo_json = json_decode($actoninfo,TRUE);
        $actoninfo1_json = json_decode($actoninfo1,TRUE);
        $message_json = json_decode($message,TRUE);
        $msg = [];
        $msg_arr= [];
        $msg_count= [];
        $message_id=0;
        $message_count=0;
        foreach ($message_json as $k => $v) {
            $message_count++;
            // $message_id=$v[0]['id'];
            $mail_count=0;
            $phone_count=0;
            $wechat_count=0;
            $msg=[];
            for ($x=0; $x<count($v); $x++) {
                // var_dump($v[$x]);
                $mail_type="";
                $phone_type="";
                $wechat_type="";
                $m=[];
                if ($v[$x]['actiontype']=='MAIL'){
                    $mail_count++;
                    $mail_type="MAIL";
                }
                if ($v[$x]['actiontype']=='PHONE'){
                    $phone_count++;
                    $phone_type="PHONE";
                }
                if ($v[$x]['actiontype']=='WECHAT'){
                    $wechat_count++;
                    $wechat_type="WECHAT";
                }
                if ($message_id==$v[$x]['id']) {
                    if (count($msg)>0){
                        for ($x1=0; $x1<count($msg); $x1++) {
                            if ($msg[$x1]['message_id']==$v[$x]['id']){
                                $msg[$x1]['message_id']=$v[$x]['id'];
                                $msg[$x1]['message']=$v[$x]['message'];
                                $msg[$x1]['actiontime']=$v[$x]['actiontime'];
                                if (!empty($mail_type)) {
                                    $msg[$x1]['mail_type']=$mail_type;
                                }
                                if (!empty($phone_type)) {
                                    $msg[$x1]['phone_type']=$phone_type;
                                }
                                if (!empty($wechat_type)) {
                                    $msg[$x1]['wechat_type']=$wechat_type;
                                }
                                $t=[];
                                $t['phone_number']=$v[$x]['phone_number'];
                                $aliivr=Aliivr::select('call_id','dtmf')
                                ->where('call_id', $v[$x]['call_id'])
                                ->where('dtmf', '2')
                                ->get()
                                ->groupBy('call_id');
                                $aliivr_json = json_decode($aliivr,TRUE);
                                if(count($aliivr_json)>0) {
                                    $dtmf=$aliivr_json[$v[$x]['call_id']][0]['dtmf'];
                                    $t['phone_dtmf']=$dtmf;
                                } else {
                                    $t['phone_dtmf']="";
                                }
                                $t['mail_to']=$v[$x]['mail_to'];
                                $t['wechat_to']=$v[$x]['wechat_to'];
                                $msg[$x1]['msg_action'][]=$t;
                                break;
                            }
                        }
                    } else {
                        $msg_action=[];
                        $m['message_id']=$v[$x]['id'];
                        $m['message']=$v[$x]['message'];
                        $m['actiontime']=$v[$x]['actiontime'];
                        if (!empty($mail_type)) {
                            $m['mail_type']=$mail_type;
                        }
                        if (!empty($phone_type)) {
                            $m['phone_type']=$phone_type;
                        }
                        if (!empty($wechat_type)) {
                            $m['wechat_type']=$wechat_type;
                        }
                        $t=[];
                        $t['phone_number']=$v[$x]['phone_number'];
                        $t['mail_to']=$v[$x]['mail_to'];
                        $t['wechat_to']=$v[$x]['wechat_to'];
                        $msg_action[]=$t;
                        $m['msg_action']=$msg_action;
                        $msg[]=$m;
                    }

                } else {
                    $msg_action=[];
                    $m['message_id']=$v[$x]['id'];
                        $m['message']=$v[$x]['message'];
                    $m['actiontime']=$v[$x]['actiontime'];
                    if (!empty($mail_type)) {
                        $m['mail_type']=$mail_type;
                    }
                    if (!empty($phone_type)) {
                        $m['phone_type']=$phone_type;
                    }
                    if (!empty($wechat_type)) {
                        $m['wechat_type']=$wechat_type;
                    }
                    $t=[];
                    $t['phone_number']=$v[$x]['phone_number'];
                    $t['mail_to']=$v[$x]['mail_to'];
                    $t['wechat_to']=$v[$x]['wechat_to'];
                    $msg_action[]=$t;
                    $m['msg_action']=$msg_action;
                    $msg[]=$m;
                }
                $message_id=$v[$x]['id'];
            }
            $msg_arr[$k]=$msg;
            $msg_count[$k]['mail_count']=$mail_count;
            $msg_count[$k]['phone_count']=$phone_count;
            $msg_count[$k]['wechat_count']=$wechat_count;
        }
        $view_json=[];
        $view_json[]=$actoninfo_json;    // index=0
        $view_json[]=$fluentd_sel;       // index=1
        $view_json[]=$actoninfo1_json;   // index=2
        $view_json[]=$weeks;             // index=3
        $view_json[]=$msg_arr;           // index=4
        $view_json[]=$msg_count;           // index=4
        // var_dump($msg_arr['2020-06-22']);
        // var_dump($message_json);
        // var_dump($actoninfo1_json);
        // var_dump($view_json[0]);
        // var_dump($view_json[2]);
        // var_dump($view_json[3]);
        var_dump($message_json);
        // var_dump($view_json[5]);
        $cnt = 0;
        // $action_count  = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        return $content
            ->header('Chartjs')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }

}
