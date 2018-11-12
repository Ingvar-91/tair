<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Админ панель</title>

        <!-- Bootstrap -->
        <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
        <!-- NProgress -->
        <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="/css/admin/admin.min.css" rel="stylesheet">
        <link href="/css/admin/custom.css" rel="stylesheet">
        <!-- PNotify -->
        <link href="/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
        <link href="/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
        <link href="/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
        <!-- sweetalert -->
        <link rel="stylesheet" href="/vendors/sweetalert/dist/sweetalert.css">

        @stack('css')

    </head>

    <body data-url="{{url('/')}}" class="nav-md" data-name-page="{{request()->route()->getName()}}">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col menu_fixed">
                    <div class="left_col scroll-view" style="width: 230px;">

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                @if(Helper::getImg(Auth::user()->image, 'avatars')) <img src="{{Helper::getImg(Auth::user()->image, 'avatars')}}" alt="" class="img-circle profile_img">
                                @else <img src="/img/no-image-1x1.jpg" alt="" class="img-circle profile_img">
                                @endif
                            </div>
                            <div class="profile_info">
                                <span>Приветствую,</span>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>{{Auth::user()->email}}</h3>
                                <ul class="nav side-menu">
                                    @if(isset($shopsType))
                                        <li><a><i class="fa fa-clone"></i>Товары магазинов <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu products-type-sidebar">
                                                @foreach ($shopsType as $val)
                                                    <!--<li><a href="{{Route('admin.products.form', ['shop_type' => $val->id])}}">{{$val->title}}</a></li>-->
                                                @endforeach
                                                <li><a href="{{Route('admin.products.form', ['shop_type' => 1])}}">Одежда</a></li>
                                            </ul>
                                        </li>

                                        <!--<li><a><i class="fa fa-clone"></i>Фильтры <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                @foreach ($shopsType as $val)
                                                    <li><a href="{{Route('admin.filter.form', ['shop_type' => $val->id])}}">{{$val->title}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>-->
                                    @endif
								
                                    @foreach (config('admin.menu') as $val)
                                        <li>
                                            <a href="{{ url($val['url']) }}">
                                                <i class="fa {{ $val['icon'] }}"></i>{{$val['name']}}
                                            </a>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>

                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav class="" role="navigation">
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        @if(Helper::getImg(Auth::user()->image, 'avatars')) 
                                            <img src="{{Helper::getImg(Auth::user()->image, 'avatars')}}" alt="">
                                        @else 
                                            <img src="/img/no-image-1x1.jpg" alt="">
                                        @endif
                                        {{Auth::user()->name}}
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <!--<li><a href="javascript:;"> Профиль</a></li>
                                        <li><a href="javascript:;">Помощь</a></li>-->
                                        <li><a href="{{url('/')}}"><i class="fa fa-home pull-right"></i> Главная</a></li>
                                        <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Выйти</a></li>
                                    </ul>
                                </li>
                                @if(app('request')->post_id)
                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green">{{$countUnreadMessage}}</span>
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list" role="menu">
                                        @if(count($unreadMessage) > 0)
                                        @foreach($unreadMessage as $unrdMessVal)
                                        <li>
                                            <a href="#">
                                                <span>
                                                    <span>{{$unrdMessVal->name}}</span>
                                                    <span class="time">{{date("H:i d.m.Y", strtotime($unrdMessVal->created_at))}}</span>
                                                </span>
                                                <span class="message">
                                                    {{str_limit($unrdMessVal->text, 100)}}
                                                </span>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li>
                                            <div class="text-center">
                                                <a href="{{url('admin/feedback/0')}}">
                                                    <strong>Показать все непрочитанные сообщения</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                        @else
                                        <li>Непрочитанных сообщений нет</li>
                                        @endif
                                    </ul>
                                </li>

                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-comments-o"></i>
                                        <span class="badge bg-green">{{$countUnreadComments}}</span>
                                    </a>
                                    <ul class="dropdown-menu list-unstyled msg_list" role="menu">
                                        @if(count($unreadComments) > 0)
                                        @foreach($unreadComments as $unrdCommVal)
                                        <li>
                                            <a href="#">
                                                <span>
                                                    <span></span>
                                                    <span class="time">{{date("H:i d.m.Y", strtotime($unrdCommVal->created_at))}}</span>
                                                </span>
                                                <br/>
                                                <span class="message">
                                                    {{str_limit($unrdCommVal->text, 80)}}
                                                </span>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li>
                                            <div class="text-center">
                                                <a href="{{url('admin/comments')}}">
                                                    <strong>Показать комментарии</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                        @else
                                        <li>Непрочитанных комментариев нет</li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">

                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" id="media-wd" role="dialog" aria-labelledby="">
            <input type="hidden" id="mediafiles-path" value="upload">

            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Медиафайлы</h4>
                    </div>
                    <div class="modal-body">
                        <div id="load-image">
                            <div id="dragandrophandler">
                                <i class="close fa fa-times" id="close-wd-img" aria-hidden="true"></i>
                                <p class="text">Перетащите файлы сюда</p>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <label class="btn btn-default" for="files-multimedia">Выбирите файл</label>
                                    <input type="file" id="files-multimedia" multiple name="mediafile">
                                </form>
                            </div>
                            <br><br>
                            <div id="status1"></div>
                        </div>

                        <div id="media-messages">

                        </div>

                        <div id="multimedia-image">
                            <div class="row">
                                <div class="col-xs-12 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-success back" value="Назад">
                                    </div>
                                    <div class="img"></div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <div class="filename"><b>Имя файла:</b> <span></span></div>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputPassword1">Большое изображение</label> 
                                        <input class="form-control" id="x3-image" type="text"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputPassword1">Среднее изображение</label> 
                                        <input class="form-control" id="x2-image" type="text"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputPassword1">Малое изображение</label> 
                                        <input class="form-control" id="x1-image" type="text"> 
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="loader">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Загрузка...</span>
                        </div>
                        <div id="multimedia"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="loader">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        </div>

        <!-- jQuery -->
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="/vendors/nprogress/nprogress.js"></script>
        <!-- jQuery custom content scroller -->
        <script src="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="/js/admin/admin.min.js"></script>
        <!--<script src="/js/admin/underscore.min.js"></script>-->

        <!-- PNotify -->
        <script src="/vendors/pnotify/dist/pnotify.js"></script>
        <script src="/vendors/pnotify/dist/pnotify.buttons.js"></script>
        <script src="/vendors/pnotify/dist/pnotify.nonblock.js"></script>
        
        <!-- sweetalert -->
        <script src="/vendors/sweetalert/dist/sweetalert.min.js"></script>
        
        <!-- ejs -->
        <script src="/vendors/ejs/ejs.min.js"></script>
              
        @stack('scripts')

        <!-- system -->
        <script src="/js/admin/system.js"></script>
        
        <script>
$(function ($) {
    $('body').on('keypress', 'input', function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    })
});
        </script>
    </body>
</html>