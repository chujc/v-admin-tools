<h1 align="center"> VAdmin Tools </h1>

<p align="center"> VAdmin 开发工具</p>

## 说明
生成代码后请打开文件下面的`readme.md`文件，按说明覆盖前后端工程文件，并复制其中路由代码。
> 特别说明生成的如果需要生成的model文件如同包中一样有属性注释，请使用"barryvdh/laravel-ide-helper"

## 功能
- [x] 代码生成器
- [x] 表单生成器
  > [form-generator](https://github.com/JakHuang/form-generator)

## 安装
1. `composer require chujc/v-admin-tools` 
2. php artisan vendor:publish --provider="ChuJC\Admin\AdminToolsServiceProvider"
   > 在该命令会生成数据库迁移文件到`database/migrations`下面
3. php artisan admin:tools:install
   > 命令会构建对应数据库表与插入菜单数据
4. 在路由配置文件中
   > 默认在app\Admin\routes.php文件中
```php
\ChuJC\Admin\AdminTools::routes();
```
