<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '添加子角色';
?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>

    <ul class="breadcrumb">
        <li>
            <a href="<?=Url::to(['default/index'])?>" class='btn btn-success btn-minier'>管理授权项</a>
            <a href="<?=Url::to(['default/assign'])?>" class='btn btn-success btn-minier'>分配授权</a>
            <a href="<?=Url::to(['role/index'])?>" class='btn btn-success btn-minier'>角色管理</a>
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
                    在此列表可以对用户进行修改、删除等操作
                </small>
            </h1>
        </div><!-- /.page-header -->

        <!-- PAGE CONTENT BEGINS -->
        <div class="row">
            <div class="col-xs-12 col-sm-2 widget-container-col ui-sortable">
                <div class="widget-box widget-color-dark light-border ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title smaller">角色</h5>
                    </div>

                    <div class="widget-body">
                        <select class="form-control" id="roleselect" size='18'>
                            <?php foreach ($roles as $k => $v):?>
                                <option value="<?=$v->name ?>"><?=$v->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 widget-container-col ui-sortable">
                <div class="widget-box widget-color-dark light-border ui-sortable-handle">
                    <div class="widget-header">
                        <h5 class="widget-title smaller">添加子角色</h5>
                        <div class="widget-toolbar">
                            <span class="badge badge-danger">子角色<<>>基它角色</span>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="row">
                            <div class="col-sm-5 widget-container-col ui-sortable">
                                <select class="form-control" id="child" multiple="multiple" size='22'>
                                   
                                </select>
                            </div>
                            <div class="col-sm-1 widget-container-col" style="margin-top:100px;">
                                <div class="btn-group btn-group-vertical">
                                    <button class="btn btn-info handel" rel="add"><i class='fa fa-angle-double-left'></i></button>
                                    <button class="btn btn-info handel" rel="del"><i class='fa fa-angle-double-right'></i></button>
                                </div>
                            </div>
                            <div class="col-sm-6 widget-container-col ui-sortable">
                                <select class="form-control" id="other" multiple="multiple" size='22'>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->



<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/role/role-child');?>" class="role-child"></a>
    <a href="<?=Url::toRoute('/srbac/role/get-child');?>" class="get-child"></a>
    <input name='csrf' value="<?=Yii::$app->request->getCsrfToken()?>">
</div>
<script type="text/javascript">
$(function(){
    $('#roleselect').change(function(){
        var role = $(this).val();
        selectRole(role)
    });

    $('.handel').click(function(){
        var rel = $(this).attr('rel');
        var url = $('.role-child').attr('href');
        var role = $('#roleselect').val();
        var csrf = $('input[name=csrf]').val();
        if (rel=='add') {
            var val = $('#other').val();
        } else {
            var val = $('#child').val();
        };

        $.post(url, {method:rel, _csrf:csrf, child:val,role:role}, function(xhr){
        	$('input[name=csrf]').val(xhr.csrf);
            if (xhr.status) {
                selectRole(role);
            };
        }, 'json');
        // $.post(url, {method:rel, child:child, _csrf:csrf, role:role}, function(xhr){
        //     // $('input[name=csrf]').val(xhr.csrf);
        //     // if (xhr.status) {
        //     //     selectRole(role);
        //     // };
        // },'json');

    });
});

function selectRole(role){
    var url = $('.get-child').attr('href')+'&rolename='+role;
    $.get(url, null, function(xhr){
        if (xhr.status) {
            $('#child').html(xhr.data.child);
            $('#other').html(xhr.data.other);
        };
    },'json');
}
</script>