<?php

namespace backend\modules\srbac;

use Yii;
use yii\base\module;
use yii\web\BadRequestHttpException;

class SrbacModule extends Module
{
	// public $layout = '/main';
	public function init()
	{
		parent::init();
        $this->params['foo'] = 'bar';
        \Yii::configure($this, require(__DIR__ . '/config.php'));
	}
}