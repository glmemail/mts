<?php

namespace App\Admin\Controllers;


use App\Models\Action_info;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Grid;

class ChartjsController extends Controller
{
    public function index(Content $content)
    {
//         $gender = $content->select(DB::raw('count(actiontype) as count, actiontype'))
//             ->groupBy('actiontype')->get()->pluck('count', 'actiontype')->toArray();
        $grid = new Grid(new Action_info());
        // $actoninfo = DB::raw('count(actiontype) as count, actiontype');
//             ->groupBy('actiontype')->get()->pluck('count', 'actiontype')->toArray();

        // $result = DB::table("action_info")
        // ->groupBy('actiontype')
        // ->count();

        // $g = $grid->model()->groupBy('actiontype')->get()->pluck('count', 'actiontype')->toArray();

        // $g = $grid->model()->get()->groupBy('actiontype')->toArray();
        $actoninfo = Action_info::select(array('message_id', 'actiontype'))
            // ->where('actiontype', 'WECHAT')
            // ->where('language', 'cn')
            // ->orderBy('id')
            ->get()
            ->groupBy('actiontype')->toArray(); // 可按type分组

//         $g = $content->select(DB::raw('count(actiontype) as count, actiontype'))->get()
//             ->groupBy('actiontype')->get()->pluck('count', 'actiontype');

        $action_count = [count($actoninfo["WECHAT"]), count($actoninfo["MAIL"]), count($actoninfo["PHONE"]), 0, 0, 0];
        return $content
            ->header('Chartjs')

            ->body(new Box('Bar', view('admin.chartjs', compact('action_count'))));
    }
}
