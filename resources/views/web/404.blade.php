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

<main id="main">
    <section class="section h-200" style="background: url('{{web_resource_url('assets/web/images/bg-404.jpg')}}') center center / cover no-repeat;">
    </section>
</main>

<x-web.footer/>
</body>

</html>
