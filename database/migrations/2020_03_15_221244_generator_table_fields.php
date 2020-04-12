<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class GeneratorTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generator_table_fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('field_id')->nullable(false)->comment('编号');
            $table->string('table_id', 64)->nullable(false)->comment('归属表编号');
            $table->string('field_name', 200)->nullable()->default(null)->comment('列名称');
            $table->string('field_comment', 500)->nullable()->default(null)->comment('列描述');
            $table->string('field_type', 100)->nullable()->default(null)->comment('列类型');
            $table->boolean('is_pk')->nullable()->default(0)->comment('是否主键（1是）');
            $table->boolean('is_increment')->nullable()->default(0)->comment('是否自增（1是）');
            $table->boolean('is_required')->nullable()->default(1)->comment('是否必填（1是）');
            $table->boolean('is_insert')->nullable()->default(1)->comment('是否为插入字段（1是）');
            $table->boolean('is_edit')->nullable()->default(1)->comment('是否编辑字段（1是）');
            $table->boolean('is_list')->nullable()->default(1)->comment('是否列表字段（1是）');
            $table->boolean('is_query')->nullable()->default(1)->comment('是否查询字段（1是）');
            $table->boolean('is_export')->nullable()->default(0)->comment('是否导出字段（1是）');
            $table->string('query_type', 200)->nullable()->default('=')->comment('查询方式（等于、不等于、大于、小于、范围）');
            $table->string('html_type', 200)->nullable()->default('input')->comment('显示类型（文本框、文本域、下拉框、复选框、单选框、日期控件）');
            $table->string('dict_type', 200)->nullable()->default('')->comment('字典类型');
            $table->unsignedInteger('order')->nullable()->default(null)->comment('排序');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->unsignedBigInteger('created_by')->nullable()->default(0)->comment('创建者');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');
            $table->unsignedBigInteger('updated_by')->nullable()->default(0)->comment('更新者');

        });
        $tableName = fullTableName('generator_table_fields');
        DB::statement("alter table `{$tableName}` comment '代码生成业务表字段'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generator_table_fields');
    }
}
