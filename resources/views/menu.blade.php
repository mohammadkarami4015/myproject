<ul class="sidebar-menu tree" data-widget="tree">
    <li class="header">منو</li>
    <li class="active">
        <a href="{{route('user.index')}}">
            <span>مدیریت کاربران</span>
        </a>

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
            <li class="active"><a href="{{route('letter.index')}}"><i class="fa fa-circle-o"></i> نامه های من</a></li>
            <li class="active"><a href="{{route('letter.child')}}"><i class="fa fa-circle-o"></i> نامه های زیر مجموعه</a></li>
            <li><a href="{{route('letter.access')}}"><i class="fa fa-circle-o"></i>سایر نامه ها</a></li>
        </ul>
    </li>


</ul>
