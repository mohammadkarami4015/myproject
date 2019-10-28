<ul class="sidebar-menu tree" data-widget="tree">
    <li class="header">منو</li>
    <li class="active treeview menu-info">
        <a href="">
            <i class="fa fa-dashboard"></i> <span>مدیریت کاربران</span>
            <span class="pull-left-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
        </a>
        <ul class="treeview-menu" style="">
            <li class="active"><a href="{{route('user.index')}}"><i class="fa fa-circle-o"></i>همه کاربران</a></li>
            <li class="active"><a href="{{route('user.child')}}"><i class="fa fa-circle-o"></i>کاربران زیر مجموعه</a></li>
        </ul>
    </li>
    <li class="active">
        <a href="{{route('role.index')}}">
            <span>مدیریت نقش ها</span>
        </a>

    </li>

    <li class="active treeview menu-open">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>مدیریت نامه ها</span>
            <span class="pull-left-container">
              <i class="fa fa-angle-right pull-left"></i>
            </span>
        </a>
        <ul class="treeview-menu" style="">
            <li class="active"><a href="{{route('letter.index')}}"><i class="fa fa-circle-o"></i>همه نامه ها</a></li>
            <li class="active"><a href="{{route('letter.myIndex')}}"><i class="fa fa-circle-o"></i> نامه های من</a></li>
            <li class="active"><a href="{{route('letter.child')}}"><i class="fa fa-circle-o"></i> نامه های زیر مجموعه</a></li>
            <li><a href="{{route('letter.access')}}"><i class="fa fa-circle-o"></i>سایر نامه ها</a></li>
        </ul>
    </li>


</ul>
