@extends("admin.layouts.main")

@section("content")
    <blockquote class="layui-elem-quote">
        <div class="layui-input-inline">
            <input type="text" name="username" value="{{ $search }}" placeholder="用户名" class="layui-input">
        </div>
        <a class="layui-btn search">查询</a>
        <span class="layui-word-aux">输入用户名进行查找</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="layui-btn layui-btn-normal add" data-url="{{ route('user.create') }}">添加管理员</a>
    </blockquote>
    <div class="layui-form">
    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col>
            <col width="95">
            <col width="120">
            <col>
            <col>
            <col width="105">
            <col width="150">
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>是否启用</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>角色</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
            <td><input data-url="{{ route('user.active', ['user' => $user->id]) }}" data-type="PATCH" type="checkbox" name="status"
                       lay-skin="switch" lay-filter="active" lay-text="启用|禁用" @if($user->status==1) checked @endif></td>
            <td>{{ $user->mobile }}</td>
            <td><span class="layui-elip" style="display: inline-block; width: 150px">{{ $user->email }}</span></td>
            <td><span style="display: inline-block; width: 150px;" class="layui-elip">@foreach($user->roles as $role) {{ $role->name . '|' }} @endforeach</span></td>
            <td>{{ $user->created_at->format('Y-m-d') }}</td>
            <td>
                <div class="layui-btn-group">
                <a data-url="{{ route('user.edit', ['user' => $user->id]) }}" class="layui-btn layui-btn-xs edit">
                    <i class="layui-icon">&#xe642;</i>
                    编辑
                </a>
                <a data-url="{{ route('user.active', ['user' => $user->id]) }}" data-type="PATCH" class="layui-btn layui-btn-danger layui-btn-xs del">
                    <i class="layui-icon">&#xe640;</i>
                    删除
                </a>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div style="text-align: right;">
    {{ $users->appends(['search'=>$search])->links('admin.layouts.paginate') }}
    </div>
@endsection

@section("js")
    <script type="text/javascript">
        layui.use(['form', 'ori'], function () {
            var form = layui.form,
                ori = layui.ori,
                dialog = layui.dialog,
                $ = layui.$;

            $('.search').click(function () {
                var search = $('[name="username"]').val();
                location.href = "{{ route('user.index') }}" + '?search=' + search;
            });

            form.on('switch(active)',function (data) {
                var isActive = data.elem.checked, val, _that = $(this);
                val = (isActive === true) ? 1 : 0;
                ori.submit(_that, {field: 'status', val: val}, '', function () {
                    _that.prop('checked', !isActive);
                    form.render('checkbox');
                })
                return false;
            });

            $('.del').click(function () {
                var _that = $(this);
                dialog.confirm('确认删除', function () {
                    ori.submit(_that, {field: 'status', val: -1}, function () {
                        _that.closest('tr').remove();
                    });
                });
            });

            $('.add').click(function () {
                dialog.pop({
                    'title': '添加管理员',
                    'content': '{{ route('user.create') }}',
                    'area': ['44%', '80%']
                });
            });

            $('.edit').click(function () {
                dialog.pop({
                    'title': '编辑管理员',
                    'content': $(this).attr('data-url'),
                    'area': ['44%', '80%']
                });
            });

        });
    </script>
@endsection