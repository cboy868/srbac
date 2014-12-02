#srbac

## 功能描述

1.选择需要接受权限控制的功能。所以权限项已经自动生成
2.添加角色
3.为角色添加可操作的功能(在第一步中选择的功能中选择)。
4.为用户授权,在角色管理页面选择对应的角色行的"选择用户"。


## 使用说明

1. 确保yii2 rbac模块已经可以使用, 在backend配置文件main.php中加入如下代码
```php
'components' => [
        'authManager' => [//引入权限管理
            'class' => 'yii\rbac\DbManager',
        ]
    ]
```
2. 下载到 backend的modules目录，如没有，则新加
3. 在backend.php配置文件main.php中加引入此module
```php
'modules' => [
        'srbac' => [ //引入模块
            'class' => 'backend\modules\srbac\SrbacModule',
        ]
    ]
```
4. 如果想把其它应用比如frontend下的控制器也加入到权限控制中，则需要修改srbac下配置文件
```php
 'srbacPath' => [ //其它
         'frontend\controllers'
     ],
```
5. 访问 /backend/web/index.php?r=srbac

* 注意 1 要提前引入jquery 2.为角色选择用户页面，可能需要 common.css 即可

## 图例
* 权限项添加
![image](https://github.com/cboy868/srbac/blob/master/screenshots/auth.png)
* 角色管理
![image](https://github.com/cboy868/srbac/blob/master/screenshots/role.png)
* 分配权限
![image](https://github.com/cboy868/srbac/blob/master/screenshots/assign.png)
* 分配用户角色
![image](https://github.com/cboy868/srbac/blob/master/screenshots/assignuser.png)
* 子角色
![image](https://github.com/cboy868/srbac/blob/master/screenshots/child.png)

#### 联系方式

cboy868@163.com
