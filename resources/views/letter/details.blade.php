@extends('master')
@section('menu')
    @include('menu')
@stop


@section('content')

<div class="box box-widget">
    <div class="box-header with-border">
        <div class="user-block">

            <span class="username"><a href="#">{{$letter->title}}</a></span>
            <span class="description">منتشر شده در {{$letter->created_at}}</span>
            <span class="description">منتشر شده توسط {{$letter->user->name}}</span>
        </div>
        <!-- /.user-block -->
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="خوانده شده">
                <i class="fa fa-circle-o"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- post text -->
        <p>{{$letter->details}}</p>

    </div>
    <!-- /.box-body -->

    <!-- /.box-footer -->
    <div class="box-footer">
        <a href="{{route('letter.index')}}"><button type="button" class="btn btn-success">بازگشت </button></a>
    </div>
    <!-- /.box-footer -->
</div>

@endsection
