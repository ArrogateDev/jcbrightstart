<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link href="{{web_resource_url('assets/web/vendor/open-layers/ol.css')}}" rel="stylesheet">
    <script src="{{web_resource_url('assets/web/vendor/open-layers/ol.js')}}"></script>
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/maps/banner.png')}}" alt="地圖">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[28px]" src="{{web_resource_url('assets/web/images/maps/icon-01.svg')}}" alt="服務配對">
                        <div class="text-[31px] font-bold">服務配對</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="flex flex-col md:flex-row gap-[28px] bg-[#e3dfdaa6] rounded-lg p-[32px] mt-[38px]">
                <div class="flex flex-col gap-[18px] w-[336px]">
                    @foreach($maps as $map)
                        <div class="collapse">
                            <input type="checkbox" class="peer"/>
                            <div class="collapse-title flex items-center gap-[6px]" style="background-color: {{$map->bg}};">
                                <img class="w-[24px]" src="{{$map->icon}}" alt="{{$map->title}}">
                                <div class="text-[24px] text-[#998675]">{{$map->title}}</div>
                            </div>
                            <div class="collapse-content peer-checked:p-[18px_32px_32px] bg-[#ece9e6]">
                                <div class="h-[484px] flex flex-col gap-[10px] overflow-y-auto">
                                    @foreach($map->locations as $location)
                                        <div class="location-item border-b-[1px] border-[#c7c1bb] py-[8px] cursor-pointer hover:text-[#754c24] hover:font-bold" data-id="{{$location->id}}">
                                            {{$location->organization}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(!empty($urls))
                        <div class="collapse">
                            <input type="checkbox" class="peer"/>
                            <div class="collapse-title flex items-center gap-[6px] bg-[#f5e9f2]">
                                <img class="w-[24px]" src="{{web_resource_url('assets/web/images/maps/icon-04.svg')}}" alt="{{__('其它实用链接')}}">
                                <div class="text-[24px] text-[#998675]">{{__('其它实用链接')}}</div>
                            </div>
                            <div class="collapse-content peer-checked:p-[18px_32px_32px] bg-[#ece9e6]">
                                <div class="h-[484px] flex flex-col gap-[10px] overflow-y-auto">
                                    @foreach($urls as $url)
                                        <a href="{{$url['url']}}" target="_blank" class="border-b-[1px] border-[#c7c1bb] py-[8px] cursor-pointer hover:text-[#754c24] hover:font-bold">
                                            {{$url['title']}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="grow flex">
                    <div id="map-box" class="w-full h-full flex-1 relative">
                        <div id="map" class="w-full h-[600px] max-h-screen rounded-lg"></div>
                        <div id="map-popup" class="map-popup">
                            <div id="map-popup-line" class="w-[10px] flex-none min-h-0 rounded-l-lg"></div>
                            <div class="shrink-0 w-full p-[10px]">
                                <div class="flex items-baseline gap-[10px] border-b-1 border-[#e6e6e6] pb-[5px]">
                                    <div class="popup-title" id="popup-title"></div>
                                    <span class="popup-close">&times;</span>
                                </div>
                                <div class="popup-content" id="popup-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
</body>

<script>
    // 增强折叠动画交互
    document.addEventListener('DOMContentLoaded', function () {
        // 监听折叠事件
        const accordions = document.querySelectorAll('#accordion .type-item');

        accordions.forEach(item => {
            item.addEventListener('click', function (e) {
                // 添加点击反馈效果
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // 监听折叠完成事件
        const collapses = document.querySelectorAll('.collapse');
        collapses.forEach(collapse => {
            collapse.addEventListener('transitionend', function () {
                // 确保完全展开后重置样式
                if (this.classList.contains('show')) {
                    this.style.height = 'auto';
                }
            });
        });
    });

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
        @foreach($map->locations as $location)
        markerData.push({
            id: '{{$location->id}}',
            coordinates: [{{$location->longitude}}, {{$location->latitude}}],
            title: '{{$location->organization}}',
            pointColor: '{{$location->point_color ?? 'ff71eb'}}',
            mapData: @json($location)
        });
        @endforeach
        @endforeach

        function preloadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }

        // 收集所有唯一的颜色(去除#号)
        const uniqueColors = [...new Set(markerData.map(m => {
            return m.pointColor || 'ff71eb';
        }))];
        const selectedIconUrl = '{!! route('marker',['hex'=>'ffb900','border'=>60]) !!}';

        // 为每种颜色生成图标URL
        const iconUrls = {};
        const markerRouteBase = '{!! route('marker',['hex'=>'PLACEHOLDER','border'=>60]) !!}';
        uniqueColors.forEach(color => {
            iconUrls[color] = markerRouteBase.replace('PLACEHOLDER', color);
        });

        // 预加载所有图标
        const preloadPromises = uniqueColors.map(color => {
            return preloadImage(iconUrls[color]);
        });
        preloadPromises.push(preloadImage(selectedIconUrl));

        Promise.all(preloadPromises).then(() => {
            initMap();
        }).catch((error) => {
            console.error('图片预加载失败:', error);
            initMap();
        });

        let selectedStyle, markers, map, popupOverlay;

        function initMap() {
            // 为每种颜色创建样式缓存
            const styleCache = {};
            uniqueColors.forEach(color => {
                styleCache[color] = new ol.style.Style({
                    image: new ol.style.Icon({
                        src: iconUrls[color],
                        anchor: [0.5, 1],
                        scale: 0.15
                    })
                });
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
                    if (isSelected) {
                        return selectedStyle;
                    }
                    const data = feature.get('data');
                    let pointColor = data && data.pointColor ? data.pointColor : 'ff71eb';
                    // 去除#号
                    pointColor = pointColor.replace(/^#/, '');
                    const style = styleCache[pointColor] || styleCache['ff71eb'];
                    if (!style) {
                        console.warn('No style found for color:', pointColor, 'Available:', Object.keys(styleCache));
                    }
                    return style;
                }
            });

            const layers = [
                new ol.layer.Tile({
                    source: new ol.source.XYZ({
                        url: 'https://mapapi.geodata.gov.hk/gs/api/v1.0.0/xyz/imagery/wgs84/{z}/{x}/{y}.png'
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

            const popupElement = document.getElementById('map-popup');
            popupOverlay = new ol.Overlay({
                element: popupElement,
                positioning: 'bottom-right',
                offset: [0, -10],
                stopEvent: true,
                autoPan: {
                    animation: {
                        duration: 250
                    }
                }
            });
            map.addOverlay(popupOverlay);

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

            function showPopup(featureData, coordinate) {
                const popup = document.getElementById('map-popup');
                const title = document.getElementById('popup-title');
                const line = document.getElementById('map-popup-line');
                const content = document.getElementById('popup-content');

                if (!popup || !title || !content || !popupOverlay) {
                    console.error('弹窗元素未找到');
                    return;
                }

                let data = null;
                let coordinates = coordinate || null;

                if (featureData) {
                    if (featureData.mapData) {
                        data = featureData.mapData;
                        coordinates = coordinates || featureData.coordinates;
                    } else if (featureData.id !== undefined) {
                        data = featureData.mapData;
                        coordinates = coordinates || featureData.coordinates;
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
                if (data.age) {
                    popupHtml += `<div class="flex info"><strong>{{__('年龄范围')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.age}</span></div>`;
                }
                if (data.district) {
                    popupHtml += `<div class="flex info"><strong>{{__('区域')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.district}</span></div>`;
                }
                if (data.capacity) {
                    popupHtml += `<div class="flex info"><strong>{{__('容量')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.capacity}</span></div>`;
                }
                if (data.address) {
                    popupHtml += `<div class="flex info"><strong>{{__('地址')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.address}</span></div>`;
                }
                if (data.phone) {
                    popupHtml += `<div class="flex info"><strong>{{__('电话号码')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.phone}</span></div>`;
                }
                if (data.email) {
                    popupHtml += `<div class="flex info"><strong>{{__('电子邮件')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.email}</span></div>`;
                }
                if (data.webpage) {
                    popupHtml += `<div class="flex info"><strong>{{__('网页')}}</strong><span class="px-[2px]">:</span><a class="grow" href="${data.webpage}" target="_blank">:${data.webpage}</a></div>`;
                }
                if (data.service_hours || data.serviceHours) {
                    popupHtml += `<div class="flex info"><strong>{{__('服务时间')}}</strong><span class="px-[2px]">:</span><span class="grow">${data.service_hours || data.serviceHours || ''}</span></div>`;
                }

                content.innerHTML = popupHtml || '<div>{{__('暂无详细信息')}}</div>';
                line.style.backgroundColor = '#' + (featureData.pointColor || data.pointColor || 'ff71eb') + 'bf';

                popup.style.display = 'flex';
                popupOverlay.setPosition(coordinates || null);
            }

            function hidePopup() {
                const popup = document.getElementById('map-popup');
                if (popupOverlay) {
                    popupOverlay.setPosition(undefined);
                }
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
                            if (orgId === featureData.mapData.id) {
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
                            showPopup(featureData, targetCenter);
                        }, 600);
                    } else {
                        // 如果不需要动画，直接显示弹窗
                        showPopup(featureData, featureData.coordinates || e.coordinate || null);
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
                const activeFeature = markers.getSource().getFeatures().find(f => f.get('selected'));

                // 如果正在动画中，延迟显示弹窗
                if (isAnimating) {
                    return;
                }

                if (activeFeature) {
                    const featureData = activeFeature.get('data');
                    setTimeout(function () {
                        showPopup(featureData, featureData.coordinates);
                    }, 100);
                } else if (pendingPopupData) {
                    setTimeout(function () {
                        showPopup(pendingPopupData, pendingPopupData.coordinates);
                        pendingPopupData = null;
                    }, 100);
                }
            });

            map.getView().on('change:resolution', function () {
                hidePopup();
            });

            map.on('moveend', function () {
                const activeFeature = markers.getSource().getFeatures().find(f => f.get('selected'));
                if (activeFeature && !isAnimating) {
                    showPopup(activeFeature.get('data'), activeFeature.get('data').coordinates);
                }
            });

            $location.click(function () {
                const $clickedItem = $(this);
                const orgId = $clickedItem.data('id');
                const marker = markerData.find(m => m.id === orgId);

                if (marker) {
                    const source = markers.getSource();
                    const allFeatures = source.getFeatures();

                    const featureToSelect = allFeatures.find(feature => {
                        const featureData = feature.get('data');
                        return featureData && featureData.id === orgId;
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
                                showPopup(marker, marker.coordinates);
                            }, 600);
                        } else {
                            // 如果不需要动画，直接显示弹窗
                            setTimeout(function () {
                                showPopup(marker, marker.coordinates);
                            }, 100);
                        }
                    }
                }
            })
        }
    })
</script>
</html>
