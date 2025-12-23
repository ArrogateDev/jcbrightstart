<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<style>
    @font-face {
        font-family: 'iconfont';  /* Project id 5094721 */
        src: url('//at.alicdn.com/t/c/font_5094721_7f48db2ppu6.woff2?t=1766384383609') format('woff2'),
        url('//at.alicdn.com/t/c/font_5094721_7f48db2ppu6.woff?t=1766384383609') format('woff'),
        url('//at.alicdn.com/t/c/font_5094721_7f48db2ppu6.ttf?t=1766384383609') format('truetype');
    }

    .iconfont {
        font-family: "iconfont" !important;
        font-size: 16px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        line-height: normal;
    }

    .icon-location:before {
        content: "\e7e6";
    }

    .au-tag-lists {
        height: 155px;
        flex: 155px 0 0;
        overflow: auto;
    }

    .au-tag__item.active {
        color: #fff;
        background: #ff97a4;
    }

    .location-lists {
        overflow: auto;
    }

    .location-item {
        display: flex;
        border: 1px solid #0000001a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 8px;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
    }

    .location-item:hover {
        color: #fff;
        background: #ff97a4;
        border: 1px solid #ff97a41a;
    }

    .location-item:hover .location-title {
        color: #fff;
    }

    .location-title {
        font-weight: 600;
        font-size: 17px;
    }

    .location-info {
        font-size: 13px;
        line-height: normal;
        padding-left: 2px;
    }
</style>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('香港0-3歲嬰幼兒服務資訊')}}" subtitle="{{__('香港0-3歲嬰幼兒服務資訊')}}"/>

        <section class="section p-t-125">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 p-1">
                        <div id="map-location" class="w-100">
                            <div class="page-sidebar h-100 p-sm-b-70">
                                <div class="widget h-100 d-flex flex-column">
                                    <div class="section-heading section-heading-1 section-heading-1--tiny2 text-left">
                                        <h2 class="section-heading__title">Map</h2>
                                        <div class="section-heading__line">
                                            <img src="{{web_resource_url('assets/web/images/icon/line-blue-tiny.png')}}" alt="Line">
                                        </div>
                                        <div class="m-b-25"></div>
                                    </div>
                                    <div class="au-tag-lists">
                                        <a class="au-tag__item active" href="javascript:void(0);" data-type="all">All</a>
                                        @foreach($types as $type)
                                            <a class="au-tag__item" href="javascript:void(0);" data-type="{{$type}}">{{$type}}</a>
                                        @endforeach
                                    </div>
                                    <div class="location-lists overflow-auto">
                                        @foreach($maps as $map)
                                            <div class="location-item" data-type="{{$map['Age of Child (Age range)']}}">
                                                <i class="iconfont icon-location"></i>
                                                <div class="ml-2">
                                                    <h5 class="title title--black location-title">
                                                        {{$map['Organization']}}
                                                    </h5>
                                                    @if(isset($map['Type of Child Care Centers']) && !empty($map['Type of Child Care Centers']))
                                                        <p class="location-info">Type: {{$map['Type of Child Care Centers']}}</p>
                                                    @endif
                                                    @if(isset($map['Age of Child (Age range)']) && !empty($map['Age of Child (Age range)']))
                                                        <p class="location-info">Age range:{{$map['Age of Child (Age range)']}}</p>
                                                    @endif
                                                    @if(isset($map['District']) && !empty($map['District']))
                                                        <p class="location-info">District: {{$map['District']}}</p>
                                                    @endif
                                                    @if(isset($map['Capacity']) && !empty($map['Capacity']))
                                                        <p class="location-info">Capacity: {{$map['Capacity']}}</p>
                                                    @endif
                                                    @if(isset($map['Contact']['Address']) && !empty($map['Contact']['Address']))
                                                        <p class="location-info">Address: {{$map['Contact']['Address']}}</p>
                                                    @endif
                                                    @if(isset($map['Contact']['Phone no.']) && !empty($map['Contact']['Phone no.']))
                                                        <p class="location-info">Phone no.: {{$map['Contact']['Phone no.']}}</p>
                                                    @endif
                                                    @if(isset($map['Contact']['Email']) && !empty($map['Contact']['Email']))
                                                        <p class="location-info">Email: {{$map['Contact']['Email']}}</p>
                                                    @endif
                                                    @if(isset($map['Contact']['Webpage']) && !empty($map['Contact']['Webpage']))
                                                        <p class="location-info">Webpage: {{$map['Contact']['Webpage']}}</p>
                                                    @endif
                                                    @if(isset($map['Service Hour']) && !empty($map['Service Hour']))
                                                        <p class="location-info">Service Hour: {{$map['Service Hour']}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 p-1">
                        <div id="map-box" class="w-100">
                            <div id="map" class="w-100 h-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-web.footer/>

</div>

<!-- Jquery JS-->
<script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap JS-->
<script src="{{web_resource_url('assets/web/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
<!-- Vendor JS-->
<script src="{{web_resource_url('assets/web/vendor/animsition/animsition.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/slick/slick.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/lightbox2/js/lightbox.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/wow/wow.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/isotope/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/matchHeight/jquery.matchHeight-min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/select2/select2.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/noUiSlider/nouislider.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/modalVideo/modal-video.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<!--
| (Load Extensions only on Local File Systems !
| The following part can be removed on Server for On Demand Loading)
-->
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<!-- Config Revolution Slider-->
<script type="text/javascript" src="{{web_resource_url('assets/web/js/config-revolution.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/js/theme-map.min.js')}}"></script>

<!-- Main JS-->
<script src="{{web_resource_url('assets/web/js/global.js')}}"></script>

<link href="{{web_resource_url('assets/web/vendor/open-layers/css/ol.css')}}" rel="stylesheet">
<script src="{{web_resource_url('assets/web/vendor/open-layers/ol.js')}}"></script>
<script>
    function adjustMapHeight() {
        const header = document.getElementById('header');
        const headerHeight = header ? header.offsetHeight : 0;

        const mapHeight = window.innerHeight - headerHeight;

        const mapLocation = document.getElementById('map-location');
        const map = document.getElementById('map-box');

        if (mapLocation) {
            mapLocation.style.height = mapHeight + 'px';
        }

        if (map) {
            map.style.height = mapHeight + 'px';
        }

    }

    document.addEventListener('DOMContentLoaded', function () {
        adjustMapHeight();
    });

    window.addEventListener('resize', function () {
        adjustMapHeight();
    });
</script>

<script type="module">
    $(function () {
        let markerData = [];
        @foreach($maps as $map)
        markerData.push({
            id: '{{$map['Age of Child (Age range)']}}',
            coordinates: [{{$map['Longitude']}}, {{$map['Latitude']}}],
            title: '{{$map['Organization']}}'
        });
        @endforeach

        let markers = new ol.layer.Vector({
            source: new ol.source.Vector(),
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    src: '{{web_resource_url('assets/img/location-marker.png')}}',
                    anchor: [0.5, 1],
                    scale: 0.1
                })
            })
        });

        const layers = [
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://mapapi.geodata.gov.hk/gs/api/v1.0.0/xyz/basemap/wgs84/{z}/{x}/{y}.png'
                })
            }),
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://mapapi.geodata.gov.hk/gs/api/v1.0.0/xyz/label/hk/tc/wgs84/{z}/{x}/{y}.png'
                })
            })
        ];

        const map = new ol.Map({
            layers: [...layers, markers],
            target: document.getElementById('map'),
            view: new ol.View({
                projection: 'EPSG:4326',
                center: [114.180000000, 22.292000000],
                maxZoom: 19,
                zoom: 13,
                dragAndDrop: false,
                extent: [113.8, 22.1, 114.5, 22.6]
            }),
            controls: []
        });

        function updateMarkers(type) {
            const source = markers.getSource();
            source.clear();

            const filteredMarkers = markerData.filter(marker =>
                type === 'all' || marker.id === type
            );

            const features = filteredMarkers.map(marker =>
                new ol.Feature({
                    geometry: new ol.geom.Point(marker.coordinates)
                })
            );

            source.addFeatures(features);
        }

        function updateLocations(type) {
            if (type === 'all') {
                $('.location-item').show()
            } else {
                $('.location-item').hide()
                $(`.location-item[data-type="${type}"]`).show()
            }
        }

        updateMarkers('all');
        updateLocations('all');

        $('.au-tag-lists a').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active')
            const type = $(this).text().toLowerCase().trim();
            updateMarkers(type);
            updateLocations(type);
            return false;
        })

        $('a[href="javascript:void(0);"]').click(function () {
            return false;
        })
    })
</script>
</body>

</html>
