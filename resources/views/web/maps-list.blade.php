<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{!! __('香港0-3岁<br />婴幼儿服务资讯') !!}"/>

        <section class="section p-t-50">
            <div class="container">
                <div class="maps-tabs-wrapper">
                    <ul class="nav nav-tabs maps-tabs-nav" id="mapsTabs" role="tablist">
                        @foreach($types as $type => $list)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                   id="tab-{{ md5($type) }}-tab"
                                   data-toggle="tab"
                                   href="#tab-{{ md5($type) }}"
                                   role="tab"
                                   aria-controls="tab-{{ md5($type) }}"
                                   aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{$type}}
                                    <span class="badge badge-light ml-2">{{ count($list) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content maps-tabs-content" id="mapsTabsContent">
                        @foreach($types as $type => $list)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                 id="tab-{{ md5($type) }}"
                                 role="tabpanel"
                                 aria-labelledby="tab-{{ md5($type) }}-tab">
                                <div class="maps-list-container">
                                    @foreach($list as $map)
                                        <div class="location-item" data-id="{{$map->id}}">
                                            <div class="location-icon">
                                                <i class="iconfont icon-location"></i>
                                            </div>
                                            <div class="location-content">
                                                <h4 class="location-title">{{$map->organization}}</h4>
                                                <div class="location-details">
                                                    @if ($map->type)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('类型')}}:</span>
                                                            <span class="detail-value">{{$map->type}}</span>
                                                        </div>
                                                    @endif
                                                    @if ($map->age)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('年龄范围')}}:</span>
                                                            <span class="detail-value">{{$map->age}}</span>
                                                        </div>
                                                    @endif
                                                    @if ($map->district)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('区域')}}:</span>
                                                            <span class="detail-value">{{$map->district}}</span>
                                                        </div>
                                                    @endif
                                                    @if ($map->capacity)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('容量')}}:</span>
                                                            <span class="detail-value">{{$map->capacity}}</span>
                                                        </div>
                                                    @endif
                                                    @if ($map->address)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('地址')}}:</span>
                                                            <span class="detail-value">{{$map->address}}</span>
                                                        </div>
                                                    @endif
                                                    @if ($map->phone)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('电话号码')}}:</span>
                                                            <span class="detail-value">
                                                                <a href="tel:{{$map->phone}}">{{$map->phone}}</a>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if ($map->email)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('电子邮件')}}:</span>
                                                            <span class="detail-value">
                                                                <a href="mailto:{{$map->email}}">{{$map->email}}</a>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if ($map->webpage)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('网页')}}:</span>
                                                            <span class="detail-value">
                                                                <a href="{{$map->webpage}}" target="_blank" rel="noopener noreferrer">{{$map->webpage}}</a>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if ($map->service_hours || $map->serviceHours)
                                                        <div class="detail-item">
                                                            <span class="detail-label">{{__('服务时间')}}:</span>
                                                            <span class="detail-value">{{$map->service_hours || $map->serviceHours || ''}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <style>
            .maps-tabs-wrapper {
                margin-top: 30px;
            }

            .maps-tabs-nav {
                border-bottom: 2px solid #e9ecef;
                margin-bottom: 30px;
                flex-wrap: wrap;
            }

            .maps-tabs-nav .nav-item {
                margin-bottom: -2px;
            }

            .maps-tabs-nav .nav-link {
                color: #6c757d;
                background-color: transparent;
                border: none;
                border-bottom: 3px solid transparent;
                padding: 15px 25px;
                font-size: 16px;
                font-weight: 500;
                transition: all 0.3s ease;
                position: relative;
                margin-right: 5px;
            }

            .maps-tabs-nav .nav-link:hover {
                color: #007bff;
                background-color: #f8f9fa;
                border-bottom-color: #dee2e6;
            }

            .maps-tabs-nav .nav-link.active {
                color: #007bff;
                background-color: #fff;
                border-bottom-color: #007bff;
                font-weight: 600;
            }

            .maps-tabs-nav .nav-link .badge {
                font-size: 12px;
                padding: 4px 8px;
                background-color: #e9ecef;
                color: #6c757d;
            }

            .maps-tabs-nav .nav-link.active .badge {
                background-color: #007bff;
                color: #fff;
            }

            .maps-tabs-content {
                padding-top: 20px;
            }

            .maps-list-container {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 25px;
            }

            .location-item {
                background: #fff;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 20px;
                transition: all 0.3s ease;
                display: flex;
                flex-direction: column;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .location-item:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                transform: translateY(-2px);
                border-color: #007bff;
            }

            .location-icon {
                margin-bottom: 15px;
            }

            .location-icon i {
                font-size: 24px;
                color: #007bff;
            }

            .location-content {
                flex: 1;
            }

            .location-title {
                font-size: 18px;
                font-weight: 600;
                color: #212529;
                margin-bottom: 15px;
                line-height: 1.4;
            }

            .location-details {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .detail-item {
                display: flex;
                flex-wrap: wrap;
                font-size: 14px;
                line-height: 1.6;
            }

            .detail-label {
                font-weight: 600;
                color: #6c757d;
                margin-right: 8px;
                min-width: 80px;
            }

            .detail-value {
                color: #212529;
                flex: 1;
            }

            .detail-value a {
                color: #007bff;
                text-decoration: none;
                word-break: break-all;
            }

            .detail-value a:hover {
                text-decoration: underline;
            }

            @media (max-width: 768px) {
                .maps-list-container {
                    grid-template-columns: 1fr;
                }

                .maps-tabs-nav .nav-link {
                    padding: 12px 15px;
                    font-size: 14px;
                }

                .location-item {
                    padding: 15px;
                }
            }
        </style>
    </main>

    <x-web.footer/>

</div>

</body>

</html>
