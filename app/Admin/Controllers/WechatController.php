<?php

namespace App\Admin\Controllers;

use App\Models\wechat_info;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('Id'));
        $grid->column('sys_id', __('Sys id'));
        $grid->column('svr_id', __('Svr id'));
        $grid->column('sub_sys_id', __('Sub sys id'));
        $grid->column('cmp_id', __('Cmp id'));
        $grid->column('wechat_to', __('Wechat to'));
        $grid->column('qy_id', __('Qy id'));
        $grid->column('qy_secret', __('Qy secret'));
        $grid->column('qy_agent_id', __('Qy agent id'));
        $grid->column('group_flg', __('Group flg'));
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
        $show = new Show(wechat_info::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('sys_id', __('Sys id'));
        $show->field('svr_id', __('Svr id'));
        $show->field('sub_sys_id', __('Sub sys id'));
        $show->field('cmp_id', __('Cmp id'));
        $show->field('wechat_to', __('Wechat to'));
        $show->field('qy_id', __('Qy id'));
        $show->field('qy_secret', __('Qy secret'));
        $show->field('qy_agent_id', __('Qy agent id'));
        $show->field('group_flg', __('Group flg'));
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
