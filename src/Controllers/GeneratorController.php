<?php

namespace ChuJC\Admin\Controllers;

use App\Http\Controllers\Controller;
use ChuJC\Admin\Models\GeneratorTable;
use ChuJC\Admin\Models\GeneratorTableField;
use ChuJC\Admin\Services\GeneratorService;
use ChuJC\Admin\Support\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use DB, Str;

class GeneratorController extends Controller
{
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
     * @param GeneratorService $service
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @author john_chu
     */
    public function build(Request $request, GeneratorService $service)
    {
        $tableIds = $request->input('tables');

        $tableIds = explode(',', $tableIds);

        $zipFileName = 'v-admin-template-code.zip';
        Storage::put($zipFileName, '');

        $zip = new \ZipArchive();
        $zip->open(Storage::path($zipFileName), \ZipArchive::CREATE);

        foreach ($tableIds as $tableId) {
            $fields = GeneratorTableField::whereTableId($tableId)->get();
            $table = GeneratorTable::whereKey($tableId)->first();

            /**
             * Front-End Template File
             */
            $frontEndTemplateContent = $service->toFrontEndTemplateContent($table, $fields);
            Storage::put('front.vue', $frontEndTemplateContent);
            $functionName = Str::camel(Str::singular($table->function_name));
            $frontEndTemplateFileName = 'src/views/' . $table->module_name . '/' . $functionName . '/index.vue';
            $zip->addFile(Storage::path('front.vue'), $frontEndTemplateFileName);
//            Storage::delete('front.vue');

            /**
             * Front-End API File
             */
            $frontEndAPIContent = $service->toFrontEndAPIContent($table);
            Storage::put('front.js', $frontEndAPIContent);
            $frontEndAPIFileName = 'src/api/' . $table->module_name . '/' . $functionName . '.js';
            $zip->addFile(Storage::path('front.js'), $frontEndAPIFileName);
//            Storage::delete('front.js');

            /**
             * SQL File
             */
            $sqlContent = $service->toSqlContent($table);
            Storage::put('data.sql', $sqlContent);
            $sqlContentFileName = $functionName . '.sql';
            $zip->addFile(Storage::path('data.sql'), $sqlContentFileName);
//            Storage::delete('data.sql');
            /**
             * Model File
             */
            // 移除表前缀
            $tableName = str_replace(DB::getTablePrefix(), '', $table->table_name);
            // 获取驼峰class 名称
            $modelClassName = Str::studly(Str::singular($tableName));
            $modelFileName = $modelClassName . '.php';
            // 目前无法重复写入，需要先判断再删除
            if (Storage::exists($modelFileName)) {
                Storage::delete($modelFileName);
            }
            config()->set('generator.model.path', Storage::path(''));
            Artisan::call('chujc:models', ['name' => $tableName]);
            $zip->addFile(Storage::path($modelFileName), 'app/Models/' . $modelFileName);
//            Storage::delete($modelFileName);
            /**
             * Controller File
             */
            $controllerContent = $service->toControllerContent($table, $fields, $modelClassName);
            $controllerFileName = $table->class_name . '.php';
            // 目前无法重复写入，需要先判断再删除
            if (Storage::exists($controllerFileName)) {
                Storage::delete($controllerFileName);
            }
            Storage::put($controllerFileName, $controllerContent);
            $zip->addFile(Storage::path($controllerFileName), 'app/Admin/Controllers/' . $controllerFileName);
//            Storage::delete($controllerFileName);
            /**
             * Export Excel File
             */
            if ($table->is_export) {
                $exportContent = $service->toExportContent($fields, $modelClassName);
                $exportFileName = $modelClassName . 'Export.php';
                // 目前无法重复写入，需要先判断再删除
                if (Storage::exists($exportFileName)) {
                    Storage::delete($exportFileName);
                }
                Storage::put($exportFileName, $exportContent);
                $zip->addFile(Storage::path($exportFileName), 'app/Exports/' . $exportFileName);
//                Storage::delete($exportFileName);
            }

            /**
             * Route File
             * README.md
             */
            $readmeContent = $service->toReadmeContent($table);
            $readmeFileName = $table->function_name . '.readme.md';
            // 目前无法重复写入，需要先判断再删除
            if (Storage::exists($readmeFileName)) {
                Storage::delete($readmeFileName);
            }
            Storage::put($readmeFileName, $readmeContent);
            $zip->addFile(Storage::path($readmeFileName), $readmeFileName);
//            Storage::delete($readmeFileName);
        }
        $zip->close();

        return Storage::download($zipFileName);
    }

}
