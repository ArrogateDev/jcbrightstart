<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="h-100 flex justify-center items-center text-[56px] text-[#998675] font-bold">
            網站建設中
        </div>
    </div>
</section>

<x-web.footer/>
</body>
</html>
