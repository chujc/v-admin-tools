<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class GeneratorTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generator_tables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('table_id')->nullable(false)->comment('编号');
            $table->string('table_name', 200)->nullable()->default('')->comment('表名称');
            $table->string('table_comment', 500)->nullable()->default('')->comment('表描述');
            $table->string('template', 200)->nullable()->default('crud')->comment('使用的模板');
            $table->string('class_name', 100)->nullable()->default('')->comment('控制器名称');
            $table->string('class_namespace', 255)->nullable()->default(null)->comment('控制器命名空间');
            $table->string('model_name', 100)->nullable()->default('')->comment('模型名称');
            $table->string('model_namespace', 255)->nullable()->default(null)->comment('模型命名空间');
            $table->boolean('is_export')->nullable()->default(null)->comment('是否导出');
            $table->boolean('is_selection')->nullable()->default(null)->comment('是否多选');
            $table->string('module_name', 30)->nullable()->default(null)->comment('生成模块名');
            $table->string('function_name', 50)->nullable()->default(null)->comment('生成功能名');
            $table->string('function_author', 50)->nullable()->default(null)->comment('生成功能作者');
            $table->text('options')->nullable()->comment('其它生成选项');
            $table->string('remark', 500)->nullable()->default(null)->comment('备注');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->unsignedBigInteger('created_by')->nullable()->default(0)->comment('创建者');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');
            $table->unsignedBigInteger('updated_by')->nullable()->default(0)->comment('更新者');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');

        });
        $tableName = fullTableName('generator_tables');
        DB::statement("alter table `{$tableName}` comment '代码生成业务表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generator_tables');
    }
}
