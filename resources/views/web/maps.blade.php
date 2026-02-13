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
        color: white;
    }

    .location-lists {
        overflow: auto;
        flex: 1;
        min-height: 0;
        padding: 0 10px;
    }

    .location-item {
        display: flex;
        border: 1px solid #0000001a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 8px;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
        background: #00c8d4;
    }

    .location-item:hover, .location-item.active {
        color: #fff;
        background: #ff97a4;
        border: 1px solid #ff97a41a;
    }

    .location-item:hover .location-title, .location-item.active .location-title {
        color: #fff;
    }

    .location-title {
        font-weight: 600;
        font-size: 17px;
        color: white;
    }

    .type-item {
        font-weight: 700;
        padding: 10px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #00c8d4;
        cursor: pointer;
        color: white;
    }

    .type-item.collapsed .icon-expand {
        display: inline-block;
    }

    .type-item.collapsed .icon-collapse {
        display: none;
    }

    .type-item:not(.collapsed) {
        border-radius: 10px 10px 0 0;
    }

    .type-item:not(.collapsed) .icon-expand {
        display: none;
    }

    .type-item:not(.collapsed) .icon-collapse {
        display: inline-block;
    }

    .location-lists .collapse.show {
        border: 1px solid #7dd0f8;
        border-radius: 0 0 10px 10px;
    }

    #map-box {
        height: 800px;
    }

    .row > .col-md-3,
    .row > .col-md-9 {
        display: flex;
        flex-direction: column;
    }

    #map-location {
        display: flex;
        flex-direction: column;
    }

    .map-popup {
        position: absolute;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        padding: 15px;
        min-width: 250px;
        max-width: 350px;
        z-index: 1000;
        display: none;
        transform: translateX(-50%);
    }

    .map-popup:before {
        content: '';
        position: absolute;
        top: 99%;
        left: 50%;
        transform: translateX(-50%);
        border: 10px solid transparent;
        border-top-color: white;
    }

    .popup-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .popup-content {
        font-size: 14px;
        color: #666;
        line-height: 1.4;
    }

    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: #999;
    }

    .popup-close:hover {
        color: #333;
    }

    #map-location .section-heading__title {
        padding: 15px;
        color: white !important;
    }
</style>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('香港0-3岁婴幼儿服务资讯')}}" subtitle="{{__('香港0-3岁婴幼儿服务资讯')}}"/>

        <section class="section p-t-125">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 p-1" style="background: #ffb900; background-clip: content-box; border-radius: 10px;">
                        <div id="map-location" class="w-100">
                            <div class="page-sidebar h-100 p-sm-b-70">
                                <div class="widget h-100 d-flex flex-column">
                                    <div class="section-heading section-heading-1 section-heading-1--tiny2 text-left">
                                        <h2 class="section-heading__title">Map</h2>
                                        <div class="m-b-25"></div>
                                    </div>
                                    <div class="location-lists overflow-auto" id="accordion">

                                        @foreach($types as $type => $list)
                                            <div class="mb-3">
                                                <div class="type-item collapsed" id="{{md5($type)}}" data-toggle="collapse" data-target="#collapse-{{md5($type)}}" aria-expanded="false"
                                                     aria-controls="collapse-{{md5($type)}}">
                                                    <span>{{$type}}</span>
                                                    <span class="icon">
                                                            <i class="fas fa-chevron-down icon-expand"></i>
                                                            <i class="fas fa-chevron-up icon-collapse"></i>
                                                        </span>
                                                </div>

                                                <div id="collapse-{{md5($type)}}" class="collapse p-2" aria-labelledby="{{md5($type)}}" data-parent="#accordion">

                                                    @foreach($list as $map)
                                                        <div class="location-item" data-id="{{$map->id}}">
                                                            <i class="iconfont icon-location"></i>
                                                            <div class="ml-2">
                                                                <h5 class="title title--black location-title">
                                                                    {{$map->organization}}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 p-1">
                        <div id="map-box" class="w-100 position-relative">
                            <div id="map" class="w-100 h-100"></div>
                            <!-- 信息弹窗 -->
                            <div id="map-popup" class="map-popup">
                                <span class="popup-close">&times;</span>
                                <div class="popup-title" id="popup-title"></div>
                                <div class="popup-content" id="popup-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-web.footer/>

</div>

<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
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

<script type="text/javascript" src="{{web_resource_url('assets/web/js/config-revolution.min.js')}}"></script>

<link href="{{web_resource_url('assets/web/vendor/open-layers/ol.css')}}" rel="stylesheet">
<script src="{{web_resource_url('assets/web/vendor/open-layers/ol.js')}}"></script>

<script>
    function adjustMapLocationHeight() {
        const typesElement = document.querySelector('.types');
        const mapBoxElement = document.getElementById('map-box');
        const mapLocationElement = document.getElementById('map-location');

        if (typesElement && mapBoxElement && mapLocationElement) {
            const typesHeight = typesElement.offsetHeight + 20;
            const mapBoxHeight = mapBoxElement.offsetHeight;
            const totalHeight = typesHeight + mapBoxHeight;
            mapLocationElement.style.height = totalHeight + 'px';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        adjustMapLocationHeight();
    });

    window.addEventListener('resize', function () {
        adjustMapLocationHeight();
    });
</script>

<script type="module">
    $(function () {
        const $location = $('.location-item')
        let markerData = [];
        @foreach($maps as $map)
        markerData.push({
            id: '{{$map->id}}',
            coordinates: [{{$map->longitude}}, {{$map->latitude}}],
            title: '{{$map->organization}}',
            mapData: @json($map)
        });
        @endforeach

        function preloadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }

        const normalIconUrl = '{{route('marker',['hex'=>'00c8d4'])}}';
        const selectedIconUrl = '{{route('marker',['hex'=>'ffb900'])}}';

        Promise.all([
            preloadImage(normalIconUrl),
            preloadImage(selectedIconUrl)
        ]).then(() => {
            initMap();
        }).catch((error) => {
            console.error('图片预加载失败:', error);
            initMap();
        });

        let normalStyle, selectedStyle, markers, map;

        function initMap() {
            normalStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    src: normalIconUrl,
                    anchor: [0.5, 1],
                    scale: 0.15
                })
            });

            selectedStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    src: selectedIconUrl,
                    anchor: [0.5, 1],
                    scale: 0.15
                })
            });

            markers = new ol.layer.Vector({
                source: new ol.source.Vector(),
                updateWhileInteracting: true,
                updateWhileAnimating: true,
                style: function (feature, resolution) {
                    const isSelected = feature.get('selected') || false;
                    return isSelected ? selectedStyle : normalStyle;
                }
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

            map = new ol.Map({
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

                const features = filteredMarkers.map(marker => {
                    const feature = new ol.Feature({
                        geometry: new ol.geom.Point(marker.coordinates),
                        data: marker
                    });
                    feature.set('selected', false);
                    return feature;
                });

                source.addFeatures(features);

                map.render();
            }

            function showPopup(featureData, pixel) {
                const popup = document.getElementById('map-popup');
                const title = document.getElementById('popup-title');
                const content = document.getElementById('popup-content');

                if (!popup || !title || !content) {
                    console.error('弹窗元素未找到');
                    return;
                }

                let data = null;
                let coordinates = null;

                if (featureData) {
                    if (featureData.mapData) {
                        data = featureData.mapData;
                        coordinates = featureData.coordinates;
                    } else if (featureData.id !== undefined) {
                        data = featureData.mapData;
                        coordinates = featureData.coordinates;
                    } else {
                        data = featureData;
                    }
                }

                if (!data) {
                    console.warn('showPopup: 没有可用的数据', featureData);
                    return;
                }

                title.textContent = data.organization || data.title || '{{__('未知机构')}}';

                let popupHtml = '';
                if (data.type) {
                    popupHtml += `<div><strong>{{__('类型')}}:</strong> ${data.type}</div>`;
                }
                if (data.age) {
                    popupHtml += `<div><strong>{{__('年龄范围')}}:</strong> ${data.age}</div>`;
                }
                if (data.district) {
                    popupHtml += `<div><strong>{{__('区域')}}:</strong> ${data.district}</div>`;
                }
                if (data.capacity) {
                    popupHtml += `<div><strong>{{__('容量')}}:</strong> ${data.capacity}</div>`;
                }
                if (data.address) {
                    popupHtml += `<div><strong>{{__('地址')}}:</strong> ${data.address}</div>`;
                }
                if (data.phone) {
                    popupHtml += `<div><strong>{{__('电话号码')}}:</strong> ${data.phone}</div>`;
                }
                if (data.email) {
                    popupHtml += `<div><strong>{{__('电子邮件')}}:</strong> ${data.email}</div>`;
                }
                if (data.webpage) {
                    popupHtml += `<div><strong>{{__('网页')}}:</strong> ${data.webpage}</div>`;
                }
                if (data.service_hours || data.serviceHours) {
                    popupHtml += `<div><strong>{{__('服务时间')}}:</strong> ${data.service_hours || data.serviceHours || ''}</div>`;
                }

                content.innerHTML = popupHtml || '<div>{{__('暂无详细信息')}}</div>';

                // 先显示弹窗（但位置可能不对），以便正确计算尺寸
                popup.style.display = 'block';
                popup.style.visibility = 'hidden';

                // 使用双重 requestAnimationFrame 确保 DOM 完全渲染后再计算位置
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        const mapViewport = map.getViewport();
                        const mapBox = document.getElementById('map-box');
                        if (!mapBox) {
                            console.error('地图容器未找到');
                            popup.style.display = 'none';
                            popup.style.visibility = 'visible';
                            return;
                        }

                        const mapBoxRect = mapBox.getBoundingClientRect();
                        const mapViewportRect = mapViewport.getBoundingClientRect();

                        // 计算视口相对于容器的偏移量
                        const viewportOffsetX = mapViewportRect.left - mapBoxRect.left;
                        const viewportOffsetY = mapViewportRect.top - mapBoxRect.top;

                        if (!pixel) {
                            if (coordinates) {
                                pixel = map.getPixelFromCoordinate(coordinates);
                            } else if (featureData && featureData.coordinates) {
                                pixel = map.getPixelFromCoordinate(featureData.coordinates);
                            } else if (data.longitude !== undefined && data.latitude !== undefined) {
                                pixel = map.getPixelFromCoordinate([data.longitude, data.latitude]);
                            }
                        }

                        // 现在弹窗已显示，可以正确获取尺寸
                        const popupWidth = popup.offsetWidth;
                        const popupHeight = popup.offsetHeight;
                        const mapBoxWidth = mapBoxRect.width;
                        const mapBoxHeight = mapBoxRect.height;

                        let shouldShow = false;

                        if (pixel && pixel.length === 2) {
                            // 计算相对于地图容器的位置
                            // pixel[0] 和 pixel[1] 是相对于地图视口的像素位置
                            // 需要加上视口相对于容器的偏移量
                            // 注意：弹窗使用了 transform: translateX(-50%)，所以 left 值应该是弹窗中心的位置
                            const popupLeft = pixel[0] + viewportOffsetX;
                            const popupTop = pixel[1] + viewportOffsetY;

                            let finalLeft = popupLeft;
                            let finalTop = popupTop - popupHeight - 45;

                            // 确保弹窗在地图容器内
                            if (finalLeft - popupWidth / 2 < 0) {
                                finalLeft = popupWidth / 2 + 10;
                            } else if (finalLeft + popupWidth / 2 > mapBoxWidth) {
                                finalLeft = mapBoxWidth - popupWidth / 2 - 10;
                            }

                            if (finalTop < 10) {
                                finalTop = popupTop + 30;
                            } else if (finalTop + popupHeight > mapBoxHeight) {
                                finalTop = mapBoxHeight - popupHeight - 10;
                            }

                            // 检查弹窗是否在地图区域内（相对于地图容器）
                            const popupRight = finalLeft + popupWidth / 2;
                            const popupLeftEdge = finalLeft - popupWidth / 2;
                            const popupBottom = finalTop + popupHeight;
                            const popupTopEdge = finalTop;

                            // 检查弹窗是否与地图区域有重叠
                            shouldShow = !(popupRight < 0 ||
                                popupLeftEdge > mapBoxWidth ||
                                popupBottom < 0 ||
                                popupTopEdge > mapBoxHeight);

                            if (shouldShow) {
                                popup.style.left = finalLeft + 'px';
                                popup.style.top = finalTop + 'px';
                                popup.style.display = 'block';
                                popup.style.visibility = 'visible';
                            } else {
                                popup.style.display = 'none';
                                popup.style.visibility = 'visible';
                            }
                        } else {
                            // 如果无法计算位置，使用地图容器中心
                            const defaultLeft = mapBoxWidth / 2;
                            const defaultTop = mapBoxHeight / 2 - 100;

                            const popupRight = defaultLeft + popupWidth / 2;
                            const popupLeftEdge = defaultLeft - popupWidth / 2;
                            const popupBottom = defaultTop + popupHeight;
                            const popupTopEdge = defaultTop;

                            shouldShow = !(popupRight < 0 ||
                                popupLeftEdge > mapBoxWidth ||
                                popupBottom < 0 ||
                                popupTopEdge > mapBoxHeight);

                            if (shouldShow) {
                                popup.style.left = defaultLeft + 'px';
                                popup.style.top = defaultTop + 'px';
                                popup.style.display = 'block';
                                popup.style.visibility = 'visible';
                            } else {
                                popup.style.display = 'none';
                                popup.style.visibility = 'visible';
                            }
                        }
                    });
                });
            }

            function hidePopup() {
                const popup = document.getElementById('map-popup');
                popup.style.display = 'none';
            }

            function updateMarkerSelection(featureToSelect) {
                const source = markers.getSource();
                const allFeatures = source.getFeatures();

                allFeatures.forEach(feature => {
                    const wasSelected = feature.get('selected');
                    if (wasSelected) {
                        feature.set('selected', false);
                        feature.changed();
                    }
                });

                if (featureToSelect) {
                    featureToSelect.set('selected', true);
                    featureToSelect.changed();

                    const featureData = featureToSelect.get('data');
                    if (featureData && featureData.title) {
                        $location.removeClass('active');
                        $location.each(function () {
                            const $item = $(this);
                            const orgId = $item.data('id');
                            if (orgId == featureData.mapData.id) {
                                $item.addClass('active');
                                const container = $item.closest('.location-lists')[0];
                                if (container) {
                                    const itemTop = $item.position().top + container.scrollTop;
                                    const itemHeight = $item.outerHeight();
                                    const containerHeight = container.clientHeight;
                                    const scrollTop = container.scrollTop;

                                    if (itemTop < scrollTop) {
                                        container.scrollTop = itemTop - 10;
                                    } else if (itemTop + itemHeight > scrollTop + containerHeight) {
                                        container.scrollTop = itemTop + itemHeight - containerHeight + 10;
                                    }
                                }
                            }
                        });
                    }
                } else {
                    $location.removeClass('active');
                    hidePopup();
                }

                map.render();
            }

            map.on('click', function (e) {
                let clickedFeature = null;

                map.forEachFeatureAtPixel(e.pixel, function (feature, layer) {
                    if (layer === markers) {
                        clickedFeature = feature;
                        return true;
                    }
                }, {
                    layerFilter: function (layer) {
                        return layer === markers;
                    }
                });

                if (clickedFeature) {
                    updateMarkerSelection(clickedFeature);

                    const featureData = clickedFeature.get('data');
                    const view = map.getView();
                    const currentCenter = view.getCenter();
                    const targetCenter = featureData && featureData.coordinates;

                    // 检查是否需要动画
                    const needsAnimation = targetCenter && currentCenter &&
                        (Math.abs(currentCenter[0] - targetCenter[0]) > 0.001 ||
                            Math.abs(currentCenter[1] - targetCenter[1]) > 0.001);

                    if (needsAnimation) {
                        // 如果需要动画，先隐藏弹窗，等动画完成后再显示
                        hidePopup();
                        isAnimating = true;
                        view.animate({
                            center: targetCenter,
                            zoom: 15,
                            duration: 500
                        });
                        // 动画完成后显示弹窗
                        setTimeout(function () {
                            isAnimating = false;
                            showPopup(featureData, null);
                        }, 600);
                    } else {
                        // 如果不需要动画，直接显示弹窗
                        showPopup(featureData, e.pixel);
                    }
                } else {
                    updateMarkerSelection(null);
                }
            });

            updateMarkers('all');

            document.querySelector('.popup-close').addEventListener('click', function () {
                hidePopup();
            });

            map.on('pointermove', function (e) {
                const pixel = map.getEventPixel(e.originalEvent);
                const hit = map.hasFeatureAtPixel(pixel, {
                    layerFilter: function (layer) {
                        return layer === markers;
                    }
                });
                map.getTargetElement().style.cursor = hit ? 'pointer' : '';
            });

            let pendingPopupData = null;
            let isAnimating = false;

            map.getView().on('change:center', function () {
                const popup = document.getElementById('map-popup');
                const activeFeature = markers.getSource().getFeatures().find(f => f.get('selected'));

                // 如果正在动画中，延迟显示弹窗
                if (isAnimating) {
                    return;
                }

                if (activeFeature) {
                    const featureData = activeFeature.get('data');
                    setTimeout(function () {
                        showPopup(featureData, null);
                    }, 100);
                } else if (pendingPopupData) {
                    setTimeout(function () {
                        showPopup(pendingPopupData, null);
                        pendingPopupData = null;
                    }, 100);
                }
            });

            map.getView().on('change:resolution', function () {
                hidePopup();
            });

            $location.click(function () {
                const $clickedItem = $(this);
                const orgId = $clickedItem.data('id');
                const marker = markerData.find(m => m.id == orgId);

                if (marker) {
                    const source = markers.getSource();
                    const allFeatures = source.getFeatures();

                    const featureToSelect = allFeatures.find(feature => {
                        const featureData = feature.get('data');
                        return featureData && featureData.id == orgId;
                    });

                    if (featureToSelect) {
                        updateMarkerSelection(featureToSelect);

                        $location.removeClass('active');
                        $clickedItem.addClass('active');

                        const view = map.getView();
                        const currentCenter = view.getCenter();
                        const targetCenter = marker.coordinates;

                        // 检查是否需要动画
                        const needsAnimation = currentCenter &&
                            (Math.abs(currentCenter[0] - targetCenter[0]) > 0.001 ||
                                Math.abs(currentCenter[1] - targetCenter[1]) > 0.001);

                        if (needsAnimation) {
                            // 如果需要动画，先隐藏弹窗，等动画完成后再显示
                            hidePopup();
                            pendingPopupData = marker;
                            isAnimating = true;

                            view.animate({
                                center: marker.coordinates,
                                zoom: 15,
                                duration: 500
                            });

                            // 动画完成后显示弹窗
                            setTimeout(function () {
                                isAnimating = false;
                                showPopup(marker, null);
                            }, 600);
                        } else {
                            // 如果不需要动画，直接显示弹窗
                            setTimeout(function () {
                                showPopup(marker, null);
                            }, 100);
                        }
                    }
                }
            })
        }
    })
</script>
</body>

</html>
