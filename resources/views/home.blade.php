@extends('master')
@section('menu')
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-right info">
                <p>علیرضا حسینی زاده</p>
                <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="جستجو">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->

    </section>
    <li class=" treeview">
        <a href="#">
            <i class="fa"> کاربران</i>
        </a>

    </li>
@endsection

@section('content')


@endsection
