<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Ошибка 404 | {{config('app.name')}}</title>

        <link href="/img/shortcut_icon.ico" rel="shortcut icon" />

        <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

        <link href="/css/style.min.css?v={{time()}}" rel="stylesheet" />

        <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .flex{
                display: flex;
                height: 100%;
            }

            .flex section{
                flex: 0 0 100%;
                margin: auto;
                
            }
        </style>

    </head>
    <body class="bg-1">

        <div class="container">
            <div class="flex">
                <section class="box box-control p text-center">
                    <div class="alert alert-danger m-0">
                        <h2 class="text">
                            К сожалению такой страницы не существует!
                        </h2>
                        <div>
                            <a href="https://{{config('app.domen')}}" class="link">Перейти на главную</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- jquery -->
        <script src="/vendors/jquery/dist/jquery.min.js"></script>

        <!-- bootstrap -->
        <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>