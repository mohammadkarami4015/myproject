@extends('master')
@section('title')
    <title>افزودن نامه</title>
@endsection
@section('menu')
    @include('menu')
@stop


@section('content')
    <div class="box box-primary">
        <form role="form" method="post" action="{{route('letter.store')}}">
            {{csrf_field()}}


            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">عنوان</label>
                    <input type="name" name="title" class="form-control" id="exampleInputEmail1" placeholder="عنوان ">
                </div>

                <div class="col-md-8">
                    <label for="exampleInputEmail1">متن نامه</label>
                    <textarea type="name" rows="20" name="details" class="form-control"
                              id="exampleInputEmail1"></textarea>
                    <br>
                </div>

                <hr>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-group">
                            <label> قابل نمایش برای</label>
                            @foreach($users as $user)
                                <div class="checkbox" style="border-style: ridge; height: 110px ">
                                    <label>

                                        <input name="user_id[]" value="{{$user->id}}" type="checkbox">
                                        {{$user->name}}
                                        @if(($diff = strlen($user->code) - strlen(auth()->user()->code))==4 )
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح اول)</p>
                                        @elseif($diff==8)
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح دوم)</p>
                                        @elseif($diff==12)
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح سوم)</p>
                                        @elseif($diff==16)
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح چهارم)</p>
                                        @elseif($diff==20)
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح پنجم)</p>
                                        @elseif($diff==24)
                                            <p style="margin-right: 500px;">(زیر مجموعه سطح ششم)</p>
                                        @endif
                                        <br>
                                    </label>
                                    <label  style="position: absolute;margin-right: -600px; margin-top: 50px">start</label>
                                        <div style="width: 200px" class="col-md-5">
                                            <input type="text" readonly name="expire_date[{{$user->id}}]"
                                                   class="form-control pull-right tarikh"
                                            >
                                        </div>
                                    <label  style="position: absolute;margin-right: -390px; margin-top: 50px">end</label>
                                        <div style="width: 200px" class="col-md-5">
                                            <input type="text" readonly name="start_date[{{$user->id}}]"
                                                   class="form-control pull-right tarikh"
                                            >
                                        </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">افزودن</button>
                <a href="{{ URL::previous()}}">
                    <button type="button" class="btn btn-success">بازگشت</button>
                </a>
            </div>
        </form>
    </div>
@endsection


