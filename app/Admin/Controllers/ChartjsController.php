<?php

namespace App\Admin\Controllers;

use App\Models\Fluentd;
use App\Models\Message;
use App\Models\Action_info;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Auth;
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
            // ->orderBy('id')
            ->get()
            ->groupBy('actiontype'); // 按actiontype分组
        $actoninfo1 = Action_info::select(array('action_info.message_id', 'action_info.actiontype', 'action_info.actiontime', 'phone_info.phone_number', 'mail_info.mail_to', 'wechat_info.wechat_to'))
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
            ->groupBy(function($date) {
                return Carbon::parse($date->actiontime)->format('m');
                });





        $actoninfo_json = json_decode($actoninfo,TRUE);
        $actoninfo1_json = json_decode($actoninfo1,TRUE);
        var_dump($actoninfo1_json);
        $view_json=[];
        $view_json[]=$actoninfo_json;
        $view_json[]=$fluentd_sel;
        $view_json[]=$actoninfo1_json;
        $cnt = 0;
        // $action_count  = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        return $content
            ->header('Chartjs')
            ->body(new Box('', view('admin.chartjs', compact('view_json'))));

    }

}
