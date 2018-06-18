<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登录-orinfyAdmin</title>
    <meta name="description" content="simple admin" />
    <meta name="keyword" content="layui,laravel,admin" />
    <link rel="stylesheet" href="{{ asset('layadmin/layui/css/layui.css') }}"/>
    <link rel="stylesheet" href="{{ asset('layadmin/login/login.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('layadmin/index/or.ico') }}"/>
    <script>
        if (window.top != window.self) {
            top.location.href = self.location.href;
        }
    </script>
</head>
<body>
<img class="bgpic" src="{{ asset('layadmin/login/bg.png') }}">
<div class="login">
    <h1>orinfyAdmin-后台登录</h1>
    <form class="layui-form">
        <div class="layui-form-item">
            <input class="layui-input" name="username" placeholder="用户名" lay-verify="required" type="text" autocomplete="off">
        </div>
        <div class="layui-form-item">
            <input class="layui-input" name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off">
        </div>
        <div class="layui-form-item form_code">
            <input class="layui-input" name="code" placeholder="验证码" lay-verify="required" type="text" autocomplete="off">
            <div class="code"><img id="captcha" src="{{ captcha_src() }}" onclick="this.src='/captcha?'+Math.random()" width="120" height="36"></div>
        </div>
        <div class="layui-form-item remember_me">
            <label class="layui-form-label">记住我</label>
            <div class="layui-input-block">
                <input type="checkbox" name="remember" lay-skin="switch">
            </div>
        </div>
        <button type="button" class="layui-btn login_btn" lay-submit lay-filter="login">登录</button>
    </form>
</div>
<script type="text/javascript" src="{{ asset('layadmin/layui/layui.js') }}"></script>
<script>
    layui.config({base: '/layadmin/base/'}).use(['form', 'ori'],function(){
        var form = layui.form,
            $ = layui.jquery,
            dialog = layui.dialog,
            ori = layui.ori;

        function flushForm () {
            $('#captcha').attr('src', '/captcha?' + Math.random());
            $('[name="password"]').val('');
            $('[name="code"]').val('');
        }

        //登录按钮事件
        form.on("submit(login)",function(data){
            ori.ajax({
                url: '{{ route("login") }}',
                type: 'POST',
                data: data.field,
                error: function (errMsg) {
                    dialog.error(errMsg, flushForm);
                },
                success: function () {
                    location.href="{{ route('index') }}";
                    dialog.msg('登录成功,正在为您跳转');
                }
            });
            return false;
        })
    })
</script>
</body>
</html>