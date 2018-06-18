@extends("admin.layouts.main")

@section("content")
    <div>
        <blockquote class="layui-elem-quote">系统基本参数</blockquote>
        <table class="layui-table">
            <tbody>
            <tr>
                <td>网站域名</td>
                <td class="host">{{$sysinfo['url']}}</td>
            </tr>
            <tr>
                <td>网站目录</td>
                <td class="document_root">{{$sysinfo['document_root']}}</td>
            </tr>
            <tr>
                <td>服务器系统</td>
                <td class="server_os">{{$sysinfo['server_os']}}</td>
            </tr>
            <tr>
                <td>服务端口号</td>
                <td class="server_port">{{$sysinfo['server_port']}}</td>
            </tr>
            <tr>
                <td>网站ip</td>
                <td class="ip">{{$sysinfo['server_ip']}}</td>
            </tr>
            <tr>
                <td>web环境</td>
                <td class="server">{{$sysinfo['server_soft']}}</td>
            </tr>
            <tr>
                <td>PHP版本</td>
                <td class="server">{{$sysinfo['php_version']}}</td>
            </tr>
            <tr>
                <td>mysql版本</td>
                <td class="dataBase">{{$sysinfo['mysql_version']}}</td>
            </tr>
            <tr>
                <td>redis版本</td>
                <td class="dataBase">{{$sysinfo['redis_version']}}</td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td class="maxUpload">{{$sysinfo['max_upload_size']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

@section("js")
@endsection
