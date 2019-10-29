@extends('master')
@section('title')
    <title>لیست کاربران</title>
@endsection

@section('menu')
    @include('menu')
@stop

@section('content')
    <a href="{{route('user.create')}}"><button type="button" class="btn btn-success">افزودن کاربر</button></a>

    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>کاربر</th>
                <th>email</th>
                <th>سطح</th>
                <th>زیرمجموعه</th>
                <th>نقش</th>
                <th>تنظیمات</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if(($diff = strlen($user->code) - strlen(auth()->user()->code))==4 )
                            <p >اول </p>
                        @endif
                        @if($diff==8)
                            <p >دوم</p>
                        @endif
                        @if($diff==12)
                            <p >سوم</p>
                        @endif
                        @if($diff==16)
                            <p >چهارم</p>
                        @endif
                        @if($diff==20)
                            <p >پنجم</p>
                        @endif
                        @if($diff==24)
                            <p >ششم</p>
                        @endif
                    </td>
                    <td>{{$user->parent['name']}}</td>
                    <td>
                        @foreach($user->roles as $role)
                            {{$role->title}} ،
                            @endforeach
                    </td>
                    <td>
                        <form onsubmit="return confirm('آیا مایل به حذف این کاربر می باشید؟');" method="post"
                              action="{{route('user.destroy',['id'=>$user->id])}}">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <div class="btn-group btn-group-xs">
                                <a href="{{route('user.edit',['id'=>$user->id])}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach


            </tbody></table>
        <div style="margin-right: 40%">
            {{$users->links()}}
        </div>
    </div>


@endsection
