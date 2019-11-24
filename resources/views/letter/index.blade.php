@extends('master')
@section('title')
    <title>لیست نامه ها</title>
@endsection

@section('menu')
    @include('menu')
@stop

@section('content')

    <a href="{{route('letter.create')}}"><button  type="button" class="btn btn-success">افزودن نامه</button></a>

    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>عنوان نامه</th>
                <th>متن نامه</th>
                <th>نویسنده</th>
                <th>تنظیمات</th>
            </tr>
            @foreach($letters as $letter)
                <tr>
                    <td>{{$letter->title}}</td>
                    <td>{{$letter->details}}</td>
                    <td>{{$letter->user['name']}}</td>
                    <td>
                        <form onsubmit="return confirm('آیا مایل به حذف این نقش می باشید؟');" method="post"
                              action="{{route('letter.destroy',['id'=>$letter->id])}}">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <div class="btn-group btn-group-xs">
{{--                                <a href="{{route('letter.show',['id'=>$letter->id])}}" class="btn btn-success">جزییات</a>--}}
                                <a href="{{route('letter.edit',['id'=>$letter->id])}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach


            </tbody></table>
{{--        <div style="margin-right: 40%">--}}
{{--            {{$letters->links()}}--}}
{{--        </div>--}}
    </div>


@endsection
