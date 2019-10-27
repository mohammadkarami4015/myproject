@extends('master')

@section('content')
 <tr>
     <td>
         <a href="{{route('role.create')}}"><button  style="margin-right: 90%;" type="button" class="btn btn-success">افزودن نقش</button></a>
     </td>
 </tr>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>عنوان نقش</th>
                <th>تنظیمات</th>
            </tr>
            @foreach($roles as $role)
                <tr>
                    <td>{{$role->title}}</td>
                    <td>
                        <form onsubmit="return confirm('آیا مایل به حذف این نقش می باشید؟');" method="post"
                              action="{{route('role.destroy',['id'=>$role->id])}}">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <div class="btn-group btn-group-xs">
                                <a href="{{route('role.edit',['id'=>$role->id])}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach


            </tbody></table>
        <div style="margin-right: 40%">
            {{$roles->links()}}

        </div>
    </div>


@endsection
