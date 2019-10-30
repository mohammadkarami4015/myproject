@extends('master')

@section('title')
    <title>ویرایش نامه</title>
@endsection
@section('menu')
    @include('menu')
@stop


@section('content')
    <div class="box box-primary">
        <form role="form" method="post" action="{{route('letter.update',['id'=>$letter->id])}}">
            {{csrf_field()}}
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">عنوان</label>
                    <input type="name" name="title" class="form-control" id="exampleInputEmail1" value="{{$letter->title}}">
                </div>

                <div class="col-md-8">
                    <label for="exampleInputEmail1">متن نامه</label>
                    <textarea type="name" rows="20" name="details" class="form-control" id="exampleInputEmail1" >{{$letter->details}}</textarea>
                </div>

                <hr>
                <div class="col-md-8">
                    <div class="form-group">

                            <label> قابل نمایش برای</label>
                            @foreach($users as $user)
                                <div class="checkbox"  style="border-style: ridge">
                                    <label>
                                        <input {{in_array(($user->id),$letter->users->pluck('id')->toArray()) ? 'checked' : ''}} name="user_id[]" value="{{$user->id}}" type="checkbox">
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
                                        <label>  به مدت  </label>
                                        <select class="form-control" name="exp_time[{{$user->id}}]" id="">
                                            <option value="">نامحدود</option>
                                            <option value="1">یک ساعت</option>
                                            <option value="5">پنج ساعت</option>
                                            <option value="24">یک روز</option>
                                        </select>

                                    </label>
                                </div>
                            @endforeach
                        </div>

                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ویرایش</button>
                <a href="{{ URL::previous()}}"><button   type="button" class="btn btn-success">بازگشت </button></a>
            </div>
        </form>
    </div>

@endsection

