<?php 

namespace backend\modules\srbac\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
//use common\helpers\Files;
use backend\modules\srbac\helpers\Files;
/**
 * 角色管理主控制器
 */
class DefaultController extends SrbacController
{

	/**
	 * @title 权限列表
	 */
	public function actionIndex()
	{
		$actions = $this->_getBasePermission();
		return $this->render('index', ['classes'=>$actions]);
	}

	/**
	 * @title 分配权限
	 */
	public function actionAssign()
	{
		$auth = Yii::$app->authManager;
		$roles = $auth->getRoles();
		return $this->render('assign', ['roles'=>$roles]);
	}

	/**
	 * @title 配置角色权限 
	 */
	public function actionAssignPermission()
	{
		$auth = Yii::$app->authManager;

		$request = Yii::$app->request;
		$role_name = $request->post('role', '');
		$actions = $request->post('action', '');
		$method = $request->post('method', 'add');

		$role = $auth->getRole($role_name);

		$m = $method == 'add' ? 'addChild' : 'removeChild';
		foreach ($actions as $v) {
			$permision = $auth->getPermission($v);
			$auth->$m($role, $permision);
		}
		$this->actionRolePermission($role_name[0]);
	}
	/**
	 * @title 为某角色添加删除权限
	 */
	public function actionRolePermission($rolename='')
	{
		$auth = Yii::$app->authManager;
		$permisions = $auth->getPermissions();
		$all = [];
		foreach ($permisions as $k => $v) {
			$all[] = $v->name;
		}
		$rolepermission = $auth->getPermissionsByRole($rolename);

		$assigned = [];
		$yet = $un = '';
		$option = ' <option value="%s">%s</option>';
		foreach ($rolepermission as $k => $v) {
			$assigned[] = $v->name;
			$yet .= sprintf($option, $v->name, $v->name);
		}

		$unassigned = array_diff($all, $assigned);
		foreach ($unassigned as $k =>$v) {
			$un .= sprintf($option, $v, $v);
		}
		$this->ajaxReturn(['yet'=>$yet, 'un'=>$un], null,  200);
	}

	/**
	 * 创建许可
	 * @title 创建许可
	 */
	public function actionCreatePermission()
	{
		if (Yii::$app->request->isAjax) {
			$request = Yii::$app->request;
			$permision = strtolower($request->get('permission'));
			$des = $request->get('des', '');
			$check = $request->get('check');
			if (empty($permision)) {
				return 0;
			}
			// p($check);die;
			$auth = Yii::$app->authManager;

	        if ($check==='true') {
	        	$inDb = $auth->getPermission($permision);
	        	if ($inDb) {
	        		$inDb->description = $des;
	        		if ($auth->update($permision, $inDb)) {
	        			$this->ajaxReturn(null, null, 1);
	        		}
	        	} else {
	        		$createPermission = $auth->createPermission($permision);
		        	$createPermission->description = $des;
		        	if ($auth->add($createPermission)) {
			        	$this->ajaxReturn(null, null, 1);
			        }
	        	}
	        	
	        } else {
	        	$per = $auth->getPermission($permision);
	        	if ($auth->remove($per)) {
		        	$this->ajaxReturn(null, null, 1);
		        }
	        }
		}
	}
	/**
	 * @title 取得权限
	 */
	private function _getBasePermission()
	{
		$methods = $this->_getMethods();
		$permisions = [];
		foreach ($methods as $key => $val) {
			$name = str_replace('/', '_', str_replace('/modules/', '@', $key));
			$arr = explode('_', $name);

			foreach ($val as $k => $v) {
				$permisions[$arr[0]][$arr[1]][$name.'_'.$k] = [
					'des' => $v,
					'action' => $k
				];
			}
		}
		return $this->_isInDb($permisions);
	}

	/**
	 * @title 取得方法
	 */
	private function _getMethods()
	{
		$module = \Yii::$app->controller->module;

		//在配置中添加的要接受控制的命名空间
		$namespaces = $module->params['srbacPath'];

		//不要接受控制的 module
		$sys_module = ['debug', 'gii'];

		$modules = Yii::$app->getModules();
		foreach ($modules as $k => $v) {
			if (in_array($k, $sys_module)) {
				continue;
			}
			$mod = Yii::$app->getModule($k);
			$namespace = str_replace('/', '\\', $mod->controllerNamespace);
			array_push($namespaces, $namespace);
		}

		//当前所在命名空间的控制器
		$currentNamespace = str_replace('/', '\\', \Yii::$app->controllerNamespace);
		array_push($namespaces, $currentNamespace);

		//获取类方法
		$actions = Files::getAllMethods($namespaces);
		return $actions;
	}

	/**
	 * 判断权限是否已经在库中
	 */
	private function _isInDb($control_actions)
	{
		$auth = Yii::$app->authManager;
		$model_actions = $auth->getPermissions();

		$action_k_v = ArrayHelper::getColumn($model_actions, 'description');
		foreach ($control_actions as $k => $value) {
			foreach ($value as $key => $val) {
				foreach ($val as $ac=>$v) {
					if (array_key_exists(strtolower($ac), $action_k_v) !== false) {
						$control_actions[$k][$key][$ac]['check']=true;
						!empty($action_k_v[$ac]) && 
							$control_actions[$k][$key][$ac]['des'] = $action_k_v[$ac];
					}
				}
			}
		}
		return $control_actions;
	}
}