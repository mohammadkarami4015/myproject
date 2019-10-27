@extends('master')
@section('menu')

@endsection

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
                    <textarea type="name" rows="20" name="details" class="form-control" id="exampleInputEmail1" ></textarea>
                    <br>
                </div>

                <hr>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-group">
                            <label> قابل نمایش برای</label>
                            @foreach($users as $user)
                                <div class="checkbox"  style="border-style: ridge">
                                    <label>
                                        <input name="user_id[]" value="{{$user->id}}" type="checkbox">
                                        {{$user->name}}
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


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">افزودن</button>
                <a href="{{route('letter.index')}}"><button   type="button" class="btn btn-success">بازگشت </button></a>
            </div>
        </form>
    </div>


@endsection
