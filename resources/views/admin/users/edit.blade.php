@extends("admin.layouts.main")

@section("content")

    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">用户组</label>
            <div class="layui-input-block">
                @foreach($roles as $role)
                    <input type="checkbox" name="role_id[]" title="{{ $role->name }}" value="{{$role->id}}"
                    @foreach ($user->roles as $r) @if ($r->id == $role->id) checked @endif @endforeach>
                @endforeach
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="username" value="{{ $user->username }}" lay-verify="required" placeholder="请输入用户名">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="email" value="{{ $user->email }}" placeholder="请输入邮箱">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="mobile" value="{{ $user->mobile }}" placeholder="请输入手机号">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="update-user" data-url="{{ route('user.update', ['user' => $user->id]) }}" data-type="PUT">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection

@section("js")
    <script type="text/javascript">
        layui.use(['form', 'ori'], function () {
            var form = layui.form,
                ori = layui.ori,
                $ = layui.$;

            form.on('submit(update-user)', function (data) {
                ori.submit($(this), data.field, function () {
                    parent.location.reload();
                });
                return false;
            });
        });
    </script>
@endsection