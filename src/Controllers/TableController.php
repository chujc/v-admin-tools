<?php

namespace ChuJC\Admin\Controllers;

use ChuJC\Admin\Models\GeneratorTable;
use ChuJC\Admin\Models\GeneratorTableField;
use ChuJC\Admin\Services\AdminRoleService;
use ChuJC\Admin\Support\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TableController
{

    /**
     * @param Request $request
     * @param AdminRoleService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function db(Request $request)
    {
        $table_name = $request->input('table_name');
        $table_comment = $request->input('table_comment');
        $sql = 'select table_name, table_comment, create_time, update_time from information_schema.TABLES where `table_schema` = (select database())';

        if (isset($table_name)) {
            $sql .= ' and table_name like ' . "'%{$table_name}%'";
        }

        if (isset($table_comment)) {
            $sql .= ' and table_comment like ' . "'%{$table_comment}%'";
        }

        $data = DB::select($sql);

        return Result::data($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author john_chu
     */
    public function index(Request $request)
    {
        $params = $request->only([
            'table_name',
            'table_comment',
            'beginTime',
            'endTime'
        ]);

        $searchParams = [
            'table_name' => 'like',
            'table_comment' => 'like',
        ];

        $perPage = $request->input('per_page');
        $model = searchModelDateRange(searchModelField(GeneratorTable::query(), $params, $searchParams), $params);

        $data = $model->paginate($perPage);

        return Result::data($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author john_chu
     */
    public function show(Request $request, $id)
    {
        $data['data'] = GeneratorTableField::whereTableId($id)->get();
        $data['info'] = GeneratorTable::whereTableId($id)->first();

        return Result::data($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $params = $request->only([
            "template",
            "table_name",
            "table_comment",
            "class_name",
            "class_namespace",
            "model_name",
            "model_namespace",
            "module_name",
            "function_name",
            "function_author",
            "is_export",
            "is_selection",
            "options",
            "remark",
        ]);
        $tableId = $request->input('table_id');
        GeneratorTable::whereKey($tableId)->update($params);

        $fields = $request->input('fields');

        foreach ($fields as $field) {
            GeneratorTableField::whereKey($field['field_id'])->update($field);
        }
        return Result::success('更新成功');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author john_chu
     */
    public function destroy($id)
    {
        if (GeneratorTable::whereKey($id)->delete()) {
            return Result::success();
        }
        return Result::failed('删除失败');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author john_chu
     */
    public function import(Request $request)
    {
        $tableName = $request->input('tables');

        if ($tableName) {
            $tableArray = explode(',', $tableName);

            foreach ($tableArray as $item) {
                $tableInfo = DB::query()
                    ->selectRaw("table_name, table_comment, create_time, update_time  from  information_schema.TABLES where `table_schema` = (select database()) and `table_name` = '$item'")
                    ->first();

                if ($tableInfo) {
                    // 移除表前缀
                    $tableName = str_replace(DB::getTablePrefix(), '', $tableInfo->table_name);
                    $class_name = Str::studly(Str::plural($tableName)) . 'Controller';
                    $GeneratorTable = GeneratorTable::create([
                        'table_name' => $tableInfo->table_name,
                        'table_comment' => $tableInfo->table_comment,
                        'class_name' => $class_name,
                        'template' => 'crud',
                        'is_export' => 1,
                        'is_selection' => 1,
                        'module_name' => 'admin',
                        'function_name' => Str::lower(Str::singular($tableName)),
                        'function_author' => 'John Chu',
                    ]);

                    $tableColumns = DB::select("select column_name, is_nullable, column_key, ordinal_position, column_comment, extra, column_type from information_schema.columns where table_schema = (select database()) and table_name = '$item' order by ordinal_position");
                    if ($tableColumns) {
                        foreach ($tableColumns as $column) {
                            $params = [
                                'table_id' => $GeneratorTable->getKey(),
                                'field_name' => $column->column_name,
                                'field_comment' => $column->column_comment,
                                'field_type' => $column->column_type,
                                'is_pk' => $column->column_key == 'PRI' ? 1 : 0,
                                'is_increment' => $column->extra == 'auto_increment' ? 1 : 0,
                                'is_required' => $column->is_nullable = 'NO' && $column->column_key != 'PRI' ? 1 : 0,
                                'order' => $column->ordinal_position,
                            ];
                            GeneratorTableField::create($params);
                        }
                    }


                }
            }
        }

        return Result::success('导入成功');
    }
}
