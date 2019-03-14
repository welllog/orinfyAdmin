layui.define('dialog', function(exports){
    var $ = layui.$,
    dialog = layui.dialog;

    function Ori() {
        sessionStorage.csrftoken = $('meta[name="csrf-token"]').attr('content');
    }

    Ori.prototype.ajax = function (config) {
        var async = (config.async == null) ? true : config.async;
        var contentType = (config.contentType == null) ? "application/x-www-form-urlencoded; charset=utf-8" : config.contentType;
        var data = config.data;
        if ("application/json; charset=utf-8" == contentType) {
            data = JSON.stringify(data);  // 对json对象序列化
        }

        $.ajax({
            url: config.url,
            type: config.type,
            dataType: 'json',
            contentType: contentType,
            timeout: 15000,  // 超时时间
            async: async,   // 默认异步
            data: data,
            headers: {
                "X-CSRF-TOKEN": sessionStorage.csrftoken
                // "X-CSRF-TOKEN": $.cookie('XSRF-TOKEN')
            },
            complete: function () {
                config.complete && config.complete();
            },
            error: function(error){
                var errorInfo;
                switch (error.status) {
                    case 400:
                        errorInfo = '请求错误'; break;
                    case 401:
                        errorInfo = '未经认证的请求'; break;
                    case 403:
                        errorInfo = '请求没有权限'; break;
                    case 404:
                        errorInfo = '请求未找到'; break;
                    case 500:
                        errorInfo = '服务异常:';
                        if (error.responseJSON) {
                            errorInfo += error.responseJSON.message ? error.responseJSON.message : error.responseJSON.exception
                        }
                        break;
                    case 501:
                        errorInfo = '服务未实现'; break;
                    case 0:
                        errorInfo = '网络异常,请刷新再试'; break;
                    case 419:
                        errorInfo = '页面超时，请刷新再试'; break;    // 适用于csrfToken
                    default:
                        errorInfo = error.statusText;
                        if (error.responseJSON) {
                            errorInfo += error.responseJSON.message ? error.responseJSON.message : error.responseJSON.exception
                        }
                }
                config.error(errorInfo);
            },
            success: function(res){
                if (res.code == 0) {  // 逻辑码正确
                    config.success(res.msg, res.data, res.meta);
                    return false;
                }
                if (res.code == 1001) {  // 未登录的逻辑
                    top.location.href = '/admin/login';
                    return false;
                }
                config.error(res.exception)
            }
        });
    }

    Ori.prototype.submit = function (jqdom, data, succallable, errcallable) {
        data = data || {}
        var loadindex = dialog.load('提交中');
        this.ajax({
            url: jqdom.attr('data-url'),
            type: jqdom.attr('data-type'),
            data: data,
            complete: function () {
                dialog.close(loadindex);
            },
            error: function (errMsg) {
                dialog.erMsg(errMsg);
                errcallable && errcallable(errMsg);
            },
            success: function (msg, data, meta) {
                dialog.success('', function () {
                    dialog.closeCurIf();
                    succallable && succallable(msg, data, meta);
                });
            }
        });
    }

    exports('ori', new Ori());
});


