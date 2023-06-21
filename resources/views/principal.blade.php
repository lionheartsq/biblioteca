<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="BIBLIOTECA ESCOLAR">
    <meta name="author" content="BIBLIOTECA ESCOLAR">
    <meta name="keyword" content="BIBLIOTECA ESCOLAR">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>BIBLIOTECA ESCOLAR</title>
    <!-- Icons -->
    <link href="css/simple-line-icons.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app"><!-- /Apertura div app que permite usar vue -->

        <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notificaciones</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="badge badge-danger">
                            @foreach (Auth::user()->roles as $rol)
                                {{$rol['rol']}}
                            @endforeach
                        </span>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <!-- <img src="img/avatars/{{Auth::user()->id}}.jpg" class="img-avatar" alt="{{Auth::user()->email}}"> -->
                    <img src="img/avatars/1.jpg" class="img-avatar" alt="{{Auth::user()->email}}">
                    <span class="d-md-down-none">{{Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                <a class="dropdown-item" @click="menu=98" href="#">
                <i class="fa fa-eye"></i> Vista personalizada</a>

                <a class="dropdown-item" href="{{route('logout')}}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i> Cerrar sesión</a>

                <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none;">
                {{csrf_field()}}
                </form>

            </div>
            </li>
            <li><p>&nbsp;&nbsp;&nbsp;</p></li>
        </ul>
    </header>

    <div class="app-body">

        @foreach (Auth::user()->roles as $rol)

            @if (($rol->id)==1)
                @include('contenido.sidebarsa')
            @elseif (($rol->id)==2)
                @include('contenido.sidebaram')
            @elseif (($rol->id)==3)
                @include('contenido.sidebarus')
            @else
                @include('contenido.sidebarvacio')
            @endif

        @endforeach

        <!-- Contenido Principal -->
        @yield('contenido')
        <!-- /Fin del contenido principal -->
    </div>

    </div><!-- /Cierre div app que permite usar vue -->

    <footer class="app-footer">
        <span><a href="#">SOFTCLASS.CO</a> &copy; 2023</span>
        <span class="ml-auto">Desarrollado por <a href="#">TEAM SOFTCLASS</a></span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/app.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/pace.min.js"></script>
    <script src="js/template.js"></script>
    <script src="js/sweetalert2.all.js"></script>

</body>

</html>
