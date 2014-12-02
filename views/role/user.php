<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '用户角色管理';
?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>

    <ul class="breadcrumb">
    	<li>
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-info btn-xs'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-info btn-xs'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-info btn-xs'>角色管理</a>
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
					选择用户时，用户名底色变化之后表示已选中
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
    		<div class="col-xs-12">
    			<?php foreach($user as $k=>$v): ?>
					<h5> <a href="#" class="btn btn-xs pinyin" title="全选"><?=$k?></a></h5>
					<ul class="u-list">
						<?php foreach($v as $key=>$val): ?>
					    <li rel="user-id" data-user_id="<?=$key?>" class="<?php if($val['is_sel'] == 1) echo 'selected';?> user">
					    	<?=$val['username']?>
					    </li>
					    <?php endforeach;?>
					    <div style="clear:both"></div>
					</ul>
				<?php endforeach;?>
            <input type="hidden" name='csrf' value="<?=Yii::$app->request->getCsrfToken()?>">
            <input type="hidden" name="role_name" value="<?=Yii::$app->request->get('role_name');?>">
		</div>
</div>

<style type="text/css">
ul.user-list {
	margin: 0px;
	padding: 0px;
	list-style: none;
	font-size: 14px;
	padding: 10px 20px;
	border: 1px #ccc dashed;
}
ul.user-list li {
	float: left;
	width: 5em;
	border: 1px solid white;
	margin: 5px;
	padding: 3px;
	cursor: pointer;
}
ul.user-list li.selected {
	background-color: #E0DF95;
}
ul, ol, li {
	list-style: none;
}
</style>
	</div><!-- /.page-content-area -->
</div>

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/assign');?>" class="role-assign"></a>
</div>

<script type="text/javascript">
	$(function(){
		$('.user').click(function(){
			var user_id = $(this).data('user_id');
			var is_sel = $(this).hasClass('selected');
			var _this = this;
			roleAssign(user_id, is_sel);
		});

		$('.pinyin').click(function(e){
			e.preventDefault();
			var user_ids = [];
			$(this).parent().next('.user-list').find('.user:not(.selected)').each(function(e){
				user_ids.push($(this).data('user_id'));
			});
			if (user_ids.length) {
				roleAssign(user_ids, true);
			};
		});
	});
	function roleAssign(user_id, is_sel)
	{
		var role = $('input[name=role_name]').val();
		var url = $('.role-assign').attr('href');
		var csrf = $('input[name=csrf]').val();
		$.post(url, {role:role,user_id:user_id,_csrf:csrf,is_sel:is_sel},function(xhr){
			$('input[name=csrf]').val(xhr.csrf);
			if (xhr.status) {
				if (isNaN(user_id)) {
					for (u in user_id) {
						$('li[data-user_id='+user_id[u]+']').addClass('selected');
					}
				} else {
					$('li[data-user_id='+user_id+']').toggleClass('selected');
				}
			};
		}, 'json');
	}
</script>