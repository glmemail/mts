<?php

namespace App\Admin\Controllers;

use App\Models\wechat_info;
use App\Models\Action_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use App\Models\Fluentd;
use Illuminate\Http\Request;
use DB;
use DateTime;

class WechatController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\wechat_info';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new wechat_info());

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('sys_id', 'SYS_ID');
            $filter->like('svr_id', 'SVR_ID');
            $filter->like('sub_sys_id', 'SUB_SYS_ID');
            $filter->like('cmp_id', 'CMP_ID');
            $filter->like('contact_name', 'CONTACT_NAME');
            $filter->like('wechat_to', 'WECHAT_TO');
            $filter->like('actiontime', 'ActionTime');
        });
        // $grid->column('id', __('Id'));
        $grid->column('id', __('Message id'))->display(function($wechat_id) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." action_info ai ";
            $sql = $sql." where ";
            $sql = $sql." ai.wechat_id = '".$wechat_id."' ";
            $r = DB::select($sql);
            $t = "";
            for ($x=0; $x<count($r); $x++) {
                $t = $t.$r[$x]->message_id."<br/>";
            }
            return $t;
        });
        $grid->column('sys_id', __('Sys id'));
        $grid->column('svr_id', __('Svr id'));
        $grid->column('sub_sys_id', __('Sub sys id'));
        $grid->column('cmp_id', __('Cmp id'));
        $grid->column('wechat_to', __('Wechat to'));
        // $grid->column('qy_id', __('Qy id'));
        // $grid->column('qy_secret', __('Qy secret'));
        // $grid->column('qy_agent_id', __('Qy agent id'));
        // $grid->column('group_flg', __('Group flg'));
        $grid->column('contact_name', __('Contact name'));
        $grid->column('actiontime', __('Actiontime'));
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
        $showtime=date("Y-m-d",strtotime("-6 day"));
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
        // $show = new Show(wechat_info::findOrFail($id));

        // $show->field('id', __('Id'));
        // $show->field('sys_id', __('Sys id'));
        // $show->field('svr_id', __('Svr id'));
        // $show->field('sub_sys_id', __('Sub sys id'));
        // $show->field('cmp_id', __('Cmp id'));
        // $show->field('wechat_to', __('Wechat to'));
        // $show->field('qy_id', __('Qy id'));
        // $show->field('qy_secret', __('Qy secret'));
        // $show->field('qy_agent_id', __('Qy agent id'));
        // $show->field('group_flg', __('Group flg'));
        // $show->field('contact_name', __('Contact name'));
        // $show->field('actiontime', __('Actiontime'));

        // return $show;


        $grid = new Grid(new wechat_info());

        $showtime=date("Y-m-d",strtotime("-6 day"));
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('sys_id', 'SYS_ID');
            $filter->like('svr_id', 'SVR_ID');
            $filter->like('sub_sys_id', 'SUB_SYS_ID');
            $filter->like('cmp_id', 'CMP_ID');
            $filter->like('contact_name', 'CONTACT_NAME');
            $filter->like('wechat_to', 'WECHAT_TO');
            $filter->like('actiontime', 'ActionTime');
        });
        // $grid->column('id', __('Id'));
        // $grid->column('id', __('Id'));
        $grid->column('id', __('Wechat id -> Message id'))->display(function($id) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." action_info ai ";
            $sql = $sql." where ";
            $sql = $sql." ai.wechat_id = ".$id." ";
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
        $grid->column('wechat_to', __('Wechat to'));
        // $grid->column('qy_id', __('Qy id'));
        // $grid->column('qy_secret', __('Qy secret'));
        // $grid->column('qy_agent_id', __('Qy agent id'));
        // $grid->column('group_flg', __('Group flg'));
        $grid->column('contact_name', __('Contact name'));
        $grid->column('actiontime', __('Actiontime'));
        $user = Auth::guard('admin')->user();
        $fluentd = Fluentd::select(array('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id'))
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('keyid');
        $fluentd_json = json_decode($fluentd,true);
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." fluentd f ";
        $sql = $sql." where ";
        if ($id==0) {
            $x = 0;
            foreach ($fluentd_json as $k => $v) {
                $x++;
                $sql = $sql." f.keyid =".$v[0]['keyid'];
                if ($x!=count($fluentd_json)) {
                    $sql = $sql." or ";
                }
            }
        } else {
            $sql = $sql." f.keyid =".$id." ";
        }
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
        $form = new Form(new wechat_info());

        $form->text('sys_id', __('Sys id'));
        $form->text('svr_id', __('Svr id'));
        $form->text('sub_sys_id', __('Sub sys id'));
        $form->text('cmp_id', __('Cmp id'));
        $form->text('wechat_to', __('Wechat to'));
        $form->text('qy_id', __('Qy id'));
        $form->text('qy_secret', __('Qy secret'));
        $form->text('qy_agent_id', __('Qy agent id'));
        $form->text('group_flg', __('Group flg'));
        $form->text('contact_name', __('Contact name'));
        $form->datetime('actiontime', __('Actiontime'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
