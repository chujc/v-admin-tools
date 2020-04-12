# VAdmin Tools

### 使用说明
解压后文件夹结构
- App文件夹可以直接覆盖到Laravel 或 Lumen工程中App文件夹中
> 如果之前有相同文件请注意文件内容，避免生成出来的代码文件覆盖自己编写的代码
- src文件为前端工程文件，可以直接覆盖到前端工程src文件下
> 同时注意避免覆盖自己编写的代码
- *.sql 文件为需要导入到数据库的文件，以便生成对应的菜单与权限
- 后端路由，请把一下路由代码复制到app/Admin/routes.php 文件的路由组中，以便前端正常调用接口
```php
@if(isLaravel())
    $router->apiResource('{{ $table->module_name }}/{{ $table->function_name }}', '{{ $table->class_name }}')->names('{{ $table->module_name }}.{{ $lowerPluralFunctionName }}');
    $router->get('{{ $table->module_name }}/{{ $table->function_name }}/export/excel', '{{ $table->class_name }}@export')->name('{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.export');
@else
    $router->get('{{ $table->module_name }}/{{ $table->function_name }}', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.index', 'uses' => '{{ $table->class_name }}@index']);
    $router->get('{{ $table->module_name }}/{{ $table->function_name }}/{id}', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.show', 'uses' => '{{ $table->class_name }}{!! $show !!}']);
    $router->post('{{ $table->module_name }}/{{ $table->function_name }}', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.store', 'uses' => '{{ $table->class_name }}@store']);
    $router->put('{{ $table->module_name }}/{{ $table->function_name }}/{id}', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.update', 'uses' => '{{ $table->class_name }}@update']);
    $router->delete('{{ $table->module_name }}/{{ $table->function_name }}/{id}', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.destroy', 'uses' => '{{ $table->class_name }}@destroy']);
    $router->get('{{ $table->module_name }}/{{ $table->function_name }}/export/excel', ['as' => '{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.export', 'uses' => '{{ $table->class_name }}@export']);
@endif

```
- 因模板导出，导致代码凌乱，请使用第三方工具进行代码格式化
> PhpStorm or WebStorm 在window环境下，打开对应的文件 执行`Ctrl + Alt + L` 或者 点击菜单中的`Code` 选择 `Reformat Code`， macOS 下面 快捷键 `⌥⌘L`（option + command + L）
