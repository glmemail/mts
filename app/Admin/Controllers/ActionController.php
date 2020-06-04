<?php

namespace App\Admin\Controllers;

use App\Models\action_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\action_info';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new action_info());

        // $grid->column('message_id', __('Message id'));
        $grid->column('message_id', "消息ID");
        $grid->column('code1', __('Code1'));
        $grid->column('code2', __('Code2'));
        $grid->column('code3', __('Code3'));
        $grid->column('code4', __('Code4'));
        $grid->column('code5', __('Code5'));
        $grid->column('code6', __('Code6'));
        $grid->column('actiontype', __('Actiontype'));
        $grid->column('actiontime', __('Actiontime'));

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
        $show = new Show(action_info::findOrFail($id));

        $show->field('message_id', __('Message id'));
        $show->field('code1', __('Code1'));
        $show->field('code2', __('Code2'));
        $show->field('code3', __('Code3'));
        $show->field('code4', __('Code4'));
        $show->field('code5', __('Code5'));
        $show->field('code6', __('Code6'));
        $show->field('actiontype', __('Actiontype'));
        $show->field('actiontime', __('Actiontime'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new action_info());

        $form->text('message_id', __('Message id'));
        $form->text('code1', __('Code1'));
        $form->text('code2', __('Code2'));
        $form->text('code3', __('Code3'));
        $form->text('code4', __('Code4'));
        $form->text('code5', __('Code5'));
        $form->text('code6', __('Code6'));
        $form->text('actiontype', __('Actiontype'));
        $form->datetime('actiontime', __('Actiontime'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
