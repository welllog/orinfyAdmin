@extends("admin.layouts.main")

@section("content")
    <div class="or-mid">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">父级</label>
                <div class="layui-input-block">
                    <select name="pid" lay-verify="required">
                        <option data-level="0" value="0">默认顶级</option>
                    @foreach($rules as $rule)
                        @if ($rule['level'] < 3)
                        <option data-level="{{ $rule['level'] }}" value="{{ $rule['id'] }}">{{ $rule['ltitle'] }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">权限名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="title" lay-verify="required" placeholder="请输入权限名">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">权限类型</label>
                <div class="layui-input-inline">
                    <select name="type" lay-verify="required" lay-filter="type">
                        <option value="1">权限菜单</option>
                        <option value="0">仅权限</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">链接</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="href" placeholder="请输入链接">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">路由别名</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="rule" placeholder="请输入路由别名">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">图标</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="rule" placeholder="请输入路由别名">
                    <span class="layui-word-aux">图标参考layui</span>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="create-rule" data-url="{{ route('rule.store') }}" data-type="POST">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("js")
    <script type="text/javascript">
        layui.use(['form', 'ori'], function () {
            var form = layui.form,
                ori = layui.ori,
                $ = layui.$;

            form.on('select(type)', function (data) {
                if (data.value == 0) { // 仅权限时禁输入链接
                    $('[name="href"]').val('');
                    $('[name="href"]').prop('disabled', true);
                } else {
                    $('[name="href"]').prop('disabled', false);
                }
            });

            form.on('submit(create-rule)', function (data) {
                var level = $('[name="pid"]').find('option:selected').attr('data-level');
                if (level == 3) {
                    dialog.erMsg('权限最多三级,请重新选择父级');
                    return false;
                }
                data.field.level = level - (-1);
                ori.submit($(this), data.field, function () {
                    parent.location.reload();
                });
                return false;
            });
        });
    </script>
@endsection