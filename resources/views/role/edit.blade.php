@extends('master')
@section('menu')

@endsection

@section('content')
    <div class="box box-primary">
        <form role="form" method="post" action="{{route('user.update',['id'=>$user->id])}}">
            {{csrf_field()}}
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">نام</label>
                    <input type="name" name="name" class="form-control" id="exampleInputEmail1" value="{{$user->name}}">
                </div>

                <div class="col-md-8">
                    <label for="exampleInputEmail1">زیر مجموعه</label>
                    <select  type="text" class="form-control " name="parent_id" >
                        {{$users = \App\User::all()}}
                        <option value=""></option>
                        @foreach($users as $value)

                            <option  {{$value->id == $user->parent_id    ?'selected':''}} value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8">
                    <label for="exampleInputEmail1">ایمیل</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" value="{{$user->email}}">
                </div>
                <div class="col-md-8">
                    <label for="exampleInputPassword1">رمز عبور</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="رمز عبور">
                </div>
                <div class="col-md-8">
                    <label for="exampleInputPassword1">تکرار رمز عبور</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ارسال</button>
                <a href="{{route('user.index')}}"><button   type="button" class="btn btn-success">بازگشت </button></a>
            </div>
        </form>
    </div>


@endsection
