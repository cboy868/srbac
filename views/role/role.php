<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '角色管理';
?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>

    <ul class="breadcrumb">

    	<li>
            <a href="#modal-form" role="button" class="blue btn btn-success btn-xs" data-toggle="modal"> 添加角色 </a>
        </li>
    </ul><!-- /.breadcrumb -->
    <!-- /section:basics/content.searchbox -->
</div>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
                <?= Html::encode($this->title) ?>
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					角色列表
				</small>
			</h1>
		</div><!-- /.page-header -->

        <div class="btn-group pull-right">
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-info btn-sm'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-sm'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-sm'>角色管理</a>
        </div>
        <div class="alert alert-info">
            <h5>SRBAC使用分为几步:</h5>
            <p class="text-info">1.选择需要接受权限控制的功能。<a href="<?=Url::to(['default/index'])?>" class='btn btn-info btn-xs'> go! </a></p>
            <p class="text-info">2.添加角色。<a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-xs'> go! </a></p>
            <p class="text-info">3.为角色添加可操作的功能(在第一步中选择的功能中选择)。<a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-xs'> go! </a></p>
            <p class="text-danger">4.为用户授权,在角色管理页面选择对应的角色行的"选择用户"。</p>
        </div>

		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="row">
					<div class="col-xs-12">
						<table id="sample-table-1" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>角色名</th>
									<th>描述</th>
									<th class="hidden-480">规则名</th>

									<th>
										<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
										数据
									</th>
									<th class="hidden-480">添加时间</th>
									<th width="25%" class="hidden-480"></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($roles as $v):?>
								<tr>
									<td>
										<a href="#"><?=$v->name?></a>
									</td>
									
									<td class="hidden-480"><?=$v->description?></td>
									<td><?=$v->ruleName?></td>

									<td class="hidden-480">
										<span class="label label-sm label-warning"><?=$v->data?></span>
									</td>
									<td><?=date('Y/m/d',$v->createdAt)?></td>
									<td class="hidden-480">
										<div class="hidden-sm hidden-xs btn-group">
											<a href="#edit-form" role="button" class="btn btn-xs btn-info editrole" data-toggle="modal" rel="<?=Url::to(['role/edit', 'role_name'=>$v->name]);?>">
												<i class="ace-icon fa fa-pencil bigger-120"></i>编辑
											</a>

											<a class="btn btn-xs btn-danger del" href="<?=Url::to(['role/delete','role_name'=>$v->name]);?>">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>删除
											</a>
											<a href="<?=Url::to(['role/user', 'role_name' => $v->name])?>" class='btn btn-info btn-xs'>选择用户</a>
											<a href="<?=Url::to(['role/child', 'role_name' => $v->name])?>" class='btn btn-info btn-xs'>添加子角色</a>
										</div>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.span -->
				</div><!-- /.row -->
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
<div id="modal-form" class="modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="blue bigger">请填写如下信息</h4>
			</div>

			<div class="modal-body">
				<form id="roleform">
					<div class="row">
						<div class="col-xs-12 col-sm-12">

							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">中文名</label>
								<div>
									<input name="role[description]" placeholder="角色中文名" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">codename</label>
								<div>
									<input name="role[name]" class="input-large" type="text" placeholder="角色名" />
									<span class="help-inline">
										<span class="middle">只接受英文字母</span>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">选择规则</label>

								<div>
									<select name="role[rule_name]">
										<option value="">无</option>
										<?php foreach ($rules as $k=>$v): ?>
											<option value="<?=$k;?>"><?=$k;?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">规则数据 </label>
								<div>
									<input name="role[data]" placeholder="data">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Cancel
				</button>

				<button class="btn btn-sm btn-primary add-role" type="button">
					<i class="ace-icon fa fa-check"></i>
					Save
				</button>
			</div>
		</div>
	</div>
</div><!-- PAGE CONTENT ENDS -->

<div id="edit-form" class="modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="blue bigger">请填写如下信息</h4>
			</div>

			<div class="modal-body">
				<form id="roledit">
					<div class="row">
						<div class="col-xs-12 col-sm-12">

							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">中文名</label>
								<div>
									<input name="role[description]" placeholder="角色中文名" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">codename</label>
								<div>
									<input name="role[name]" class="input-large" type="text" placeholder="角色名" />
									<span class="help-inline">
										<span class="middle">只接受英文字母</span>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">选择规则</label>

								<div>
									<select name="role[rule_name]">
										<option value="">无</option>
										<?php foreach ($rules as $k=>$v): ?>
											<option value="<?=$k;?>"><?=$k;?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right">规则数据 </label>
								<div>
									<input name="role[data]" placeholder="data">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Cancel
				</button>

				<button class="btn btn-sm btn-primary edit-role" type="button">
					<i class="ace-icon fa fa-check"></i>
					Save
				</button>
			</div>
		</div>
	</div>
</div><!-- PAGE CONTENT ENDS -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/create');?>" class="create-role"></a>
</div>
<script type="text/javascript">
$(function(){
	$('.add-role').click(function(e){
		e.preventDefault();
		var data = $('#roleform').serialize();
		createRole(data);
		// var url = $('.create-role').attr('href');
		// $.get(url, data, function(xhr){
		// 	if (xhr.status) {location.reload()};
		// },'json');
	});

	$('.edit-role').click(function(e){
		e.preventDefault();
		var data = $('#roledit').serialize();
		createRole(data);
		// var url = $('.create-role').attr('href');
		// $.get(url, data, function(xhr){
		// 	if (xhr.status) {location.reload()};
		// },'json');
	});

	$('.editrole').click(function(){
		var url = $(this).attr('rel');
		$.get(url, {}, function(xhr){
			var d = xhr.data;
			var obj = $('#roledit');
			obj.find('input[name="role[description]"]').val(d.description);
			obj.find('input[name="role[name]"]').val(d.name).parents('.form-group').hide();
			obj.find('select[name="role[rule_name]"]').val(d.ruleName);
			obj.find('input[name="role[data]"]').val(d.data);
		},'json');
	});

	function createRole(data)
	{
		var url = $('.create-role').attr('href');
		$.get(url, data, function(xhr){
			if (xhr.status) {location.reload()};
		},'json');
	}
})
</script>