@extends("admin.layouts.main")

@section("css")
	<link rel="stylesheet" href="{{ asset('extra/treegrid/css/jquery.treegrid.css') }}">
@endsection

@section("content")
	<blockquote class="layui-elem-quote">
		<a class="layui-btn layui-btn-normal add" data-url="{{ route('rule.create') }}">添加权限</a>
		<span class="layui-word-aux">添加权限后需要清除缓存</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</blockquote>
	<div class="layui-form">
	  	<table class="layui-table tree">
		    <colgroup>
				<col width="100">
				<col width="45">
				<col>
				<col>
				<col>
				<col width="80">
				<col width="80">
				<col width="150">
		    </colgroup>
		    <thead>
				<tr>
					<th>ID</th>
					<th>图标</th>
					<th style="text-align:left;">权限名称</th>
					<th style="text-align:left;">链接</th>
					<th style="text-align:left;">权限</th>
					<th>是否验证权限</th>
					<th>排序</th>
					<th>操作</th>
				</tr> 
		    </thead>
		    <tbody>
			@foreach ($rules as $rule)
				<tr class="treegrid-{{$rule['id']}} @if($rule['pid']!=0) treegrid-parent-{{$rule['pid']}} @endif">
					<td>{{ $rule['id'] }}</td>
					<td><i class="layui-icon">{{ $rule['icon'] }}</i></td>
					<td style="text-align:left;">{{ $rule['ltitle'] }}</td>
					<td style="text-align:left;">{{ $rule['href'] }}</td>
					<td style="text-align:left;">{{ $rule['rule'] }}</td>
					<td>
						<input data-url="{{ route('rule.update', ['rule' => $rule['id']]) }}" data-type="PATCH" type="checkbox" lay-skin="switch" lay-text="是|否" lay-filter="isCheck"
							   @if ($rule['check'] == 1) checked @endif>
					</td>
					<td>
						<input data-url="{{ route('rule.update', ['rule' => $rule['id']]) }}" data-type="PATCH" name="sort" type="text" class="layui-input"  value="{{$rule['sort']}}">
					</td>
					<td>
						<div class="layui-btn-group">
						<a data-url="{{ route('rule.edit', ['rule' => $rule['id']]) }}" class="layui-btn layui-btn-xs edit">
							<i class="layui-icon">&#xe642;</i>
							编辑
						</a>
						<a data-url="{{ route('rule.destroy', ['rule' => $rule['id']]) }}" data-type="DELETE" class="layui-btn layui-btn-danger layui-btn-xs del">
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
@endsection

@section("js")
	<script type="text/javascript" src="{{ asset('extra/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('extra/treegrid/js/jquery.treegrid.js') }}"></script>
	<script type="text/javascript">
        layui.use(['form', 'ori'], function () {
            var form = layui.form,
                ori = layui.ori,
                dialog = layui.dialog;

            $('.tree').treegrid({initialState: 'collapsed'});

            form.on('switch(isCheck)',function (data) {
                var isCheck = data.elem.checked, val, _that = $(this);
                val = (isCheck === true) ? 1 : 0;
                ori.submit(_that, {check: val}, '', function () {
                    _that.prop('checked', !isCheck);
                    form.render('checkbox');
                })
                return false;
            });

            $('.del').click(function () {
                var _that = $(this);
                dialog.confirm('确认删除', function () {
                    ori.submit(_that, '', function () {
                        _that.closest('tr').remove();
                    });
                });
            });

            $('.add').click(function () {
                dialog.pop({
                    'title': '添加权限',
                    'content': $(this).attr('data-url'),
                    'area': ['44%', '80%']
                });
            });

            $('.edit').click(function () {
                dialog.pop({
                    'title': '编辑权限',
                    'content': $(this).attr('data-url'),
                    'area': ['44%', '80%']
                });
            });

            $('[name="sort"]').click(function () {
                var _that = $(this);
                var val = _that.val();
                dialog.prompt('修改排序', val, function (sort) {
                    if (parseFloat(sort).toString() == "NaN") {
                        dialog.erMsg('请输入数字');
                        return false;
					}
                    ori.submit(_that, {sort: sort}, function () {
                        _that.val(sort);
					});
				});
			});

        });
	</script>
@endsection

