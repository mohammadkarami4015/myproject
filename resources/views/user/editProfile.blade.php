@extends('master')
@section('title')
    <title>ویرایش کاربر</title>
@endsection
@section('menu')
    @include('menu')
@stop

@section('content')
    <div class="box box-primary">
        <a href="{{ URL::previous()}}">
            <button type="button" style="margin-right: 93%; margin-top: 1%" class="btn btn-success">بازگشت</button>
        </a>
        <form role="form" method="post" action="{{route('user.updateProfile',['id'=>$user->id])}}">
            {{csrf_field()}}
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">نام</label>
                    <input type="name" name="name" class="form-control" id="exampleInputEmail1" value="{{$user->name}}">
                </div>

                <div class="col-md-8">
                    <label for="exampleInputEmail1">ایمیل</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                           value="{{$user->email}}">
                </div>
                <div class="col-md-8">
                    <label for="exampleInputPassword1"> رمز عبور قبلی</label>
                    <input name="old_password" type="password" class="form-control" id="exampleInputPassword1"
                           placeholder="رمز عبور قبلی">
                </div>
                <div class="col-md-8">
                    <label for="exampleInputPassword1">رمز عبو جدید</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                           placeholder="رمز عبور جدید">
                </div>
                <div class="col-md-8">
                    <label for="exampleInputPassword1">تکرار رمز عبور جدید</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required autocomplete="new-password">
                </div>
            </div>

            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ویرایش</button>
            </div>
        </form>
    </div>

@endsection
