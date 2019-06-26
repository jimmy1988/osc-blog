{{-- {{ Left hand side bar }} --}}

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu text-left" data-widget="tree">

        <!--Create post button-->
        <li class="btn btn-primary text-left bg-pink" id="createPostSidebar">
          <a href="/admin/post/create" class="text-left">
            <i class="fa fa-plus"></i>
            <span>Create Post</span>
          </a>
        </li>
        <li class="active">
          <!--Got back to the main dashboard-->
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i>
            &nbsp;
            <span>Main Dashboard</span>
          </a>
        </li>
        <li>
          <!--Go to media page-->
          <a href="/admin/media"><i class="fas fa-video"></i>
            &nbsp;
            <span>Media</span>
          </a>
        </li>
        <!--Posts dropdown menu-->
        <li class="treeview">
          <a href="#"><i class="fas fa-clipboard-list"></i>
            &nbsp;
            <span>Posts</span>
            <i class="fas fa-chevron-down pull-right icon-align"></i>
          </a>
          <ul class="treeview-menu">
            {{-- {{ All posts link }} --}}
            <li>
              <a href="/admin/posts">
                <i class="fa fa-rss" aria-hidden="true"></i>
                <span>All Posts</span>
              </a>
            </li>
            {{-- <li>
              <a href="/admin/user/posts">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span>My Posts (Active)</span>
              </a>
            </li> --}}
            {{-- <li>
              <a href="/admin/posts/status/1">
                <i class="fa fa-folder" aria-hidden="true"></i>
                <span>Draft Posts</span>
              </a>
            </li>
            <li>
              <a href="/admin/posts/status/3">
                <i class="fas fa-eraser"></i>
                <span>Removed Posts</span>
              </a>
            </li> --}}
          </ul>
        </li>
        {{-- {{ if we have an admin that has ogged in then they can have access to the tags }} --}}
        <?php if($user_details->user_level <= 3){ ?>
          <li>
            <a href="/admin/tags"><i class="fas fa-tag"></i></i>
              &nbsp;
              <span>Tags</span>
            </a>
          </li>
        <?php } ?>

        {{-- {{ if we have an admin user the we can dislay the categories menu item }} --}}
        <?php if($user_details->user_level <= 3){ ?>
          <li>
            <a href="/admin/categories"><i class="fas fa-certificate"></i>
              &nbsp;
              <span>Categories</span>
            </a>
          </li>
        <?php } ?>

        {{-- {{ if we have an admin user we can dislay the users menu }} --}}
        <?php if($user_details->user_level <= 3){?>
          <li class="treeview">
            <a href="#">
              <i class="fas fa-user"></i>
              &nbsp;
              <span>Users</span>
              <i class="fas fa-chevron-down pull-right icon-align"></i>
            </a>
            <ul class="treeview-menu">
              {{-- {{ Add user button }} --}}
              <li>
                <a href="/admin/users/create">
                  <i class="fas fa-user-plus"></i>
                  &nbsp;
                  <span>Add User</span>
                </a>
              </li>
              {{-- {{ All users button }} --}}
              <li>
                <a href="/admin/users">
                  <i class="fas fa-users"></i>
                  &nbsp;
                  <span>All Users</span>
                </a>
              </li>
              {{-- {{ Deleted users button }} --}}
              <li>
                <a href="/admin/users/all/deleted">
                  <i class="fas fa-trash-alt"></i>
                  &nbsp;
                  <span>All Deleted Users</span>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>

        {{-- {{ Menu item in development }} --}}
        <?php if($user_details->user_level <= 1){ ?>
          <li>
            <a href="#">
              <i class="fa fa-line-chart" aria-hidden="true"></i>
              <span>Reporting (In Development)</span>
            </a>
          </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
