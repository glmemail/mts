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
        // $fluentd = Fluentd::select('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id')
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            // ->where('language', 'cn')
            // ->orderBy('id');
            ->get()
            ->groupBy('keyid');
        // $svrid = "";
        $fluentd_json = json_decode($fluentd,true);
        // var_dump($fluentd_json);
        // var_dump($fluentd);
        $s = [];
        foreach ($fluentd_json as $k => $v) {
            $s[] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['subsysid'];
        }
        // var_dump($s);
        $fluentd_sel = $s;
        // var_dump($fluentd_json);
        // $count_fluentd = count($fluentd);
        // var_dump($fluentd_json);
        // var_dump($fluentd);
        // foreach($fluentd_json as $key=>$value){
        //     // echo 'key: '.$key.' --- value: '.$value.'<br/>';
        //     var_dump($key);
        //     var_dump($value);
        //     $value[0];
        //     $json = json_encode($value);
        //     // var_dump($json);/ $json['sysid'];
        //     // foreach($fluentd_json as $key1=>$value1){
        //     //     var_dump($key1);
        //     //     var_dump($value1);

        //     // }
        // }



        // for ($i = 0; $i < $count_fluentd; $i++)
        // {

            // $sysid = $fluentd_json[$i]['sysid'];
            // $svrid = $fluentd_json[$i]['svrid'];
            // $subsysid = $fluentd_json[$i]['subsysid'];
            // $cmpid = $fluentd_json[$i]['c'];
            // $user_id = $fluentd_json[$i]['user_id'];
            // $message = json_encode($de_json[$i]['data']);

        // }

        $actoninfo = Action_info::select(array('message_id', 'actiontype', 'message.message'))
            ->join('message','action_info.message_id','=','message.id')
            // ->where('actiontype', 'WECHAT')
            // ->where('language', 'cn')
            // ->orderBy('id')
            ->get()
            ->groupBy('actiontype'); // 按actiontype分组
        $actoninfo_json = json_decode($actoninfo,TRUE);
        // $count_json = count($actoninfo_json);
        // for ($i = 0; $i < $count_json; $i++)
        // {
        //     //echo var_dump($de_json);
        //     $message = $actoninfo_json[$i]['message'];
        //     // $svrid = $actoninfo_json[$i]['svrid'];
        // $svrid = var_dump($fluentd_json)[0]['svrid'];
        //     // $subsysid = $actoninfo_json[$i]['subsysid'];
        //     // $cmpid = $actoninfo_json[$i]['cmpid'];
        //     // $user_id = $actoninfo_json[$i]['user_id'];
        //     // $message = json_encode($de_json[$i]['data']);
        // }

        $str = "";
        // $str = $str.'start【'.$fluentd;
        $cnt = 0;
        // $g[0];
        // foreach ($g as $value)
        // {
            // if($cnt == 0) {
            //     $str = $value->count;
            // }
            // else{
            //     $str = $str.','.$value->count;
            // }
            // $cnt++;
        // }
        // $str = $str.'】end';
        $action_count  = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        return $content
            ->header('Chartjs')

            ->body(new Box('Bar'.':'.$str, view('admin.chartjs', compact('action_count'), compact('fluentd_sel'))));

    //     $grid->header(function ($content) {

    //         $gender = $content->select(DB::raw('count(actiontype) as count, actiontype'))

    //         ->groupBy('actiontype')->get()->pluck('count', 'actiontype')->toArray();

    //         $doughnut = view('admin.chartjs', compact('gender'));

    //         return new Box('性别比例', $doughnut);

    //     });


    }

}
