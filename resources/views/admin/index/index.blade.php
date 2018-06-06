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
    <link rel="stylesheet" href="{{ asset('layadmin/index/index.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('layadmin/index/or.ico') }}"/>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">orinfyAdmin</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item min-hide" lay-unselect>
                <a href="javascript:;" layadmin-event="flexible" class="hideMenu" title="侧边伸缩">
                    <i class="layui-icon layui-icon-shrink-right"></i>
                </a>
            </li>
            <li class="layui-nav-item min-hide"><a href="">控制台</a></li>
            <li class="layui-nav-item orinfy-msg"><a href="">消息<span class="layui-badge-dot"></span></a></li>
            <li class="layui-nav-item min-hide">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="https://github.com/cly00/MusicStory" target="_blank">前台页面</a></dd>
                    <dd><a href="/clouds" target="_blank">云中遨游</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <!-- 心知天气信息 -->
                <div class="weather">
                    <div id="tp-weather-widget" style="margin: -4px"></div>
                    <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
                    <script>tpwidget("init", {
                            "flavor": "slim",
                            "location": "WT33C6J2C563",
                            "geolocation": "enabled",
                            "language": "zh-chs",
                            "unit": "c",
                            "theme": "chameleon",
                            "container": "tp-weather-widget",
                            "bubble": "enabled",
                            "alarmType": "badge",
                            "color": "#FFFFFF",
                            "uid": "U78371FB98",
                            "hash": "cd55c15865ecbe0f16ba78ca60ad51eb"
                        });
                        tpwidget("show");</script>
                </div>
            </li>
            <li class="layui-nav-item avt-hide">
                <a href="javascript:;">
                    <img src="{{ asset('layadmin/index/face.jpg') }}" class="layui-nav-img">
                    <span>admin</span>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="#" target="content">基本资料</a></dd>
                    <dd><a href="javascript:void(0);" id="model">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <form name="out" method="post">
                    <a href="javascript:document.out.submit();" >退出</a>
                </form>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="left-nav">
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="layui-tab layui-tab-brief" lay-filter="top-tab" lay-allowClose="true" style="margin: 0;">
            <ul class="layui-tab-title top-tab"></ul>
            <div class="layui-tab-content"></div>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © orinfyAdmin
    </div>
    <!-- 移动端菜单弹出按钮 -->
    <div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
    <!--移动端菜单弹出阴影效果-->
    <div class="site-mobile-shade"></div>
</div>
<script src="{{ asset('layadmin/layui/layui.js') }}"></script>
<script>
    layui.config({
        base: '/layadmin/base/'
    });
    layui.use(['element','layer', 'cms'], function(){
        var element = layui.element,
            layer = layui.layer;
        $ = layui.jquery;

        var cms = layui.cms('left-nav', 'top-tab');
        // 添加菜单
        cms.addNav([
            {id: 1, pid: 0, node: '主页', url: 'main.html'},
            {id: 7, pid: 0, node: '登录', url: 'signin.html'},
            {id: 2, pid: 0, node: '搜索引擎', url: 'http://baidu.com'},
            {id: 3, pid: 2, node: '百度', url: 'https://www.baidu.com/'},
            {id: 4, pid: 2, node: '必应', url: 'http://cn.bing.com/'},
            {id: 5, pid: 2, node: '360', url: 'https://www.so.com/'},
            {id: 6, pid: 2, node: '搜狗', url: 'https://www.sogou.com/'},
            {id: 8, pid: 6, node: 'lida', url: 'https://www.baidu.com/'},
        ], 0, 'id', 'pid', 'node', 'url');

        cms.bind(60 + 41 + 20 + 44); //头部高度 + 顶部切换卡标题高度 + 顶部切换卡内容padding + 底部高度
        // 默认打开窗口
        cms.clickNavId(1);


        //mini 模式下添加 tips
        // $('.layui-nav-tree a').hover(function(){
        //     if($(".layui-side").hasClass('mini')){
        //         var tipText = $(this).find('cite').text();
        //         layer.tips(tipText, this);
        //     }
        // },function(){
        //     layer.closeAll('tips');
        // });
        // pc模式下菜单隐藏效果
        $(".hideMenu").on("click",function(){
            $('.layui-layout-admin').toggleClass('menu-hide');
        });
        // 移动端下菜单隐藏效果
        $('.site-tree-mobile').click(function () {
            $('.layui-layout-admin').toggleClass('site-mobile');
        });
        // 移动端菜单按钮是否显示
        $('.site-mobile-shade').click(function(){
            $('.layui-layout-admin').toggleClass('site-mobile');
        });
        $(window).resize(function() {
            // 屏幕调整清除多余class
            $('.layui-layout-admin').removeClass('site-mobile').removeClass('menu-hide');
        })


        // layer.open({
        //     type: 1
        //     ,title: false //不显示标题栏
        //     ,closeBtn: false
        //     ,area: '300px;'
        //     ,shade: 0.8
        //     ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
        //     ,btn: ['知道了']
        //     ,btnAlign: 'c'
        //     ,moveType: 1 //拖拽模式，0或者1
        //     ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
        //     '注意啦，各位亲！<br>当前项目部署在亚马逊的免费服务器上，而且是国外的所以速度有点蜗牛<br><br>当前VIP用户所属的是管理员角色，请不要对此角色进行停用修改删除，否则重新登录之后就看不到东西了<br><br>新增菜单是需要授权才可以看见的，所以目前新增菜单是看不见效果的<br></div>'
        // });

    });
</script>
</body>
</html>