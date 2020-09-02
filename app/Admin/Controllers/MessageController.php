<?php

namespace App\Admin\Controllers;

use App\Models\Message;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Action_info;
use App\Models\Fluentd;
use Illuminate\Support\Facades\Auth;
use DB;

class MessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Message';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Message());
        $showtime=date("Y-m-d",strtotime("-6 day"));
        // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('message', 'message');
            $filter->like('sysid', 'SYS_ID');
            $filter->like('svrid', 'SVR_ID');
            $filter->like('subsysid', 'SUB_SYS_ID');
            $filter->like('cmpid', 'CMP_ID');
            $filter->like('actiontime', 'ActionTime');
            // ...

        });
        // 第一列显示id字段，并将这一列设置为可排序列
        $grid->column('id', 'ID')->sortable();
        // 显示JSON内嵌字段
        $grid->column('message', 'Message')->display(function ($message) {
            return $this->message;
        })->width(900);
        $grid->column('sysid', 'SYS_ID');
        $grid->column('svrid', 'SVR_ID');
        $grid->column('subsysid', 'SUB_SYS_ID');
        $grid->column('cmpid', 'CMP_ID');
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
            $grid->model()->where('sysid', '=', $sysid);
        }

        $grid->model()->where('actiontime', '>=', $showtime);
        $grid->model()->orderBy('actiontime', 'desc');

        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableRowSelector();
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
        // $show = new Show(Message::findOrFail($id));
        // $show->field('id', __('Id'));
        // $show->field('message', __('Message'));
        // $show->field('actiontime', __('ActionTime'));


        // return $show;

        $grid = new Grid(new Message());
        $showtime=date("Y-m-d",strtotime("-6 day"));
        // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('message', 'message');
            $filter->like('sysid', 'SYS_ID');
            $filter->like('svrid', 'SVR_ID');
            $filter->like('subsysid', 'SUB_SYS_ID');
            $filter->like('cmpid', 'CMP_ID');
            $filter->like('actiontime', 'ActionTime');
            // ...

        });
        // 第一列显示id字段，并将这一列设置为可排序列
        $grid->column('id', 'ID')->sortable();
        // 显示JSON内嵌字段
        $grid->column('message', 'Message')->display(function ($message) {
            return $this->message;
        })->width(900);
        $grid->column('sysid', 'SYS_ID');
        $grid->column('svrid', 'SVR_ID');
        $grid->column('subsysid', 'SUB_SYS_ID');
        $grid->column('cmpid', 'CMP_ID');
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
            $grid->model()->where('sysid', '=', $sysid);
        }
        $grid->model()->where('actiontime', '>=', $showtime);
        $grid->model()->orderBy('actiontime', 'desc');
        // $grid->model()->where('action_info', '!=', "''");
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableRowSelector();
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Message());
        $form->text('message', __('Message'));
        $form->datetime('actiontime', __('ActionTime'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
