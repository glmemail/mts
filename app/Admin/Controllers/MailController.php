<?php

namespace App\Admin\Controllers;

use App\Models\mail_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MailController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\mail_info';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new mail_info());

        $grid->column('id', __('Id'));
        $grid->column('sys_id', __('Sys id'));
        $grid->column('svr_id', __('Svr id'));
        $grid->column('sub_sys_id', __('Sub sys id'));
        $grid->column('cmp_id', __('Cmp id'));
        $grid->column('mail_to', __('Mail to'));
        $grid->column('mail_from', __('Mail from'));
        $grid->column('contact_name', __('Contact name'));
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
        $show = new Show(mail_info::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('sys_id', __('Sys id'));
        $show->field('svr_id', __('Svr id'));
        $show->field('sub_sys_id', __('Sub sys id'));
        $show->field('cmp_id', __('Cmp id'));
        $show->field('mail_to', __('Mail to'));
        $show->field('mail_from', __('Mail from'));
        $show->field('contact_name', __('Contact name'));
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
        $form = new Form(new mail_info());

        $form->text('sys_id', __('Sys id'));
        $form->text('svr_id', __('Svr id'));
        $form->text('sub_sys_id', __('Sub sys id'));
        $form->text('cmp_id', __('Cmp id'));
        $form->text('mail_to', __('Mail to'));
        $form->text('mail_from', __('Mail from'));
        $form->text('contact_name', __('Contact name'));
        $form->datetime('actiontime', __('Actiontime'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
