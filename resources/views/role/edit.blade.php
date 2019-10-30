@extends('master')
@section('title')
    <title>ویرایش نقش</title>
@endsection

@section('menu')
    @include('menu')
@stop

@section('content')
    <div class="box box-primary">
        <form role="form" method="post" action="{{route('role.update',['id'=>$role->id])}}">
            {{csrf_field()}}
            {{method_field('PATCH')}}
            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">نام</label>
                    <input type="name" name="title" class="form-control" id="exampleInputEmail1" value="{{$role->title}}">
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-group">
                            <label>انتخاب دسترسی</label>
                            @foreach($permissions as $value)
                                <div class="checkbox">
                                    <label>
                                        <input {{in_array(($value->id),$role->permissions->pluck('id')->toArray()) ? 'checked' : ''}} name="permission_id[]" value="{{$value->id}}" type="checkbox">
                                        {{$value->title}}
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
                <a href="{{ URL::previous()}}"><button   type="button" class="btn btn-success">بازگشت </button></a>
            </div>
        </form>
    </div>


@endsection

