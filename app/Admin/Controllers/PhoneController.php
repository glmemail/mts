<?php

namespace App\Admin\Controllers;

use App\Models\phone_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use App\Models\Fluentd;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PhoneController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'phone_info';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new phone_info());

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('sys_id', 'SYS_ID');
            $filter->like('svr_id', 'SVR_ID');
            $filter->like('sub_sys_id', 'SUB_SYS_ID');
            $filter->like('cmp_id', 'CMP_ID');
            $filter->like('phone_number', 'PHONE_NUMBER');
            $filter->like('actiontime', 'ActionTime');
        });
        // $grid->column('call_id', __('Call id'));

        $grid->column('call_id', __('Call id -> Message id'))->display(function($id) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." action_info ai ";
            $sql = $sql." where ";
            $sql = $sql." ai.phone_id = '".$id."' ";
            $r = DB::select($sql);
            $t = "<span>";
            $t = "".$t.$id."</span><br/><span>";
            for ($x=0; $x<count($r); $x++) {
                $t = $t."<font color='blue' >->".$r[$x]->message_id."</font><br/>";
            }
            $t = $t."</span>";
            return $t;
        });
        $grid->column('sys_id', __('Sys id'));
        $grid->column('svr_id', __('Svr id'));
        $grid->column('sub_sys_id', __('Sub sys id'));
        $grid->column('cmp_id', __('Cmp id'));
        // $grid->column('rule_cond', __('Rule cond'));
        $grid->column('phone_number', __('Phone number'));
        // $grid->column('requestid', __('Requestid'));
        // $grid->column('code', __('Code'));
        // $grid->column('message', __('Message'));
        $grid->column('actiontime', __('Actiontime'));
        $grid->column('dtmf', __('处理'))->display(function ($dtmf) {
            if($dtmf==2) {
                return "当番处理";
            }else {
                return "未接通";

            }
            // return "<span class='label label-warning'>{$action}</span>";
        });

        $user = Auth::guard('admin')->user();
        $fluentd = Fluentd::select(array('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id'))
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('keyid');
        $fluentd_json = json_decode($fluentd,true);
        foreach ($fluentd_json as $k => $v) {
            $sysid = $v[0]['sysid'];
            $grid->model()->Orwhere('sys_id', '=', $sysid);
        }
        // $grid->column('duration', __('Duration'));
        // $grid->column('status_code', __('Status code'));
        $grid->model()->where('actiontime', '>=', $showtime);

        $grid->disableCreateButton();
        $grid->disableActions();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        // $show = new Show(phone_info::findOrFail($id));

        // $show->field('call_id', __('Call id'));
        // $show->field('sys_id', __('Sys id'));
        // $show->field('svr_id', __('Svr id'));
        // $show->field('sub_sys_id', __('Sub sys id'));
        // $show->field('cmp_id', __('Cmp id'));
        // $show->field('rule_cond', __('Rule cond'));
        // $show->field('phone_number', __('Phone number'));
        // $show->field('requestid', __('Requestid'));
        // $show->field('code', __('Code'));
        // $show->field('message', __('Message'));
        // $show->field('actiontime', __('Actiontime'));
        // $show->field('dtmf', __('Dtmf'));
        // $show->field('duration', __('Duration'));
        // $show->field('status_code', __('Status code'));

        // return $show;

        $grid = new Grid(new phone_info());

        $showtime=date("Y-m-d",strtotime("-6 day"));
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('sys_id', 'SYS_ID');
            $filter->like('svr_id', 'SVR_ID');
            $filter->like('sub_sys_id', 'SUB_SYS_ID');
            $filter->like('cmp_id', 'CMP_ID');
            $filter->like('phone_number', 'PHONE_NUMBER');
            $filter->like('actiontime', 'ActionTime');
        });
        $grid->column('call_id', __('Call id -> Message id'))->display(function($id) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." action_info ai ";
            $sql = $sql." where ";
            $sql = $sql." ai.phone_id = '".$id."' ";
            $r = DB::select($sql);
            $t = "<span>";
            $t = "".$t.$id."</span><br/><span>";
            for ($x=0; $x<count($r); $x++) {
                $t = $t."<font color='blue' >->".$r[$x]->message_id."</font><br/>";
            }
            $t = $t."</span>";
            return $t;
        });
        $grid->column('sys_id', __('Sys id'));
        $grid->column('svr_id', __('Svr id'));
        $grid->column('sub_sys_id', __('Sub sys id'));
        $grid->column('cmp_id', __('Cmp id'));
        // $grid->column('rule_cond', __('Rule cond'));
        $grid->column('phone_number', __('Phone number'));
        // $grid->column('requestid', __('Requestid'));
        // $grid->column('code', __('Code'));
        // $grid->column('message', __('Message'));
        $grid->column('actiontime', __('Actiontime'));
        $grid->column('dtmf', __('处理'))->display(function ($dtmf) {
            if($dtmf==2) {
                return "当番处理";
            }else {
                return "未接通";

            }
            // return "<span class='label label-warning'>{$action}</span>";
        });
        // $grid->column('duration', __('Duration'));
        // $grid->column('status_code', __('Status code'));

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." fluentd f ";
        $sql = $sql." where ";
        $sql = $sql." f.keyid =".$id." ";
        $fluentdList = DB::select($sql);
        for ($x=0; $x<count($fluentdList); $x++) {
            $sysid=$fluentdList[$x]->sysid;
            $grid->model()->Orwhere('sys_id', '=', $sysid);
        }
        $grid->model()->where('actiontime', '>=', $showtime);
        $grid->disableCreateButton();
        $grid->disableActions();
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new phone_info());

        $form->text('call_id', __('Call id'));
        $form->text('sys_id', __('Sys id'));
        $form->text('svr_id', __('Svr id'));
        $form->text('sub_sys_id', __('Sub sys id'));
        $form->text('cmp_id', __('Cmp id'));
        $form->text('rule_cond', __('Rule cond'));
        $form->text('phone_number', __('Phone number'));
        $form->text('requestid', __('Requestid'));
        $form->text('code', __('Code'));
        $form->text('message', __('Message'));
        $form->datetime('actiontime', __('Actiontime'))->default(date('Y-m-d H:i:s'));
        $form->text('dtmf', __('Dtmf'));
        $form->text('duration', __('Duration'));
        $form->text('status_code', __('Status code'));

        return $form;
    }
}
