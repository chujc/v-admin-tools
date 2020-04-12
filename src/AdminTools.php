<?php

namespace ChuJC\Admin;


class AdminTools
{

    /**
     * @return string
     */
    public function version()
    {
        return '1.0.0';
    }


    /**
     * 路由
     * @author john_chu
     */
    public static function routes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'namespace' => 'ChuJC\\Admin\\Controllers',
        ];
        app('router')->group($attributes, function ($router) {
            $router->get('tools/generator/build', 'GeneratorController@build');
            $router->get('tools/db/table', 'TableController@db');
            $router->get('tools/table', 'TableController@index');
            $router->post('tools/table/import', 'TableController@import');
            $router->get('tools/table/{id}', 'TableController@show');
            $router->put('tools/table', 'TableController@update');
            $router->delete('tools/table/{id}', 'TableController@destroy');
        });

    }
}
