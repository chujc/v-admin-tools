<?php

namespace ChuJC\Admin\Services;


use Carbon\Carbon;
use ChuJC\Admin\Models\GeneratorTable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GeneratorService
{
    private $templatePath = 'packages/chujc/v-admin-tools/src/resources';

    /**
     * @param GeneratorTable $table
     * @param Collection $fields
     * @return mixed
     * @author john_chu
     */
    public function toFrontEndTemplateContent(GeneratorTable $table, Collection $fields)
    {
        $pk = $fields->filter(function ($column) {
            if ($column->is_pk) {
                return $column->field_name;
            }
        })->pluck('field_name')->first();

        $upperFunctionName = Str::studly(Str::singular($table->function_name));
        $lowerFunctionName = Str::camel(Str::singular($table->function_name));
        $lowerPluralFunctionName = Str::lower(Str::plural($table->function_name));
        $view = view()
            ->file(
                base_path($this->getTemplatePath('vue/index.vue.blade.php')),
                [
                    'columns' => $fields,
                    'table' => $table,
                    'pk' => $pk,
                    'upperFunctionName' => $upperFunctionName,
                    'lowerFunctionName' => $lowerFunctionName,
                    'lowerPluralFunctionName' => $lowerPluralFunctionName,
                ]
            );

        return $view->toHtml();
    }

    /**
     * @param GeneratorTable $table
     * @param Collection $fields
     * @return mixed
     * @author john_chu
     */
    public function toFrontEndAPIContent(GeneratorTable $table)
    {
        $upperFunctionName = Str::studly(Str::singular($table->function_name));

        $view = view()
            ->file(
                base_path($this->getTemplatePath('js/api.js.blade.php')),
                [
                    'table' => $table,
                    'upperFunctionName' => $upperFunctionName,
                ]
            );

        return $view->toHtml();
    }

    /**
     * @param GeneratorTable $table
     * @param Collection $fields
     * @return mixed
     * @author john_chu
     */
    public function toSqlContent(GeneratorTable $table)
    {
        $functionName = Str::camel(Str::singular($table->function_name));
        $view = view()
            ->file(
                base_path($this->getTemplatePath('sql/sql.blade.php')),
                [
                    'table' => $table,
                    'now' => Carbon::now()->toDateTimeString(),
                    'functionName' => $functionName
                ]
            );

        return $view->toHtml();
    }

    /**
     * @param GeneratorTable $table
     * @param Collection $fields
     * @param $model
     * @return mixed
     * @author john_chu
     */
    public function toControllerContent(GeneratorTable $table, Collection $fields, $model)
    {
        $view = view()
            ->file(
                base_path($this->getTemplatePath('controller/controller.blade.php')),
                [
                    'php' => '<?php',
                    'columns' => $fields,
                    'table' => $table,
                    'model' => $model,
                ]
            );

        return $view->toHtml();
    }

    /**
     * @param Collection $fields
     * @param $className
     * @return mixed
     * @author john_chu
     */
    public function toExportContent(Collection $fields, $className)
    {
        $view = view()
            ->file(
                base_path($this->getTemplatePath('export/export.blade.php')),
                [
                    'php' => '<?php',
                    'columns' => $fields,
                    'className' => $className,
                ]
            );

        return $view->toHtml();
    }

    /**
     * @param GeneratorTable $table
     * @return mixed
     * @author john_chu
     */
    public function toReadmeContent(GeneratorTable $table)
    {
        $lowerPluralFunctionName = Str::lower(Str::plural($table->function_name));

        $view = view()
            ->file(
                base_path($this->getTemplatePath('readme.md.blade.php')),
                [
                    'table' => $table,
                    'show' => '@show',
                    'lowerPluralFunctionName' => $lowerPluralFunctionName,
                ]
            );

        return $view->toHtml();
    }


    /**
     * @param $file
     * @return string
     */
    private function getTemplatePath($file)
    {
        return $this->templatePath . '/' . $file;
    }
}
