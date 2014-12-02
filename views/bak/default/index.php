<?php

use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\SearchUser $searchModel
 */

$this->title = '权限管理';
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
        <div class="alert alert-info">
            <p>SRBAC使用分为几步:</p>
            <p class="alert alert-danger">1.选择需要接受权限控制的功能。</p>
            <p>2.添加角色。<a href="<?=Url::to(['role/index'])?>" class='btn btn-success btn-minier'> go! </a></p>
            <p>3.为角色添加可操作的功能(在第一步中选择的功能中选择)。<a href="<?=Url::to(['default/assign'])?>" class='btn btn-success btn-minier'> go! </a></p>
            <p>4.为用户授权,在角色管理页面选择对应的角色行的"选择用户"。<a href="<?=Url::to(['role/index'])?>" class='btn btn-success btn-minier'> go! </a></p>
        </div>
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">
            <?php foreach ($classes as $key => $value):?>
            <div class="col-sm-12 widget-container-col ui-sortable">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><?php echo $key;?></h4>
                        <div class="widget-toolbar no-border">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <?php foreach ($value as $ke => $val):?>
                            <dl class="col-sm-12 col-xs-12">
                                <dt><?php echo $ke;?> </dt>
                                    <!--
                                    <input name="action" value="" type="checkbox" class="ace"></dt>
                                    -->
                                <?php foreach ($val as $k => $v):?>
                                <dd class="checkbox pull-left" style="min-width:300px;">
                                    <label class=''>
                                        <input name="action" value="<?=$k?>" type="checkbox" <?php if(isset($v['check'])) echo 'checked';?> class="action ace">
                                        <span class="lbl "><?php echo $v['action']?>
                                            <input value="<?php echo $v['des']?>" class="action_des input-small" />
                                        </span>
                                    </label>
                                </dd>
                                <?php endforeach;?>
                            </dl>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div><!-- /.page-content -->

<div class="urls hidden">
    <a href="<?=Url::toRoute('/srbac/default/create-permission');?>" class="permission"></a>
</div>
<script type="text/javascript">
$(function(){
    $('.action').click(function(e){
        var action = $(this).val();
        var check = $(this).is(":checked");
        var url= $('.permission').attr('href');
        var des = $(this).siblings('span').children('.action_des').val();
        createpermission(action, des, check);
    })

    $('.action_des').blur(function(){
        var action = $(this).parent().siblings('input').val();
        var des = $(this).val();
        $(this).parent().siblings('input').attr('checked', 'checked');
        createpermission(action, des, true);
    });

    function createpermission(action, des, check)
    {
        var url = $('.permission').attr('href');
        $.get(url,{permission:action,des:des,check:check},function(e){

        },'json');
    }

})  





</script>