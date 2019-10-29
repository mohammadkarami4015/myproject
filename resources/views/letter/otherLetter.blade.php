@extends('master')

@section('menu')
    @include('menu')
@stop

@section('content')

    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>عنوان نامه</th>
                <th>نویسنده</th>
                <th>تنظیمات</th>
            </tr>
            @foreach($letters as $letter)
                <tr>
                    <td>{{$letter->title}}</td>
                    <td>{{$letter->user['name']}}</td>
                    <td>
                            <div class="btn-group btn-group-xs">
                                <a href="{{route('letter.show',['id'=>$letter->id])}}" class="btn btn-success">جزییات</a>
                            </div>
                    </td>
                </tr>
                @endforeach


            </tbody></table>
{{--        <div style="margin-right: 40%">--}}
{{--            {{$letters->links()}}--}}
{{--        </div>--}}
    </div>


@endsection
