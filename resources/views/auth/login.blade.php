@extends('master')

@section('content')


<div class="login-box-body col-md-6 " style="margin-right: 25%">
    <p class="login-box-msg">فرم زیر را تکمیل کنید و ورود بزنید</p>

    <form  method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group has-feedback ">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="ایمیل">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمز عبور">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __(' مرا به خاطر بسپار') }}
                        </label>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <!-- /.social-auth-links -->
    @if (Route::has('password.request'))
      <a href="{{ route('password.request') }}">رمز عبورم را فراموش کرده ام.</a><br>
    @endif
</div>
@endsection
