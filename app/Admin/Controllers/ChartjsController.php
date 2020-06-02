<?php

namespace App\Admin\Controllers;


use App\Models\action_info;
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
        return $content
            ->header('Chartjs')
            ->body(new Box('Bar chart', view('admin.chartjs')));
        $grid = new Grid(new action_info());
//         $grid->header(function ($query) {
//         $gender = $query->select(DB::raw('count(sex) as count, sex'))
//         ->groupBy('sex')->get()->pluck('count', 'sex')->toArray();
//         $doughnut = view('admin.chart.gender', compact('gender'));

//         return new Box('性别比例', $doughnut);

// });
    }
}
