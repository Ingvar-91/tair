<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
</head>

<body>
    <table cellpadding="0" cellspacing="0" style="background-color: #f5f8fa; width: 100%; box-sizing: border-box; border;text-align: center;font-family: Arial,Tahoma,Helvetica,'Liberation Sans',sans-serif;">
        <tbody>
            <tr style="height: 70px; text-align: center;">
                <td style="border-bottom: 1px solid #eee;"> 
                    <a href="http://tair.shop" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #bbbfc3;font-size: 19px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;" target="_blank" rel=" noopener noreferrer">
                        {{config('app.name')}}
                    </a> 
                </td>
            </tr>
            <tr>
                <td style="background-color: #fff;">
                    <table style="width: 100%; text-align: center;padding: 25px 0; max-width: 800px; margin: 0 auto;">
                        <tbody>
                            
                            <tr>
                                <td style=" padding-bottom: 15px;">
                                    <h3 style="color:#444;"> Спасибо что зарегистрировались на сайте {{$nameSite}}</h3>
                                    <p>Ваш e-mail {{$email}}</p>
                                    <p>Ваш пароль {{$password}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding-bottom: 5px;">
                                    <h3 style="color:#444; padding-top: 5px;">Полезная информация</h3>
                                    <p>Теперь вы можете <a href="{{Route('profile')}}" style="color: #0AE;">зайти</a> на свою страницу профиля, для просмотра или редактирования контактных данных.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3 style="margin-bottom: 10px; color:#444;padding-top: 15px;">Полезные ссылки:</h3> <span><a href="{{Route('home')}}" style="color: #0AE;">Главная</a></span> | <span><a href="{{Route('faq')}}" style="color: #0AE;">Помощь</a></span> | <span><a href="{{Route('profile')}}" style="color: #0AE;">Мой профиль</a></span> | <span><a href="{{Route('contacts')}}" style="color: #0AE;">Контакты</a></span> </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="height: 70px; text-align: center;">
                <td style="border-top: 1px solid #eee;">
                    <p style="box-sizing: border-box;line-height: 1.5em;color: #AEAEAE;font-size: 12px;">© {{date('Y')}} {{config('app.name')}}</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>