@extends('layouts.default')

@section('content')
  <div class="jumbotron">
    <h1>Hello MTS</h1>
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>各项目统计</h5>
    </div>
    <div class="card-body">
      @include('shared._chartjs')
    </p>
<!--     <p>
      一切，将从这里开始。
    </p> -->
<!--     <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p> -->
        </div>
  </div>
</div>
  </div>
@stop
