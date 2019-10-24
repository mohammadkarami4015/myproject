@extends('master')
@section('menu')

@endsection

@section('content')
 <tr>
     <td>
         <a href="{{route('user.create')}}"><button  style="margin-right: 90%;" type="button" class="btn btn-success">افزودن کاربر</button></a>
     </td>
 </tr>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>کاربر</th>
                <th>email</th>
                <th>زیرشاخه</th>
                <th>تنظیمات</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->parent['name']}}</td>
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
    </div>


@endsection
