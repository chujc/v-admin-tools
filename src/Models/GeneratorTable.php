<?php
/**
 * Class GeneratorTable
 * @package ChuJC\Admin\Models
 * @date 2020-04-04
 */

namespace ChuJC\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ChuJC\Admin\Models\GeneratorTable
 *
 * @property int $table_id 编号
 * @property string|null $table_name 表名称
 * @property string|null $table_comment 表描述
 * @property string|null $template 使用的模板
 * @property string|null $class_name 控制器名称
 * @property string|null $class_namespace 控制器命名空间
 * @property string|null $model_name 模型名称
 * @property string|null $model_namespace 模型命名空间
 * @property int|null $is_export 是否导出
 * @property int|null $is_selection 是否多选
 * @property string|null $module_name 生成模块名
 * @property string|null $function_name 生成功能名
 * @property string|null $function_author 生成功能作者
 * @property string|null $options 其它生成选项
 * @property string|null $remark 备注
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property int|null $created_by 创建者
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property int|null $updated_by 更新者
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable newQuery()
 * @method static \Illuminate\Database\Query\Builder|\ChuJC\Admin\Models\GeneratorTable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereClassNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereFunctionAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereFunctionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereIsExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereIsSelection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereModelNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereTableComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTable whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\ChuJC\Admin\Models\GeneratorTable withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\ChuJC\Admin\Models\GeneratorTable withoutTrashed()
 * @mixin \Eloquent
 */
class GeneratorTable extends Model
{
    use SoftDeletes;

    protected $table = 'generator_tables';

    protected $primaryKey = 'table_id';

    protected $fillable = [
        'table_name',
        'table_comment',
        'template',
        'class_name',
        'class_namespace',
        'model_name',
        'model_namespace',
        'is_export',
        'is_selection',
        'module_name',
        'function_name',
        'function_author',
        'options',
        'remark',
        'created_by',
        'updated_by'
    ];
}
