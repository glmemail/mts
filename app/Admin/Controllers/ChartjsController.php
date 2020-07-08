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
        foreach ($fluentd_json as $k => $v) {
            $s[$k] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
        }
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

        foreach ($fluentd_json as $k => $v) {
            $sysid = $v[0]['sysid'];
            $svrid = $v[0]['svrid'];
            $subsysid = $v[0]['subsysid'];
            $cmpid = $v[0]['cmpid'];
            $sql="select * from message "." where message.actiontime >= '".$showtime."'";
            $sql=$sql." and 'sysid'='".$sysid."'";
            $sql=$sql." and svrid='".$svrid."'";
            $sql=$sql." and subsysid='".$subsysid."'";
            $sql=$sql." and cmpid='".$cmpid."'";
            $message_all = DB::select($sql);
            $msg_all_count = $msg_all_count + count($message_all);
        }
        $actoninfo_json = json_decode($actoninfo,TRUE);
        $actoninfo1_json = json_decode($actoninfo1,TRUE);
        $message_json = json_decode($message,TRUE);
        $msg_arr=[];
        $msg_count=[];
        $message_id=0;
        $mail_all_count=0;
        $phone_all_count=0;
        $wechat_all_count=0;
        foreach ($message_json as $k => $v) {
            $mail_count=0;
            $phone_count=0;
            $wechat_count=0;
            $msg=[];
            for ($x=0; $x<count($v); $x++) {
                $mail_type="";
                $phone_type="";
                $wechat_type="";
                $m=[];
                if ($v[$x]['actiontype']=='MAIL'){
                    $mail_count++;
                    $mail_all_count++;
                    $mail_type="MAIL";
                }
                if ($v[$x]['actiontype']=='PHONE'){
                    $phone_count++;
                    $phone_all_count++;
                    $phone_type="PHONE";
                }
                if ($v[$x]['actiontype']=='WECHAT'){
                    $wechat_count++;
                    $mail_all_count++;
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
                                // ->where('dtmf', '2')
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
                        $aliivr=Aliivr::select('call_id','dtmf')
                        ->where('call_id', $v[$x]['call_id'])
                        // ->where('dtmf', '2')
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
                    $aliivr=Aliivr::select('call_id','dtmf')
                    ->where('call_id', $v[$x]['call_id'])
                    // ->where('dtmf', '2')
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

        $msg_all_counts=[];
        $msg_all_counts['msg_all_count']=$msg_all_count;
        $msg_all_counts['mail_all_count']=$mail_all_count;
        $msg_all_counts['phone_all_count']=$phone_all_count;
        $msg_all_counts['wechat_all_count']=$wechat_all_count;
        $view_json=[];
        $view_json[]=$actoninfo_json;    // index=0
        $view_json[]=$fluentd_sel;       // index=1
        $view_json[]=$actoninfo1_json;   // index=2
        $view_json[]=$weeks;             // index=3 一周内日期List
        $view_json[]=$msg_arr;           // index=4
        $view_json[]=$msg_count;           // index=5
        $view_json[]=$msg_all_counts;           // index=6 一周内msg_counts
        // var_dump($msg_arr['2020-06-22']);
        // var_dump($message_json);
        // var_dump($actoninfo1_json);
        // var_dump($view_json[0]);
        // var_dump($view_json[1]);
        // var_dump($view_json[2]);
        // var_dump($view_json[3]);
        // var_dump($view_json[4]);
        // var_dump($view_json[5]);
        // var_dump($view_json[6]);
        // var_dump($view_json[5][$view_json[3][6]]['mail_count']);
        $cnt = 0;
        // $action_count  = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        return $content
            ->header('Chartjs')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }

    public function combaction(Request $request)
    {

        $fluentd_id =$request['fluentd_id'];
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
        foreach ($fluentd_json as $k => $v) {
            $s[$k] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
        }
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
            ->where('fluentd.keyid', $fluentd_id)
            ->get()
            ->groupBy('actiontype'); // 按actiontype分组
        // $days = Input::get('days', 7);
        // $range = Carbon::now()->subDays($days);
        $showtime=date("Y-m-d",strtotime("-7 day"));
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
            ->where('fluentd.keyid', $fluentd_id)
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
            ->where('fluentd.keyid', $fluentd_id)
            ->where('message.actiontime','>=', $showtime)
            ->orderBy('actiontime', 'asc')
            ->orderBy('message.id', 'asc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->actiontime)->format('yy-m-d');
                });
        // $message_all = Message::select(array('message.id','message.actiontime'))
        //     ->where('message.actiontime','>=', $showtime)
        //     ->orderBy('actiontime', 'asc')
        //     ->orderBy('message.id', 'asc')
        //     ->get()
        //     ->groupBy(function($date) {
        //         return Carbon::parse($date->actiontime)->format('yy-m-d');
        //         });
        $sql="select * from fluentd "." where fluentd.keyid = ".$fluentd_id;
        $sel_fluentd = DB::select($sql);
        // var_dump($sel_fluentd[0]->sysid);
        $sql="select * from message "." where message.actiontime >= '".$showtime."'";
        $sql=$sql." and message.sysid='".$sel_fluentd[0]->sysid."'";
        $sql=$sql." and message.svrid='".$sel_fluentd[0]->svrid."'";
        $sql=$sql." and message.subsysid='".$sel_fluentd[0]->subsysid."'";
        $sql=$sql." and message.cmpid='".$sel_fluentd[0]->cmpid."'";
        $message_all = DB::select($sql);
        $msg_all_count = count($message_all);
        $actoninfo_json = json_decode($actoninfo,TRUE);
        $actoninfo1_json = json_decode($actoninfo1,TRUE);
        $message_json = json_decode($message,TRUE);
        // $message_all_json = json_decode($message_all,TRUE);
        $msg=[];
        $msg_arr=[];
        $msg_count=[];
        $message_id=0;
        $mail_all_count=0;
        $phone_all_count=0;
        $wechat_all_count=0;
        foreach ($message_json as $k => $v) {
            $mail_count=0;
            $phone_count=0;
            $wechat_count=0;
            $msg=[];
            for ($x=0; $x<count($v); $x++) {
                $mail_type="";
                $phone_type="";
                $wechat_type="";
                $m=[];
                if ($v[$x]['actiontype']=='MAIL'){
                    $mail_count++;
                    $mail_all_count++;
                    $mail_type="MAIL";
                }
                if ($v[$x]['actiontype']=='PHONE'){
                    $phone_count++;
                    $phone_all_count++;
                    $phone_type="PHONE";
                }
                if ($v[$x]['actiontype']=='WECHAT'){
                    $wechat_count++;
                    $mail_all_count++;
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
                        $aliivr=Aliivr::select('call_id','dtmf')
                        ->where('call_id', $v[$x]['call_id'])
                        // ->where('dtmf', '2')
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
                        $aliivr=Aliivr::select('call_id','dtmf')
                        ->where('call_id', $v[$x]['call_id'])
                        // ->where('dtmf', '2')
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

        $msg_all_counts=[];
        // $msg_all_count=0;
        // foreach ($message_all_json as $k => $v) {
        //     for ($x=0; $x<count($v); $x++) {
        //         $msg_all_count++;
        //     }
        // }
        $msg_all_counts['msg_all_count']=$msg_all_count;
        $msg_all_counts['mail_all_count']=$mail_all_count;
        $msg_all_counts['phone_all_count']=$phone_all_count;
        $msg_all_counts['wechat_all_count']=$wechat_all_count;
        $view_json=[];
        $view_json[]=$actoninfo_json;         // index=0
        $view_json[]=$fluentd_sel;            // index=1
        $view_json[]=$actoninfo1_json;        // index=2
        $view_json[]=$weeks;                  // index=3 一周内日期List
        $view_json[]=$msg_arr;                // index=4
        $view_json[]=$msg_count;              // index=5
        $view_json[]=$msg_all_counts;         // index=6 一周内msg_counts
        $view_json[]=$fluentd_id;             // index=7 fluentd下拉框默认选择
        $cnt = 0;
        // $action_count  = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        $content = new Content();
        return $content
            ->header('Chartjs')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }

}
