<?php

use Illuminate\Database\Seeder;
use ChuJC\Admin\Models\AdminUser;
use ChuJC\Admin\Models\AdminRole;
use ChuJC\Admin\Models\AdminMenu;
use ChuJC\Admin\Models\AdminDictDatum;
use ChuJC\Admin\Models\AdminDictType;
use Illuminate\Support\Facades\Hash;

class AdminToolDatabaseSeeder extends Seeder
{
    private $menus = [
        [
            'menu_name' => '开发工具箱',
            'parent_id' => 0,
            'order' => 1,
            'path' => 'tool',
            'component' => '',
            'is_link' => 0,
            'menu_type' => 1,
            'is_visible' => 1,
            'permission' => '',
            'icon' => 'tool',
            'remark' => '开发工具箱',
        ],
        [
            'menu_name' => '表单生成器',
            'parent_id' => 1,
            'order' => 1,
            'path' => 'form',
            'component' => 'tool/form/index',
            'is_link' => 0,
            'menu_type' => 1,
            'is_visible' => 1,
            'permission' => '',
            'icon' => 'form',
            'remark' => '表单生成器',
        ],
        [
            'menu_name' => '代码生成器',
            'parent_id' => 1,
            'order' => 1,
            'path' => 'generator',
            'component' => 'tool/generator/index',
            'is_link' => 0,
            'menu_type' => 1,
            'is_visible' => 1,
            'permission' => '',
            'icon' => 'build ',
            'remark' => '代码生成器',
        ]
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $menuId = AdminMenu::create($this->menus[0])->getKey();
        $this->menus[1]['parent_id'] = $menuId;
        $this->menus[2]['parent_id'] = $menuId;
        AdminMenu::create($this->menus[1]);
        AdminMenu::create($this->menus[2]);
    }


}
