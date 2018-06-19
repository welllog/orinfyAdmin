<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>orinfyAdmin</title>
    <meta name="description" content="simple admin" />
    <meta name="keyword" content="layui,laravel,admin" />
    <link rel="stylesheet" href="{{ asset('layadmin/layui/css/layui.css') }}"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('layadmin/index/or.ico') }}"/>
    @yield("css")
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="layui-fluid" style="padding: 0 8px;">
<a class="layui-btn layui-btn-sm" style="position: fixed; right: 2px; opacity: 0.4; z-index: 10;" href="javascript:location.replace(location.href);" title="刷新">
    <i class="layui-icon">&#xe669;</i>
</a>
<div style="padding: 6px 0;">
    @yield("content")
</div>
<script src="{{ asset('layadmin/layui/layui.js') }}"></script>
<script>layui.config({base: '/layadmin/base/'});</script>
@yield("js")
</body>
</html>