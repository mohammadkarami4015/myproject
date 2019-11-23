@extends('master')
@section('title')
    <title>سایر نامه ها</title>
@endsection

@section('menu')
    @include('menu')
@stop

@section('content')

    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody><tr>
                <th>عنوان نامه</th>
                <th>توضیحات</th>
                <th>نویسنده</th>
                <th>زمان دسترسی</th>
            </tr>
            @foreach($letters as $letter)
                <tr>
                    <td>{{$letter->title}}</td>
                    <td>{{$letter->details}}</td>
                    <td>{{$letter->user['name']}}</td>
                    <td>

                    </td>
                </tr>
                @endforeach


            </tbody></table>
{{--        <div style="margin-right: 40%">--}}
{{--            {{$letters->links()}}--}}
{{--        </div>--}}
    </div>


@endsection
