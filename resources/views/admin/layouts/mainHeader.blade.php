  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!--<span class="logo-mini"><b>N</b>cms</span> -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>管理后台</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="/imgs/avatar/u1.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{auth()->user()->nickname}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="/imgs/avatar/u1.jpg" class="img-circle" alt="User Image">

                <p>
                  {{auth()->user()->name}} - 系统管理员
                  <small>最后登录:{{date('Y-m-d H:i',strtotime(auth()->user()->updated_at))}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/admin/user/{{auth()->user()->id}}/edit" class="btn btn-default btn-flat">编辑详情</a>
                </div>
                <div class="pull-right">
                  <a href="/admin/logout" class="btn btn-default btn-flat">登出</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
