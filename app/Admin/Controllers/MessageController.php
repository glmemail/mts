<?php

namespace App\Admin\Controllers;

use App\Models\Message;
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
    protected $title = 'App\Models\Message';

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
        $grid->column('message', 'Message');
        $grid->column('actiontime', 'ActionTime');
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
