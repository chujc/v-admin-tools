<?php
/**
 * Class GeneratorTableField
 * @package ChuJC\Admin\Models;
 * @date 2020-04-04
 */

namespace ChuJC\Admin\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * ChuJC\Admin\Models\GeneratorTableField
 *
 * @property int $field_id 编号
 * @property string $table_id 归属表编号
 * @property string|null $field_name 列名称
 * @property string|null $field_comment 列描述
 * @property string|null $field_type 列类型
 * @property int|null $is_pk 是否主键（1是）
 * @property int|null $is_increment 是否自增（1是）
 * @property int|null $is_required 是否必填（1是）
 * @property int|null $is_insert 是否为插入字段（1是）
 * @property int|null $is_edit 是否编辑字段（1是）
 * @property int|null $is_list 是否列表字段（1是）
 * @property int|null $is_query 是否查询字段（1是）
 * @property int|null $is_export 是否导出字段（1是）
 * @property string|null $query_type 查询方式（等于、不等于、大于、小于、范围）
 * @property string|null $html_type 显示类型（文本框、文本域、下拉框、复选框、单选框、日期控件）
 * @property string|null $dict_type 字典类型
 * @property int|null $order 排序
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property int|null $created_by 创建者
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property int|null $updated_by 更新者
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField wherefieldComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField wherefieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField wherefieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField wherefieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereDictType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereHtmlType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsIncrement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsInsert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsPk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereQueryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ChuJC\Admin\Models\GeneratorTableField whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class GeneratorTableField extends Model
{
    protected $table = 'generator_table_fields';

    protected $primaryKey = 'field_id';

    protected $fillable = [
        'table_id',
        'field_name',
        'field_comment',
        'field_type',
        'is_pk',
        'is_increment',
        'is_required',
        'is_insert',
        'is_edit',
        'is_list',
        'is_query',
        'is_export',
        'query_type',
        'html_type',
        'dict_type',
        'order',
        'created_by',
        'updated_by'
    ];
}
