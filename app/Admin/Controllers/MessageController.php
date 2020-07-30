<?php

namespace App\Admin\Controllers;

use App\Models\Message;
use App\Models\Action_info;
use App\Models\Fluentd;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

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
        // 第一列显示id字段，并将这一列设置为可排序列
        $grid->column('id', 'ID')->sortable();
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
        // 显示JSON内嵌字段
        $grid->column('message', 'Message')->display(function ($message) {
            // $msg =  json_decode ($this->message,true);
            // $json = json_encode($msg,true);
            return $this->message;
            // return "<span class='label label-warning'>{$action}</span>";
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
            $grid->model()->Orwhere('sysid', '=', $sysid);
        }
        // $grid->model()->where('id', '=', 825543);

        $grid->disableCreateButton();
        $grid->disableActions();
        // var_dump($grid);
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
        $show = new Show(Message::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('message', __('Message'));
        $show->field('actiontime', __('ActionTime'));


        return $show;
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
