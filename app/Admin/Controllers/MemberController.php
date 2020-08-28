<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use App\Models\Fluentd;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Content;
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
        $grid->column('compid', __('Comp'))->display(function ($compid) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." comp ";
            $sql = $sql." where ";
            $sql = $sql." cmpid ='".$compid."' ";
            $comp_info = DB::select($sql);
            if (count($comp_info) > 0) {
                return $comp_info[0]->cmpname;
            }
            return "";
        });
        // $grid->column('deptid', __('Dept'));
        // $grid->column('tenantid', __('Tenant'));
        $grid->column('tenantid', __('Tenant'))->display(function ($tenantid) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." tenant ";
            $sql = $sql." where ";
            $sql = $sql." id =".$tenantid." ";
            $tenant_info = DB::select($sql);
            if (count($tenant_info) > 0) {
                return $tenant_info[0]->name;
            }
            return "";
        });
        $grid->column('fluentd_key', __('所属Fluentd'))->display(function ($fluentd_key) {

            $sql = "";
            $sql = $sql." select ";
            $sql = $sql." * ";
            $sql = $sql." from ";
            $sql = $sql." fluentd ";
            $sql = $sql." where ";
            $sql = $sql." keyid =".$fluentd_key." ";
            $fluentd_info = DB::select($sql);
            if (count($fluentd_info) > 0) {
                $fluentd_key = $fluentd_info[0]->sysid." ".$fluentd_info[0]->svrid." ".$fluentd_info[0]->subsysid." ".$fluentd_info[0]->cmpid;
                return "<span title='".$fluentd_key."' >".$fluentd_info[0]->keyname."</span>";
            }
            return "";
        });
        $grid->column('mail_addr', __('Mail Addr'));
        $grid->column('phone_number', __('Phone Number'));
        $grid->column('wechat_id', __('Wechat ID'));
        // $grid->column('actiontype', __('Actiontype'));
        // $grid->column('actiontime', __('Actiontime'));
        // $grid->disableCreateButton();
        // $grid->disableActions();
        $grid->disableRowSelector();
        // $grid->header(function ($query) {
        //     $weeks=[];
        //     for ($x=6; $x>=0; $x--) {
        //         $day_str="-".$x." day";
        //         $weeks[]=date("Y-m-d",strtotime($day_str));
        //     }


        //     $msg_count=[];
        //     $msg_count['2020-08-13']['wechat_count']=5;
        //     $msg_count['2020-08-13']['mail_count']=4;
        //     $msg_count['2020-08-13']['phone_count']=1;
        //     $msg_count['2020-08-14']['wechat_count']=10;
        //     $msg_count['2020-08-14']['mail_count']=8;
        //     $msg_count['2020-08-14']['phone_count']=4;
        //     $msg_count['2020-08-15']['wechat_count']=16;
        //     $msg_count['2020-08-15']['mail_count']=20;
        //     $msg_count['2020-08-15']['phone_count']=4;
        //     $msg_count['2020-08-17']['wechat_count']=7;
        //     $msg_count['2020-08-17']['mail_count']=35;
        //     $msg_count['2020-08-17']['phone_count']=28;
        //     $view_json=[];
        //     $view_json[]=[];                        // index=0
        //     $view_json[]=[];              // index=1
        //     $view_json[]=[];                  // index=2
        //     $view_json[]=$weeks;                    // index=3 一周内日期List
        //     $view_json[]=[];                  // index=4
        //     $view_json[]=$msg_count;                // index=5
        //     // var_dump($view_json[3]);
        //     // var_dump($view_json[5]);

        //     $doughnut = view('admin.gender', compact('view_json'));

        //     return new Box('chartjs', $doughnut);
        //     // $content = new Content();
        //     // return $content
        //     // ->header('信息查询')
        //     // ->body(new Box('', view('admin.gender', compact('view_json'))));
        // });
        return $grid;
    }

    public function show($id, Content $content)
    {
        $member = Member::find($id);
        $member_json = json_decode($member,true);
        var_dump($member_json);
        $weeks=[];
        for ($x=6; $x>=0; $x--) {
            $day_str="-".$x." day";
            $weeks[]=date("Y-m-d",strtotime($day_str));
        }
        $name=$member_json['name'];
        $tenantid=$member_json['tenantid'];
        $fluentd_key=$member_json['fluentd_key'];
        $mail_addr=$member_json['mail_addr'];
        $phone_number=$member_json['phone_number'];
        $wechat_id=$member_json['wechat_id'];
        $compid=$member_json['compid'];
        $deptid=$member_json['deptid'];
        $created_at=$member_json['created_at'];
        $updated_at=$member_json['updated_at'];




        // $sql = "";
        // $sql = $sql." select ";
        // $sql = $sql." * ";
        // $sql = $sql." from ";
        // $sql = $sql." mail_info mi ";
        // $sql = $sql." where ";
        // $sql = $sql." mi.actiontime > '".$showtime."' ";
        // $sql = $sql." and mi.sys_id in ( '".$sel_fluentd[0]->sysid."' )";
        // $sql = $sql." and mi.svr_id in ( '".$sel_fluentd[0]->svrid."' )";
        // $sql = $sql." and mi.sub_sys_id in ( '".$sel_fluentd[0]->subsysid."' )";
        // $sql = $sql." and mi.cmp_id in ( '".$sel_fluentd[0]->cmpid."' )";
        // $sql = $sql." order by actiontime desc";
        // $mail_all = DB::select($sql);


        $msg_count=[];
        $msg_count['2020-08-20']['wechat_count']=5;
        $msg_count['2020-08-20']['mail_count']=4;
        $msg_count['2020-08-20']['phone_count']=1;
        $msg_count['2020-08-21']['wechat_count']=10;
        $msg_count['2020-08-21']['mail_count']=8;
        $msg_count['2020-08-21']['phone_count']=4;
        $msg_count['2020-08-22']['wechat_count']=16;
        $msg_count['2020-08-22']['mail_count']=20;
        $msg_count['2020-08-22']['phone_count']=4;
        $msg_count['2020-08-24']['wechat_count']=7;
        $msg_count['2020-08-24']['mail_count']=35;
        $msg_count['2020-08-24']['phone_count']=28;
        $view_json=[];
        $view_json[]=[];                        // index=0
        $view_json[]=[];              // index=1
        $view_json[]=[];                  // index=2
        $view_json[]=$weeks;                    // index=3 一周内日期List
        $view_json[]=[];                  // index=4
        $view_json[]=$msg_count;                // index=5
        // var_dump($member->toArray());
        // return $content->title('详情')
        //     ->description('简介')
        //     ->view('admin.member.show', $member->toArray(), compact('view_json'));
        return $content
            ->header('详情')
            ->body(new Box('', view('admin.gender', $member->toArray(), compact('view_json'))));
            // ->view('admin.member.show', $member->toArray());



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
        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." t.name, ";
        $sql = $sql." t.id, ";
        $sql = $sql." tu.user_id ";
        $sql = $sql." from ";
        $sql = $sql." public.tenant_user tu ";
        $sql = $sql." inner join ";
        $sql = $sql." tenant t ";
        $sql = $sql." on ";
        $sql = $sql." t.id = tu.tenant_id ";
        $sql = $sql." where ";
        $sql = $sql." tu.user_id ='".$user['username']."' ";
        $tenant_info = DB::select($sql);
        $s = [];
        foreach ($tenant_info as $k => $v) {
            $s[$v->id] = $v->name;
            // $s[$k] = 'aaa';
        }
        $form->select('tenantid', __('Tenant'))->options($s);
        // Fluentd
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
        $form->select('fluentd_key', __('Fluentd'))->options($s);

        $sql = "";
        $sql = $sql." select ";
        $sql = $sql." * ";
        $sql = $sql." from ";
        $sql = $sql." public.comp ";
        $comp_info = DB::select($sql);
        $s = [];
        foreach ($comp_info as $k => $v) {
            $s[$v->cmpid] = $v->cmpname;
        }
        $form->select('compid', __('Comp'))->options($s);
        // $form->text('deptid', __('Dept'));
        $form->email('mail_addr', __('Email'));
        $form->mobile('phone_number', __('Phone'));
        $form->text('wechat_id', __('Wechat'));
        // $sql="select * from fluentd "." where fluentd.keyid = ".$fluentd_id;
        // $sel_fluentd = DB::select($sql);
        // $form->email('email', __('Email'));
        // $form->email('email', __('Email'));
        // $form->email('email', __('Email'));


        // $form->isUpdating();
        // $form->header(function ($query) {
        //     // var_dump($query);
        //     $weeks=[];
        //     for ($x=6; $x>=0; $x--) {
        //         $day_str="-".$x." day";
        //         $weeks[]=date("Y-m-d",strtotime($day_str));
        //     }
        //     $msg_count=[];
        //     $msg_count['2020-08-13']['wechat_count']=5;
        //     $msg_count['2020-08-13']['mail_count']=4;
        //     $msg_count['2020-08-13']['phone_count']=1;
        //     $msg_count['2020-08-14']['wechat_count']=10;
        //     $msg_count['2020-08-14']['mail_count']=8;
        //     $msg_count['2020-08-14']['phone_count']=4;
        //     $msg_count['2020-08-15']['wechat_count']=16;
        //     $msg_count['2020-08-15']['mail_count']=20;
        //     $msg_count['2020-08-15']['phone_count']=4;
        //     $msg_count['2020-08-17']['wechat_count']=7;
        //     $msg_count['2020-08-17']['mail_count']=35;
        //     $msg_count['2020-08-17']['phone_count']=28;
        //     $view_json=[];
        //     $view_json[]=[];                        // index=0
        //     $view_json[]=[];              // index=1
        //     $view_json[]=[];                  // index=2
        //     $view_json[]=$weeks;                    // index=3 一周内日期List
        //     $view_json[]=[];                  // index=4
        //     $view_json[]=$msg_count;                // index=5
        //     // var_dump($view_json[3]);
        //     // var_dump($view_json[5]);

        //     $doughnut = view('admin.gender', compact('view_json'));

        //     return new Box('chartjs', $doughnut);
        //     // return "<div style='padding: 10px;'>总收入 ： 12123131313123</div>";
        //     // $content = new Content();
        //     // return $content
        //     // ->header('信息查询')
        //     // ->body(new Box('', view('admin.gender', compact('view_json'))));
        // });
        // 两个时间显示
        $form->display('created_at', __('创建时间'));
        $form->display('updated_at', __('修改时间'));

        // $form->isCreating();
        return $form;
    }
}
