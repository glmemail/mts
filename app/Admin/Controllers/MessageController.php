<?php

namespace App\Admin\Controllers;

use App\Models\Message;
use App\Models\Action_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        // 显示JSON内嵌字段
        $grid->column('message', 'Message');
        // $grid->column('id')->display(function($message_id) {
        //     return Action_info::find($message_id)->code1;
        // });
        $grid->column('actiontime', 'ActionTime');
        // $grid->column('code1', 'code1')->display(function ($action) {
        //     $count = count($action);
        //     return "<span class='label label-warning'>{$count}</span>";
        // });
        $grid->column('Action_info', __('Action'))->expand(function ($model) {
            $action = $model->action()->with(['code1','code2','code3','code4','code5','code6'])->get()->map(function ($action) {
                return [
                    'message_id'=> $action->message_id,
                    'actionType' => $action->actionType,
                    'code' => $action->getRelation('code1')->name.'-'.$address->getRelation('code2')->name.'-'.$address->getRelation('code3')->name.'-'.$address->getRelation('code4')->name.'-'.$address->getRelation('code5')->name.'-'.$address->getRelation('code6')->name,
                    'actiontime' => $action->actiontime
                ];
            });
            return $action->toArray();
        });


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
