-- 菜单 SQL
INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}', 1, 1, '{{ $table->function_name }}', '{{ $table->module_name }}/{{ $functionName }}/index', 0, 1, 1, '{{ $table->module_name }}.{{ $table->function_name }}.index', 'form', '{{ $table->table_comment }}菜单', 1, '{{ $now }}', 1, '{{ $now }}', NULL);

-- 按钮父菜单ID
SELECT @parentId := LAST_INSERT_ID();

-- 按钮 SQL

INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}详情', @parentId, 1, '', '', 0, 2, 1, '{{ $table->module_name }}.{{ $table->function_name }}.show', '', '', 1, '{{ $now }}', 1, '{{ $now }}', NULL);

INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}新增', @parentId, 1, '', '', 0, 2, 1, '{{ $table->module_name }}.{{ $table->function_name }}.store', '', '', 1, '{{ $now }}', 1, '{{ $now }}', NULL);

INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}修改', @parentId, 1, '', '', 0, 2, 1, '{{ $table->module_name }}.{{ $table->function_name }}.update', '', '', 1, '{{ $now }}', 1, '{{ $now }}', NULL);

INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}删除', @parentId, 1, '', '', 0, 2, 1, '{{ $table->module_name }}.{{ $table->function_name }}.destroy', '', '', 1, '{{ $now }}', 1, '{{ $now }}', NULL);

INSERT INTO `sys_admin_menus`(`menu_name`, `parent_id`, `order`, `path`, `component`, `is_link`, `menu_type`, `is_visible`, `permission`, `icon`, `remark`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`)
VALUES ('{{ $table->table_comment }}导出', @parentId, 1, '', '', 0, 2, 1, '{{ $table->module_name }}.{{ $table->function_name }}.export', '', '', 1, '{{ $now }}', 1, '{{ $now }}', NULL);
