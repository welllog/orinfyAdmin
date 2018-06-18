layui.define(['layer','element', 'fortree'], function(exports) {
    var layer      = layui.layer;
    var element    = layui.element;
    var fortree    = layui.fortree;
    var $          = layui.jquery;

    var nav        = null;
    var tab        = null;
    var tabcontent = null;
    var tabtitle   = null;
    var navfilter  = null;
    var tabfilter  = null;

    /**
     * 添加导航
     */
    function addNav(data, topid, idname, pidname, nodename, urlname, iconname) {
        topid    = topid    || 0;
        idname   = idname   || 'id';
        pidname  = pidname  || 'pid';
        nodename = nodename || 'node';
        urlname  = urlname  || 'url';
        iconname = iconname || 'icon';

        var mytree = new fortree(data, idname, pidname, topid);
        var html = '';

        mytree.forBefore = function (v, k, hasChildren) {
            if (v[pidname] == topid) {
                html += '<li class="layui-nav-item">';
            } else {
                html += '<dd>';
            }
        };

        mytree.forcurr = function(v, k, hasChildren) {
            html += '<a href="javascript:;"'+(v[urlname] && !hasChildren ? ' data-url="'+v[urlname]+'" data-id="'+v[idname]+'"' : '')+' class="menu-'+v['level']+'">';
            html += (v[iconname] ? '<i class="layui-icon">' + v[iconname] + '</i>' : '') + '<cite>' + v[nodename] + '</cite>';
            html += '</a>';
        };

        mytree.callBefore = function (v, k) {
            html += '<dl class="layui-nav-child">';
        };

        mytree.callAfter = function (v, k) {
            html += '</dl>';
        };

        mytree.forAfter = function (v, k, hasChildren) {
            if (v[pidname] == topid) {
                html += '</li>';
            } else {
                html += '</dd>';
            }
        };

        mytree.each();

        nav.append(html);

        element.render('nav('+navfilter+')');
    }

    /**
     * 将侧边栏与顶部切换卡进行绑定
     */
    function bind(height) {
        var height = height || 60 + 41 + 44; //头部高度 顶部切换卡标题高度 底部高度
        /**
         * iframe自适应
         */
        $(window).resize(function() {
            //设置顶部切换卡容器度
            tabcontent.height($(this).height() - height);
            //设置顶部切换卡容器内每个iframe高度
            tabcontent.find('iframe').each(function () {
                $(this).height(tabcontent.height());
            });
        }).resize();

        /**
         * 监听侧边栏导航点击事件
         */
        element.on('nav('+navfilter+')', function(elem) {
            var title    = $(elem).find('cite').text();
            var src      = $(elem).attr('data-url');
            var id       = $(elem).attr('data-id');
            addTab(id, title, src);
        });
    }

    /**
     * 根据导航栏的data-id触发点击
     */
    function clickNavId(index) {
        nav.find('[data-id="'+index+'"]').click();
    }

    function addTab(id, title, url) {
        var iframe   = tabcontent.find('iframe[data-id='+id+']').eq(0);
        var tabindex = (new Date()).getTime();

        if(url != undefined && url != null && id != undefined && id != null) {
            if(iframe.length) { //存在 iframe
                //获取iframe身上的tab index
                tabindex = iframe.attr('data-tabindex');
            }else{ //不存在 iframe
                if (tabcontent.find('.tab-window').length >= 5) {
                    layer.msg('窗口数量达到上限,请关闭不用的窗口');
                    return;
                }
                //显示加载层
                var tmpIndex = layer.load();
                //设置1秒后再次关闭loading
                setTimeout(function() {
                    layer.close(tmpIndex);
                }, 1000);
                //拼接iframe
                var iframe = '<iframe onload="layui.layer.close('+tmpIndex+')" class="tab-window"';
                iframe += ' src="'+url+'" data-id="'+id+'" data-tabindex="'+tabindex+'"';
                iframe += ' style="width: 100%; height: '+tabcontent.height()+'px; border: 0px;"';
                iframe += '></iframe>';
                //顶部切换卡新增一个卡片
                element.tabAdd(tabfilter, {title: title, content: iframe, id: 'index-'+tabindex});
            }

            //切换到指定索引的卡片
            element.tabChange(tabfilter, 'index-'+tabindex);

            //隐藏第一个切换卡的删除按钮
            tabtitle.find('li').eq(0).find('i').hide();
        }

    }

    /**
     * 导出接口
     */
    exports('cms', function(navLayFilter, tabLayFilter) {
        navfilter  = navLayFilter;
        tabfilter  = tabLayFilter;

        nav        = $('.layui-nav[lay-filter='+navfilter+']').eq(0);
        tab        = $('.layui-tab[lay-filter='+tabfilter+']').eq(0);
        tabcontent = tab.children('.layui-tab-content').eq(0);
        tabtitle   = tab.children('.layui-tab-title').eq(0);

        var error = '';
        if(nav.length == 0) {
            error += '没有找到导航栏<br>';
        }

        if(tab.length == 0) {
            error += '没有找到切换卡<br>';
        }

        if(error) {
            layer.msg('cms模块初始化失败！<br>' + error);
            return false;
        }

        return {addNav: addNav, bind: bind, clickNavId: clickNavId, addTab: addTab};
    });
});