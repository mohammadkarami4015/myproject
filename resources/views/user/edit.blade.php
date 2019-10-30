@extends('master')
@section('title')
    <title>ویرایش کاربر</title>
@endsection
@section('menu')
    @include('menu')
@stop

@section('content')
    <div class="box box-primary">
        <a href="{{ URL::previous()}}"><button type="button" style="margin-right: 93%; margin-top: 1%" class="btn btn-success">بازگشت </button></a>
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
                <button type="submit" class="btn btn-primary">ویرایش</button>
            </div>
        </form>
    </div>
    <div class="box box-primary">
        <div class="box-body">
             <div class="col-md-12">
                 <div class="form-group">
            <form role="form" method="post" action="{{route('user.updateRole',['id'=>$user->id])}}">
                {{csrf_field()}}
                {{method_field('patch')}}
                <div class="form-group">
                    <label>انتخاب نقش</label>
                    @foreach($roles as $role)
                        <div class="checkbox">
                            <label>
                                <input {{in_array(($role->id),$user->roles->pluck('id')->toArray()) ? 'checked' : ''}} name="role_id[]" value="{{$role->id}}" type="checkbox">
                                {{$role->title}}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">ویرایش</button>

                </div>
            </form>
        </div>
            </div>
        </div>
    </div>


@endsection
