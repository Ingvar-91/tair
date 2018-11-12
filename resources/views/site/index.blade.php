<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Cache-Control -->
    <!-- <meta http-equiv="Cache-Control" content="no-cache" /> -->
    <!-- Cache-Control -->
	
	<meta name="author" content="Гронский Игорь">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if (trim($__env->yieldContent('title'))) @yield('title') | @endif {{config('app.words_title')}}</title>
    
    <link href="/img/shortcut_icon.ico" rel="shortcut icon" />
    
    <link href="/css/style.min.css?v=118" rel="stylesheet" />
    
    @stack('css')
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-98599640-4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-98599640-4');
    </script>
    
</head>

<body class="bg-1">
    <div id="wrap">
        <div class="switch-bg" id="switch-bg">
            <div class="switch-bg-button" id="switch-bg-button"> <i class="fa fa-cog fa-2x"></i> </div>
            <ul class="list-unstyled">
                <li class="bg bg-1 active" data-bg="bg-1"></li>
                <li class="bg bg-2" data-bg="bg-2"></li>
                <li class="bg bg-3" data-bg="bg-3"></li>
                <li class="bg bg-4" data-bg="bg-4"></li>
                <li class="bg bg-5" data-bg="bg-5"></li>
                <li class="bg bg-6" data-bg="bg-6"></li>
                <li class="bg bg-7" data-bg="bg-7"></li>
                <li class="bg bg-8" data-bg="bg-8"></li>
                <li class="bg bg-9" data-bg="bg-9"></li>
                <li class="bg bg-10" data-bg="bg-10"></li>
            </ul>
        </div>
        <aside id="sitebar-user">
            <div class="sidebar-close-button" id="sidebar-close-user">
                <img src="/fonts/cross-out.svg" alt="" role="button"/>
            </div>
            <div class="content">
                @if(Auth::check())
                    <div class="user-profile p-lg">
                        <div class="profile-avatar text-center m-sm-t">
                            @if(Helper::getImg(Auth::user()->image, 'avatars'))
                                <img class="img-circle" src="{{Helper::getImg(Auth::user()->image, 'avatars')}}" width="128" height="128" alt=""/>
                            @else
                                <img class="img-circle" src="/img/no-image-1x1.jpg" width="128" height="128" alt=""/>
                            @endif 
                        </div>
                        <div class="profile-info text-center m-lg-t">
                            <h3 class="font-weight-thin">{{Auth::user()->email}}</h3>
                            <hr class="w-25">
                            <p>г. Караганда, ул. Космонавтов 1B
                            <br>+7 (7212) 43-70-14 </p>
                        </div>
                        <div class="profile-menu list-group m-t">
                            @if(Auth::check() and (Auth::user()->role >= 5))
                            <a href="{{Route('admin.orders.form')}}" class="list-group-item"> <i class="fa fa-list-alt fa-lg fa-fw text-secondary"></i>Админ панель</a>
                            @endif
                            @if(Auth::check() and (Auth::user()->role == 3))
                            <a href="{{Route('vendor.shops.form')}}" class="list-group-item"> <i class="fa fa-shopping-bag fa-lg fa-fw text-secondary"></i>Мои магазины</a>
                            @endif
                            <a href="{{Route('profile')}}" class="list-group-item"> <i class="fa fa-user fa-lg fa-fw text-secondary"></i>Личный кабинет</a>
                                
                            <a href="{{Route('current-orders')}}" class="list-group-item"> <i class="fa fa-shopping-cart fa-lg fa-fw text-secondary"></i>Текущие заказы</a>
                            <a href="{{Route('orders')}}" class="list-group-item"> <i class="fa fa-file-text-o fa-lg fa-fw text-secondary"></i>История заказов</a>
                            <a href="{{Route('logout')}}" class="list-group-item"> <i class="fa fa-sign-out fa-lg fa-fw text-secondary"></i>Выйти</a>
                        </div>
                    </div>
                @else
                    <div class="user-login p-lg">
                        <div class="create-account-icon text-center"> <i class="fa fa-lock" aria-hidden="true"></i> </div>
                        <p class="lead text-center">Пожалуйста, войдите</p>
                        <hr class="w-25">
                        <form role="form" method="POST" action="{{ url('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group ">
                                <label class="hide">Электронная почта</label>
                                <input class="form-control form-white" name="email" type="email" placeholder="Введите электронную почту"/> 

                            </div>
                            <div class="form-group ">
                                <label class="hide">Пароль</label>
                                <input class="form-control form-white" name="password" type="password" placeholder="Введите пароль"/> 

                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить </label>
                                    <a class="float-right link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-blue btn-lg btn-block" type="submit">Войти</button>
                            </div>
                            <div class="form-group text-center"> <a href="#" id="create-account">Создать аккаунт</a> </div>
                        </form>
                    </div>

                    <div class="user-create-account p-lg hide">
                        <div class="create-account-icon text-center"> <i class="fa fa-lock" aria-hidden="true"></i> </div>
                        <p class="lead text-center">Пожалуйста, создайте аккаунт</p>
                        <hr class="w-25">
                        <form class="create-account-form" method="POST" action="{{ url('register') }}">
                            {{ csrf_field() }}
                            <div class="form-group ">
                                <label class="hide" for="createAccountFormEmail">Электронная почта</label>
                                <input class="form-control form-white" name="email" type="email" required id="createAccountFormEmail" placeholder="Введите электронную почту"/> 

                            </div>
                            <div class="form-group">
                                <label class="hide" for="createAccountFormPassword">Пароль</label>
                                <input class="form-control form-white" name="password" type="password" required id="createAccountFormPassword" placeholder="Введите пароль"/> 

                            </div>
                            <div class="form-group">
                                <label class="hide" for="createAccountFormRepeatPassword">Повтор пароля</label>
                                <input class="form-control form-white" name="password_confirmation" type="password" required id="regFormShowUserProfile" placeholder="Повторите пароль"/>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-blue btn-lg btn-block" type="submit">Создать аккаунт</button>
                            </div>
                            <div class="form-group text-center"> <a href="#" id="login">Войти</a> </div>
                        </form>
                    </div>
                @endif
            </div>
        </aside>
        <div class="overlay"></div>
        <aside id="sitebar">
            <div class="sidebar-close-button" id="sidebar-close-nav">
                <img src="/fonts/cross-out.svg" alt="" role="button"/>
            </div>
            <nav class="navigation">
                <div class="search form-group">
                    <form action="{{Route('search')}}">
                        <button class="btn btn-link" type="submit"><i class="fa fa-search fa-lg fa-fw"></i></button>
                        <input type="search" name="search" class="form-control" placeholder="Поиск..." />
                        <button class="btn btn-link" type="reset"><i class="fa fa-times-circle fa-lg fa-fw"></i></button>
                    </form>
                </div>
                <ul class="list-unstyled nav-pills">
                    <li><a class="@if(request()->is('/')) active @endif" href="{{Route('home')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Главная"><i class="fa fa-home fa-lg fa-fw"></i></a></li>
                    <li><a href="/plan.html" target="_blank" title="Карта" data-toggle="tooltip" data-placement="top" data-original-title="Карта"><i class="fa fa-location-arrow fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('delivery')) active @endif" href="{{Route('delivery')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Доставка"><i class="fa fa-truck fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('about')) active @endif" href="{{Route('about')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="О ТГ «Таир»"><i class="fa fa-info fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('contacts')) active @endif" href="{{Route('contacts')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Контакты"><i class="fa fa-envelope fa-lg fa-fw"></i></a></li>
                    <li><a href="/3d-tour.html" target="_blank" title="" data-toggle="tooltip" data-placement="top" data-original-title="3D-тур"><i class="fa fa-street-view fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('photo')) active @endif" href="{{Route('photo')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Фотогалерея"><i class="fa fa-picture-o fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('video')) active @endif" href="{{Route('video')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Видеогалерея"><i class="fa fa-film fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('rules')) active @endif" href="{{Route('rules')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Политика конфиденциальности"><i class="fa fa-exclamation-triangle fa-lg fa-fw"></i></a></li>
                    <li><a class="@if(request()->is('faq')) active @endif" href="{{Route('faq')}}" title="" data-toggle="tooltip" data-placement="top" data-original-title="Пользовательское соглашение"><i class="fa fa-life-ring fa-lg fa-fw"></i></a></li>                   
                </ul>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Категории</a></li>
                    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" style="margin-right: 0;">Арендаторы</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        @if(empty($product_categories) == false)
                            <div class="categories">
                                <ul class="nav-items">
                                    @foreach($product_categories as $categoryVal)
                                    <li> 
                                        @if(isset($categoryVal->child)) 
                                            <a href="#" class="toggle-cat">{{$categoryVal->title}} <small>({{$categoryVal->count}})</small>  <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                            @include('/site/categories', ['child' => $categoryVal->child])
                                        @else
                                            <a href="{{Route('products', ['category_id' => $categoryVal->id])}}">{{$categoryVal->title}} <small>({{$categoryVal->count}})</small> </a>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        @if(count($shops))
                            <ul class="shops nav-items">
                                @foreach($shops as $val)
                                    @if($val->placeholder)
                                        <li><a href="http://{{$val->placeholder.'.'.config('app.domain')}}">{{$val->title}} @if($val->count)<small>({{$val->count}})</small>@endif</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <div>
                                <h4>Нет данных</h4>
                            </div>
                        @endif
                    </div>
                </div>
				<div class="app-link-img">
					<a href="https://play.google.com/store/apps/details?id=shop.tair.app.release">
						<img src="/img/google-play.png" alt="google play"/>
					</a>
					<a href="https://itunes.apple.com/kz/app/%D1%82%D0%B0%D0%B8%D1%80/id1441092380?mt=8">
						<img src="/img/app-store.png" alt="app store"/>
					</a>
				</div>
            </nav>
        </aside>
        <div class="overlay"></div>
        <div id="mfp-cart" class="white-popup popup-mfp mfp-with-anim mfp-extra-large mfp-hide">
            <h3 class="m-0">Корзина заказов</h3>
            <section id="cart">
                <div class="loader text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <div class="m-sm-t">Загрузка...</div>
                </div>
                <div class="list hide">
                    
                </div>
            </section>
        </div>
        <div id="container">
            <div id="sidebar-static">
                <div class="case-static">
                    <ul class="social list-unstyled m-0">
						<li>
                            <a class="nav-link bg-android" href="https://play.google.com/store/apps/details?id=shop.tair.app.release" target="_blank" title="Android приложение"> <i class="fa fa-android fa-lg"></i> </a>
                        </li>
						<li>
                            <a class="nav-link bg-apple" href="https://itunes.apple.com/kz/app/%D1%82%D0%B0%D0%B8%D1%80/id1441092380?mt=8" target="_blank" title="Apple приложение"> <i class="fa fa-apple fa-lg"></i> </a>
                        </li>
						<li>
                            <hr/>
                        </li>
                        <li>
                            <a class="nav-link bg-instagram" href="https://www.instagram.com/tair.karaganda/" target="_blank" title="Мы в Instagram"> <i class="fa fa-instagram fa-lg"></i> </a>
                        </li>
                        <li>
                            <a class="nav-link bg-telegram" href="https://t.me/tair_karaganda" target="_blank" title="Мы в Telegram"> <i class="fa fa-telegram fa-lg"></i> </a>
                        </li>
                        <li>
                            <a class="nav-link bg-vk" href="https://vk.com/tair.shop" target="_blank" title="Мы в Контакте"> <i class="fa fa-vk fa-lg"></i> </a>
                        </li>
                        <li>
                            <a class="nav-link bg-odnoklassniki" href="http://ok.ru/tairkaraganda" target="_blank" title="Мы в Одноклассники"> <i class="fa fa-odnoklassniki fa-lg"></i> </a>
                        </li>
                        <li>
                            <a class="nav-link bg-facebook" href="https://www.facebook.com/groups/1486136335012115/" target="_blank" title="Мы в Facebook"> <i class="fa fa-facebook fa-lg"></i> </a>
                        </li>
                        <li>
                            <a class="nav-link bg-youtube mr-0" href="https://www.youtube.com/channel/UCSID0Loao_aRUuQqY69CFHw?annotation_id=54e28bd3-0000-2bec-92cb-001a1142f4ec&amp;feature=iv&amp;src_vid=giFrQd-fcdI" target="_blank" title="Мы в Youtube"> <i class="fa fa-youtube fa-lg"></i> </a>
                        </li>
                    </ul>
                    
                    <div>
                        <button id="back-top" class="btn btn-action" type="button" title="Наверх"> <i class="fa fa-arrow-up fa-lg"></i> </button>
                    </div>
                </div>
            </div>
            <div>
                <header id="header">
                    <div class="head">
                        <div>
                            <button class="btn btn-action text-left" type="button" id="btn-sidebar"> <span></span> <span></span> <span></span> </button>
                            <a href="{{Route('home')}}" id="brand">
                                <img src="/img/logo/logo_a_white.png" alt=""/>
                            </a>
                        </div>
                        <div class="text-right">
                            <button type="button" id="btn-user-profile" class="btn btn-action" title="Профиль"> <i class="fa fa-user-o" aria-hidden="true"></i> </button>
                            <a href="{{Route('wishlists')}}" id="btn-wishlists" class="btn btn-action" title="Избранное"> <span class="badge badge-blue">{{$wishlistCount}}</span> <i class="fa fa-heart-o" aria-hidden="true"></i> </a>
                            <a href="#mfp-cart" data-effect="mfp-zoom-in" type="button" id="btn-cart" class="btn btn-action open-popup-mfp" title="Корзина заказов"> <span class="badge badge-orange">{{$cartCount}}</span> <i class="fa fa-shopping-cart" aria-hidden="true"></i> </a>
                        </div>
                        <div class="text-center">
                            <div id="header-contacts" class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" data-swiper-autoplay="5000">
                                        <div class="icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
                                        <div class="contact"> 
                                            <a class="h3 text-secondary open-popup-mfp" href="#contact-numbers" data-effect="mfp-zoom-in">Контактные номера </a> 
                                        </div>
                                    </div>
                                    <div class="swiper-slide" data-swiper-autoplay="5000">
                                        <div class="icon"> <i class="fa fa-envelope-o" aria-hidden="true"></i> </div>
                                        <div class="contact"> <a class="h3 text-secondary" href="mailto:{{config('app.contacts.emailTair')}}">{{config('app.contacts.emailTair')}}</a> </div>
                                    </div>
                                    <div class="swiper-slide" data-swiper-autoplay="5000">
                                        <div class="icon"> <i class="fa fa-map-marker" aria-hidden="true"></i> </div>
                                        <div class="contact"> <a class="text-secondary" href="{{Route('contacts')}}">г. Караганда,<br>ул. Космонавтов 1B</a> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-logo text-center">
                        <a href="{{Route('home')}}" id="brand-mobile">
                            <img src="/img/logo/logo_a_white.png" alt=""/>
                        </a>
                    </div>
                    
                    <div id="contact-numbers" class="white-popup popup-mfp mfp-with-anim mfp-small mfp-hide" style="max-width: 406px;">
                        <h3 class="m-0"><i class="fa fa-phone m-sm-r" aria-hidden="true"></i> Контактные номера</h3>
                        <hr>
                        
                        @foreach(config('app.contacts.wdContacts') as $contact)
                            <div class="item">
                                <div class="col">
                                    <div>
                                        @if(Helper::getImg($contact['logo'], 'logo'))
                                            <img class="img-responsive w-100" src="{{Helper::getImg($contact['logo'], 'logo')}}" alt=""/>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-center">
                                        <div class="h4 m-t-0">
                                            {{$contact['title']}}
                                       </div>
                                       <div>
                                            @foreach($contact['phones'] as $phones)
                                                <a href="tel:{{$phones}}" class="h4">{{$phones}}</a>
                                            @endforeach
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endforeach
                        
                    </div>
                </header>
                <main id="main">
                    <div class="case">
                        
                        <div id="content">
                            @yield('content')
                        </div>
                        <div id="preloader">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        </div>
                        
                    </div>
                </main>
            </div>
        </div>
        <footer id="footer">
            <div class="container">
                <div class="wrap">
					<div class="row">
						<div class="col-xs-12 col-sm-6 text-left">
							<div id="logo-krg">
								<img class="img-responsive" src="/img/logo_krg_alpha.png"/>
							</div>
							<span> &#169; {{date('Y')}} <a class="text-light" href="{{Route('home')}}">ТГ «Таир»</a> </span>
						</div>
						<div class="col-xs-12 col-sm-6 text-right">
						
							<!--LiveInternet counter-->
							<script type="text/javascript">
							document.write("<a href='//www.liveinternet.ru/click' "+
							"target=_blank><img src='//counter.yadro.ru/hit?t14.11;r"+
							escape(document.referrer)+((typeof(screen)=="undefined")?"":
							";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
							screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
							";h"+escape(document.title.substring(0,150))+";"+Math.random()+
							"' alt='' title='LiveInternet: показано число просмотров за 24"+
							" часа, посетителей за 24 часа и за сегодня' "+
							"border='0' width='88' height='31'><\/a>")
							</script>
							<!--/LiveInternet-->
							
							<!-- ZERO.kz -->
							<span id="_zero_70870">
							<noscript>
							<a href="http://zero.kz/?s=70870" target="_blank">
							<img src="http://c.zero.kz/z.png?u=70870" width="88" height="31" alt="ZERO.kz" />
							</a>
							</noscript>
							</span>
							<!--/ZERO.kz -->
							
							<!-- Yandex.Metrika informer -->
								<a href="https://metrika.yandex.ru/stat/?id=48849761&amp;from=informer"
								target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/48849761/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"
								style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="48849761" data-lang="ru" /></a>
								<!-- /Yandex.Metrika informer -->

								<!-- Yandex.Metrika counter -->
								<script type="text/javascript" >
									(function (d, w, c) {
										(w[c] = w[c] || []).push(function() {
											try {
												w.yaCounter48849761 = new Ya.Metrika({
													id:48849761,
													clickmap:true,
													trackLinks:true,
													accurateTrackBounce:true
												});
											} catch(e) { }
										});

										var n = d.getElementsByTagName("script")[0],
											s = d.createElement("script"),
											f = function () { n.parentNode.insertBefore(s, n); };
										s.type = "text/javascript";
										s.async = true;
										s.src = "https://mc.yandex.ru/metrika/watch.js";

										if (w.opera == "[object Opera]") {
											d.addEventListener("DOMContentLoaded", f, false);
										} else { f(); }
									})(document, window, "yandex_metrika_callbacks");
								</script>
								<noscript><div><img src="https://mc.yandex.ru/watch/48849761" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
							<!-- /Yandex.Metrika counter -->

							<!--<span>
								<a class="text-light" href="{{Route('about')}}">О ТГ «Таир»</a> · 
								<a class="text-light" href="{{Route('rules')}}">Правила</a> · 
								<a class="text-light" href="{{Route('contacts')}}">Контакты</a>
							</span>--> 
						</div>
					</div>
                </div>
            </div>
        </footer>
        
        @if( request()->is('shop/*') or request()->is('product/*') or request()->is('order/*'))
            <div id="call-float">
                @if(isset($mainPhoneShop) and $mainPhoneShop)
                    <div class="item phone" data-toggle="tooltip" data-placement="top" data-original-title="Позвонить продавцу">
                        <a href="tel:{{$mainPhoneShop}}"> <i class="fa fa-phone" aria-hidden="true"></i> </a>
                    </div>
                @endif
                @if(isset($linkWhatsappShop) and $linkWhatsappShop)
                    <div class="item whatsapp" data-toggle="tooltip" data-placement="top" data-original-title="Написать в WhatsApp продавцу"> 
                        <a href="{{$linkWhatsappShop}}"> <i class="fa fa-whatsapp" aria-hidden="true"></i> </a> 
                    </div>
                @endif 
            </div>
        @elseif(request()->is('shops') or request()->is('shops/edit') or request()->is('shops/edit'))
            <div id="call-float">
                <div class="item open-wd-shops" data-toggle="tooltip" data-placement="top" data-original-title="Показать магазины"> 
                    <a href="#wd-my-shops" id="wd-my-shops-btn" class="open-popup-mfp" data-effect="mfp-zoom-in"> 
                        <span class="icon"></span>
                    </a>
                </div>
            </div>
        @elseif(request()->is('products-vendor/edit') or request()->is('products-vendor') or request()->is('products-vendor/add'))
            <div id="call-float">
                <div class="item open-wd-shops" data-toggle="tooltip" data-placement="top" data-original-title="Показать магазины"> 
                    <a href="#wd-my-shops" id="wd-my-shops-btn" class="open-popup-mfp" data-effect="mfp-zoom-in"> 
                        <span class="icon"></span>
                    </a>
                </div>
            </div>
        @else
            <div id="call-float">
                <div class="item phone" data-toggle="tooltip" data-placement="top" data-original-title="Позвонить администрации">
                    <a href="tel:{{config('app.contacts.phone')}}"> <i class="fa fa-phone" aria-hidden="true"></i> </a> 
                </div>
                <div class="item whatsapp" data-toggle="tooltip" data-placement="top" data-original-title="Написать в WhatsApp администрации"> 
                    <a href="{{config('app.contacts.whatsapp')}}" target="_blank"> <i class="fa fa-whatsapp" aria-hidden="true"></i> </a> 
                </div>
            </div>
        @endif
        
        <div id="wd-my-shops" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
            <h3 class="m-0">Выберите магазин</h3>
            <hr/>
            
            <div class="list">
                
            </div>
            <div class="loader text-center hide">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            </div>
        </div>
        
    </div>
    
    <div id="loader">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </div>
	
	<!-- ZERO.kz -->
	<script type="text/javascript">
	<!--
		var _zero_kz_ = _zero_kz_ || [];
		_zero_kz_.push(["id", 70870]);
		_zero_kz_.push(["type", 1]);

		(function () {
			var a = document.getElementsByTagName("script")[0],
			s = document.createElement("script");
			s.type = "text/javascript";
			s.async = true;
			s.src = (document.location.protocol == "https:" ? "https:" : "http:")
			+ "//c.zero.kz/z.js";
			a.parentNode.insertBefore(s, a);
		})(); 
	//-->
	</script>
	<!-- End ZERO.kz -->

	
	<script id="ejs-wd-my-shops" type="text/template">
		<% $.each(shops, function(i, shop){ %>
			<div class="item-shop">
				<a href="/products-vendor/add?shop_id=<%= shop.shop_id %>">
					<div class="media">
						<div class="media-left">
							<img class="media-object" style="max-height: 100px;" src="<%= shop.shop_images %>" alt="">
						</div>
						<div class="media-body">
							<h4 class="media-heading">
								<%= shop.title %>
							</h4>
							<div>
								<%= shop.short_description.slice(0, 80) %>
							</div>
						</div>
					</div>
				</a>
			</div>
			<hr/>
		<% }); %>
	</script>
    
    <script id="card-list" type="text/template">
        <% $.each(productsShops, function(i, shop){ %>
            <div class="shop">
                <hr/>
                <div class="shop-name">
					<% if(shop.logo){ %>
						<img src="<%= shop.logo %>" alt="" /> 
					<% } %>
					<a href="/shop/<%= shop.shop_id %>" class="h3"><%= shop.title %></a> 
				</div>
				
				<div class="min-price-message <% if(shop.min_price <= shop.total){ %> hide <% } %>">
					<noindex>
						<div class="alert alert-danger" role="alert">
							Минимальная сумма заказа для магазина <strong><%= shop.title %></strong> составляет <strong class="min_price"><%= shop.min_price.toLocaleString() %></strong> ₸
							<br/>
							У вас <strong class="total"><%= shop.total.toLocaleString() %></strong> ₸ Закажите ещё что-нибудь.
						</div>
					</noindex>
				</div>
				
				<% if(shop.products.length){ %>
					<% $.each(shop.products, function(j, product){ %>
						<div class="cart-item">
							<div>
								<div class="img-product"> 
									<img src="<%= product.preview %>" alt="" class="img-cart"> 
								</div>
							</div>
							<div>
								<div class="title">
									<div> <a href="/product/<%= product.id %>" class="text-bold"><%= product.title %></a> </div>
									<div class="text-grey"> Цена за единицу: <%= product.price.toLocaleString() %> ₸ </div>
								</div>
							</div>
							<% if(product.del == 1){ %>
								<div>
									<div class="count">
										<label>Количество шт:</label>
										<div class="input-group"> <span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number btn-1" data-type="minus" data-field="quant[<%= i+j %>]">
												<span class="glyphicon glyphicon-minus"></span> 
											</button>
											</span>
											<input type="text" name="quant[<%= i+j %>]" class="form-control input-number" data-total="<%= shop.total %>" data-min_price="<%= shop.min_price %>" data-id="<%= product.id %>" data-old-price="<%= product.oldPrice %>" data-price="<%= product.price %>" value="<%= cookieCart[product.id].count %>" min="1" max="999999"> <span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number btn-2" data-type="plus" data-field="quant[<%= i+j %>]">
												<span class="glyphicon glyphicon-plus"></span> 
											</button>
											</span>
										</div>
									</div>
								</div>
								<div>
									<div class="price"> Сумма
										<% if(product.oldPrice){ %>
											<div class="text-strike old-price" style="font-size: 1.2rem;"><span><%= (product.oldPrice * cookieCart[product.id].count).toLocaleString() %></span> ₸</div>
										<% } %>
										<div class="text-bold current-price"><span><%= (product.price * cookieCart[product.id].count).toLocaleString() %></span> ₸</div>
									</div>
								</div>
							<% } %>
							
							<% if(product.del == 2){ %>
								<div>
									Данный товар отсутствует, для более подробной информации обратитесь к <a class="link" href="/shop/<%= product.shop_id %>">продавцу</a>.
								</div>
								<div>
									
								</div>
							<% } %>
							<div>
								<div class="icon-close remove-cart" data-id="<%= product.id %>" role="button" title="Удалить из корзины"> <img src="/fonts/cross-out.svg" alt="" role="button" /> </div>
							</div>
						</div>
					<% }); %>
				<% } %>
                
                <hr class="m-lg-t" />
                <div class="row">
                    <div class="col-md-3 col-md-offset-9">
                        <div class="total">
                            <div class="h5 m-0">Всего:</div>
                            <div class="price"><span><%= shop.total.toLocaleString() %></span> ₸</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-6">
                        <button class="btn-cart btn btn-outline-blue btn-lg mfp-close-custom" type="button">Продолжить покупки</button>
                    </div>
                    <div class="col-md-3">
                        <a href="/order/<%= shop.shop_id %>" class="btn-cart btn <% if(shop.min_price <= shop.total){ %> btn-orange <% }else{ %> btn-secondary disable-link <% } %> btn-order btn-lg" type="button" style="color: #fff;">Оформить заказ</a>
                    </div>
                </div>
            </div>
        <% }); %>
    </script>
	
	<!-- vendors -->
	<script src="/js/vendors.min.js"></script>
	
    <!-- main -->
    <script src="/js/site/main.js"></script>
    
    <!-- products -->
    <script src="/js/site/products.js"></script>
    
	
    @stack('scripts')
    
	<script src="/js/scripts.min.js?v={{time()}}"></script>
	
</body>

</html>
