@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('content')

<nav class="box box-control">
    {!! Breadcrumbs::render('about') !!}
</nav>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Торговый  Город «ТАИР»</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="row custom-row">
                <div class="col-md-6 m-b">
                    <div class="b-r overflow-hidden box box-shadow">
                        <img src="/img/about/_DSC4660.jpg" alt="" class="img-responsive"/>
                    </div>
                </div>
                <div class="col-md-6 m-b">
                    <div class="b-r overflow-hidden box box-shadow">
                        <img src="/img/about/_DSC4663.jpg" alt="" class="img-responsive"/>
                    </div>
                </div>
                <div class="col-md-6 m-b">
                    <div class="b-r overflow-hidden box box-shadow">
                        <img src="/img/about/_DSC4679.jpg" alt="" class="img-responsive"/>
                    </div>
                </div>
                <div class="col-md-6 m-b">
                    <div class="b-r overflow-hidden box box-shadow">
                        <img src="/img/about/_DSC4704.jpg" alt="" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p>
                <b>Торговый город «ТАИР»</b> - это семейноразвлекательный торговый центр, ориентированный на массового покупателя со средним и ниже среднего уровнем дохода.
            </p>
            <hr>
            <p>
                На сегодняшний день, общая площадь Торгового Города «ТАИР» составляет <b>70 000 квадратных метров</b>. Что делает его самым крупнейшим  ТРЦ в  г. Караганде.
            </p>
            <hr>
            <p>
                Площадь магазинов составляет <b>38 000 квадратных метров</b>. Оригинальными составляющими в <b>торговом городе «ТАИР»</b> являются: детский развлекательный центр <b>«Safari Park»</b>, фастфуд зоны, аттракционы.
            </p>
        </div>
    </div>

    <div class="m-lg-t">
        <p>
            <span class="h1">Т</span>орговый город «ТАИР» расположен настолько удобно, что его показатели сравнимы с расположением вблизи станций метро в городах столичного масштаба. Это поток потенциальных покупателей от 40 000 в будний день, более 3000 автомобилей каждый час проезжающих вдоль главного входа в торговый город.
        </p>

        <p>
            <span class="h1">А</span>втобусная остановка расположена непосредственно перед центральным входом в торговый город. Именно через «ТАИР» по главному проспекту города проходит 26 маршрутов общественного транспорта. За час перед центральным фасадом останавливается более 200 автобусов.
        </p>

        <p>
            <span class="h1">И</span>сторически сложилось, что данный квадрат является самым насыщенным торговым местом в городе. Концентрация торговых предприятий различного класса и профиля, расположенных на данной территории, создает оборот более 140 млн. долларов в месяц.
        </p>

        <p>
            <span class="h1">Р</span>еальным преимуществом торгово-развлекательного комплекса является расположение точно в центре между двумя большими спальными районами «Город» и «Юго-Восток», в которых проживает наиболее платежеспособная часть населения города.
        </p>
    </div>     
</section>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Крупные сети магазинов в торговом городе «ТАИР» </h2>
    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4386.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Супермаркет «Южный»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4377.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Супермаркет детских товаров «Еркемай»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4385.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Супермаркет посуды «Luminarc»</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4371.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Дисконт-центр «O’stin»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4378.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Дисконт-центр «Спортмастер»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4375.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Дисконт-центр «Adidas & Reebok»</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4381.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин средиземноморской одежды «DeFacto»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4383.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин бытовой техники «Sulpak»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4384.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин цифровой техники «Alser»</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4373.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин обуви «Юничел»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4430.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин обуви «Kari»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4432.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин обуви «FLO» </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4760.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«ADA Textile»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4763.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«Центр правильного сна»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4765.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Супермаркет детских товаров «Кенгуру»</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4764.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин одежды «KOTON»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4767.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин одежды «LC Waikiki»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4769.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>Магазин одежды «УниверMAG.kz»</h4>
            </div>
        </div>
    </div>
</section>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Фастфуд зоны в торговом городе «ТАИР»</h2>
    <div class="row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4388.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«PALERMO PIZZA»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4410.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«CHICAGO»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4407.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«CANTEEN»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4390.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«KCC»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/papapizza.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«PaPaPIZZA»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4401.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«ANKARA»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4414.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«SALEM CHICK»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/мост.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«МОСТ»</h4>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/usta_kebab.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="text-center">
                <h4>«USTA KEBAS’S»</h4>
            </div>
        </div>
    </div>
</section>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Safari Park</h2>

    <p class="text-center m-b">
        Зоны отдыха и развлечений в торговом городе «ТАИР» центр семейного отдыха.
    </p>

    <div class="row custom-row">
        <div class="col-md-8 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4397.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r m-sm-b overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4399.jpg" alt="" class="img-responsive"/>
            </div>
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4395.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
    </div>

    <div class="row custom-row">
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4421.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4423.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4419.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
    </div>

</section>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Кинотеатр «Sary Arka cinema»</h2>

    <p class="text-center m-b">
        Также, в середине 2017 года открылся 4-х зальный кинотеатр, вместимостью <b>232 человека</b> и площадью <b>1 410 квадратных метров</b>.
    </p>

    <div class="row">
        <div class="col-md-12 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/34634734746344534645.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC6858.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC6863.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-4 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC6865.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
    </div>

</section>

<section class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Парковка</h2>
    <div class="row">
        <div class="col-md-12 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/parjing.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-6 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4688.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
        <div class="col-md-6 m-b">
            <div class="b-r overflow-hidden box box-shadow">
                <img src="/img/about/_DSC4694.jpg" alt="" class="img-responsive"/>
            </div>
        </div>
    </div>
</section>

@stop