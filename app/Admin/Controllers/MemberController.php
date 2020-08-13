<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use App\Models\Fluentd;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use DB;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Member';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Member());
        $grid->column('id', "ID");
        $grid->column('name', __('Name'));
        $grid->column('compid', __('Comp'));
        $grid->column('deptid', __('Dept'));
        $grid->column('userid', __('管理者'));
        // $grid->column('fluentd_key', __('所属Fluentd'));
        $grid->column('mail_addr', __('Mail Addr'));
        $grid->column('phone_number', __('Phone Number'));
        $grid->column('wechat_id', __('Wechat ID'));
        // $grid->column('actiontype', __('Actiontype'));
        // $grid->column('actiontime', __('Actiontime'));
        // $grid->disableCreateButton();
        // $grid->disableActions();
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
        $show = new Show(Member::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Member());
        $user = Auth::guard('admin')->user();
        $form->text('name', __('Name'));
        $form->text('compid', __('Comp'));
        $form->text('deptid', __('Dept'));
        $form->email('mail_addr', __('Email'));
        $form->mobile('phone_number', __('Phone'));
        $form->text('wechat_id', __('Wechat'));
        // $sql="select * from fluentd "." where fluentd.keyid = ".$fluentd_id;
        // $sel_fluentd = DB::select($sql);
        $fluentd = Fluentd::select(array('fluentd.keyid','fluentd.keyname','fluentd.sysid', 'fluentd.svrid', 'fluentd.subsysid', 'fluentd.cmpid','user_fluentd.user_id'))
            ->join('user_fluentd','fluentd.keyid','=','user_fluentd.fluentd_keyid')
            ->where('user_fluentd.user_id', $user['username'])
            ->get()
            ->groupBy('keyid');
        $fluentd_json = json_decode($fluentd,true);
        $s = [];
        foreach ($fluentd_json as $k => $v) {
            $s[$k] = $v[0]['sysid'] ." ". $v[0]['svrid'] ." ". $v[0]['subsysid'] ." ". $v[0]['cmpid'];
        }
        // var_dump($s);
        $form->select('fluentd_key', __('Fluentd'))->options($s);
        // $form->email('email', __('Email'));
        // $form->email('email', __('Email'));
        // $form->email('email', __('Email'));

        $form->isCreating();
        $form->isUpdating();
        return $form;
    }
}
