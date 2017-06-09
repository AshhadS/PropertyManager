<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>IDSS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap data tables -->
        <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="/bower_components/admin-lte/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />


        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset("/css/custom.css")}}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        
    </head>
    <body class="skin-blue">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo"><b>IDSS</b></a>
            

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a> -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset("/bower_components/admin-lte/dist/img/idss-defualt.png") }}" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Sentinel::getUser()->email }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <a href="/" class="logo">Property Management</a>
             <nav class="navbar navbar-static-top" role="navigation">
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="/admin"> <i class="fa fa-home" aria-hidden="true"></i> Home</a></li>                     
                        <li><a href="/rentalowners"> <i class="fa fa-user-secret" aria-hidden="true"></i> Property Owner</a></li>                
                        <li><a href="/props"> <i class="fa fa-building" aria-hidden="true"></i> Properties</a></li>
                        <li><a href="/units"> <i class="fa fa-university" aria-hidden="true"></i> Units</a></li>
                        <li><a href="/tenants"> <i class="fa fa-users" aria-hidden="true"></i> Tenants</a></li>                     
                        <li><a href="/users"> <i class="fa fa-user" aria-hidden="true"></i> Users</a></li>                     
                        <li><a href="#"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Reports</a></li>                     
                        <li><a href="/logout">Logout <i class="fa fa-sign-out" aria-hidden="true"></i> </a></li>                     
                    </ul>
                </div>
            </nav>
        </header>
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- <section class="content-header">
                <h1>Page Header</h1>
            </section> -->
                <!-- <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                </ol> -->

            <!-- Main content -->
            <section class="content">

                <!-- Your Page Content Here -->

                <div class="buttons container-fluid">
                    <div class="row">
                        <div class="col-md-2"><a href="/dashboard"><button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</button></a></div>
                        <div class="col-md-2"><a href="/jobcards"><button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-book" aria-hidden="true"></i> Job Cards</button></a></div>
                        <div class="col-md-2"><a href="/props"><button type="button" class="btn btn-primary btn-lg btn-block"> <i class="fa fa-building" aria-hidden="true"></i> Properties</button></a></div>
                        <div class="col-md-2"><a href="/units"><button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-university" aria-hidden="true"></i> Units</button></a></div>
                        <!-- <div class="col-md-2"><a href="/tenants"><button type="button" class="btn btn-primary btn-lg btn-block">Tenants</button></a></div> -->
                        <div class="col-md-2"><a href="/todo"><button type="button" class="btn btn-primary btn-lg btn-block"> <i class="fa fa-tasks" aria-hidden="true"></i> To Do</button></a></div>
                        <div class="col-md-2"><a href="/agreement"><button type="button" class="btn btn-primary btn-lg btn-block"> <i class="fa fa-file-text" aria-hidden="true"></i> Create Agreement</button></a></div>
                    </div>
                </div>
                <br/>
                
                @yield('content')

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright © 2015 <a href="#">IDSS</a>.</strong> All rights reserved.
        </footer>

    </div><!-- ./wrapper -->

    


    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.3 -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>

        <!-- Bootstrap Datatables -->
        <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

        <!-- Date Picker -->
        <script src="/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js"></script>
        
        <!-- Custom Tables -->
        <script src="{{ asset ("/js/custom.js") }}"></script>

        @stack('scripts')
    </body>
</html>