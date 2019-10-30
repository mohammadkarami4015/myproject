@extends('master')
@section('title')
    <title>افزودن نقش</title>
@endsection

@section('menu')
    @include('menu')
@stop

@section('content')
    <div class="box box-primary">
        <form role="form" method="post" action="{{route('role.store')}}">
            {{csrf_field()}}
            <div class="box-body">
                <div class="col-md-8">
                    <label for="exampleInputEmail1">نام</label>
                    <input type="name" name="title" class="form-control" id="exampleInputEmail1" placeholder="عنوان نقش">
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <div class="form-group">
                            <label>انتخاب دسترسی</label>
                            @foreach($permissions as $permission)
                                <div class="checkbox">
                                    <label>
                                        <input name="permission_id[]" value="{{$permission->id}}" type="checkbox">
                                       {{$permission->title}}
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
