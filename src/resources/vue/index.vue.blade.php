<template>
    <div class="app-container">
        <el-form :model="queryParams" ref="queryForm" :inline="true" label-width="68px">
            @foreach($columns as $column)
                @if($column->is_query)
                    <el-form-item label="{{ $column->field_comment }}" prop="{{ $column->field_name }}">
                        @if($column->html_type == 'input')
                            <el-input
                                v-model="queryParams.{{ $column->field_name }}"
                                placeholder="请输入{{ $column->field_comment }}"
                                clearable
                                size="small"
                                @keyup.enter.native="handleQuery"
                            />
                        @elseif(($column->html_type == 'select' || $column->html_type == "radio" || $column->html_type == "switch" ||  $column->html_type == "checkbox") && $column->dict_type)
                            <el-select v-model="queryParams.{{ $column->field_name }}"
                                       placeholder="请选择{{ $column->field_comment }}" clearable size="small">
                                <el-option
                                    v-for="dict in {{ $column->field_name }}Options"
                                    :key="dict.dict_value"
                                    :label="dict.dict_label"
                                    :value="dict.dict_value"
                                />
                            </el-select>
                        @elseif(($column->html_type == 'select' || $column->html_type == "radio" || $column->html_type == "switch" ||  $column->html_type == "checkbox") && !$column->dict_type)
                            <el-select v-model="queryParams.{{ $column->field_name }}"
                                       placeholder="请选择{{ $column->field_comment }}" clearable size="small">
                                <el-option label="请选择字典生成" value=""/>
                            </el-select>
                        @elseif($column->html_type == 'datetime' || $column->field_type == 'datetime' || $column->field_type = 'timestamp')
                            <el-date-picker
                                clearable size="small" style="width: 200px"
                                v-model="queryParams.{{ $column->field_name }}"
                                @if($column->query_type == 'BETWEEN')
                                type="daterange"
                                @else
                                type="date"
                                @endif
                                value-format="yyyy-MM-dd"
                                placeholder="选择{{ $column->field_comment }}">
                            </el-date-picker>
                        @else
                            <el-input
                                v-model="queryParams.{{ $column->field_name }}"
                                placeholder="请输入{{ $column->field_comment }}"
                                clearable
                                size="small"
                                @keyup.enter.native="handleQuery"
                            />
                        @endif
                    </el-form-item>
                @endif
            @endforeach
            <el-form-item>
                <el-button type="primary" icon="el-icon-search" size="mini" @click="handleQuery">搜索</el-button>
                <el-button icon="el-icon-refresh" size="mini" @click="resetQuery">重置</el-button>
            </el-form-item>
        </el-form>
        <el-row :gutter="10" class="mb8">
            <el-col :span="1.5">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="handleAdd"
                    v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.store']"
                >新增
                </el-button>
            </el-col>
            <el-col :span="1.5">
                <el-button
                    type="primary"
                    icon="el-icon-edit"
                    size="mini"
                    :disabled="single"
                    @click="handleUpdate"
                    v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.update']"
                >修改
                </el-button>
            </el-col>
            <el-col :span="1.5">
                <el-button
                    type="danger"
                    icon="el-icon-delete"
                    size="mini"
                    :disabled="multiple"
                    @click="handleDelete"
                    v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.destroy']"
                >删除
                </el-button>
            </el-col>
            @if($table->is_export)
                <el-col :span="1.5">
                    <el-dropdown trigger="click" @command="handleExport"
                                 v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.export']">
                        <el-button type="warning" size="mini">
                            导出<i class="el-icon-arrow-down el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item command="all"> 全部</el-dropdown-item>
                            <el-dropdown-item command="page">当前页</el-dropdown-item>
                            <el-dropdown-item command="select" :disabled="multiple">选择项</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </el-col>
            @endif
        </el-row>

        <el-table v-loading="loading" :data="{{ $lowerFunctionName }}List"
                  @if($table->is_selection)@selection-change="handleSelectionChange"@endif>
            @if($table->is_selection)
                <el-table-column type="selection" width="60" align="center"/>@endif
            @foreach($columns as $column)
                @if($column->is_list && $column->is_pk)

                    <el-table-column label="{{ $column->field_comment }}" align="center"
                                     prop="{{ $column->field_name }}"/>
                @elseif($column->is_list && ($column->html_type == 'datetime' || $column->html_type == 'timestamp'))

                    <el-table-column label="{{ $column->field_comment }}" align="center"
                                     prop="{{ $column->field_name }}" width="180"/>
                @elseif($column->is_list && $column->dict_type)

                    <el-table-column label="{{ $column->field_comment }}" align="center"
                                     prop="{{ $column->field_name }}" :formatter="{{ $column->field_name }}Format"/>
                @elseif($column->is_list)

                    <el-table-column label="{{ $column->field_comment }}" align="center"
                                     prop="{{ $column->field_name }}"/>
                @endif
            @endforeach

            <el-table-column label="操作" align="center" class-name="small-padding fixed-width">
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        icon="el-icon-edit"
                        @click="handleUpdate(scope.row)"
                        v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.update']"
                    >修改
                    </el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        icon="el-icon-delete"
                        @click="handleDelete(scope.row)"
                        v-has-permission="['{{ $table->module_name }}.{{ $lowerPluralFunctionName }}.destroy']"
                    >删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination
            v-show="total>0"
            :total="total"
            :page.sync="queryParams.page"
            :limit.sync="queryParams.per_page"
            @pagination="getList"
        />

    <!-- 添加或修改{{ $table->table_comment }}对话框 -->
        <el-dialog :title="title" :visible.sync="open" width="800px">
            <el-form ref="form" :model="form" :rules="rules" label-width="80px">
                @foreach($columns as $column)
                    @if($column->html_type == 'input')
                        <el-form-item label="{{ $column->field_comment }}" prop="{{ $column->field_name }}">
                            <el-input v-model="form.{{ $column->field_name }}"
                                      placeholder="请输入{{ $column->field_comment }}"/>
                        </el-form-item>
                    @elseif($column->html_type == "select" && $column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-select v-model="form.{{ $column->field_name }}"
                                       placeholder="请选择{{ $column->field_comment }}">
                                <el-option
                                    v-for="dict in {{ $column->field_name }}Options"
                                    :key="dict.dict_value"
                                    :label="dict.dict_label"
                                    :value="dict.dict_value"
                                ></el-option>
                            </el-select>
                        </el-form-item>
                    @elseif($column->html_type == "select" && !$column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-select v-model="form.{{ $column->field_name }}"
                                       placeholder="请选择{{ $column->field_comment }}">
                                <el-option label="请选择字典生成" value=""/>
                            </el-select>
                        </el-form-item>
                    @elseif($column->html_type == "radio" && $column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-radio-group v-model="form.{{ $column->field_name }}">
                                <el-radio
                                    v-for="dict in {{ $column->field_name }}Options"
                                    :key="dict.dict_value"
                                    :label="dict.dict_value"
                                />
                            </el-radio-group>
                        </el-form-item>
                    @elseif($column->html_type == "radio" && !$column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-radio-group v-model="form.{{ $column->field_name }}">
                                <el-radio label="1">请选择字典生成</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    @elseif($column->html_type == "checkbox" && $column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-checkbox-group v-model="form.{{ $column->field_name }}">
                                <el-checkbox
                                    v-for="dict in {{ $column->field_name }}Options"
                                    :key="dict.dict_value"
                                    :label="dict.dict_value"
                                >@{{ dict.dict_value }}
                                </el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                    @elseif($column->html_type == "checkbox" && !$column->dict_type)
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-checkbox-group v-model="form.{{ $column->field_name }}">
                                <el-checkbox>请选择字典生成</el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                    @elseif($column->html_type == "switch")
                        <el-form-item label="{{ $column->field_comment }}">
                            <el-switch
                                v-model="form.{{ $column->field_name }}"
                                :active-value=1
                                :inactive-value=0
                            />
                        </el-form-item>
                    @elseif($column->html_type == "datetime")
                        <el-form-item label="{{ $column->field_comment }}" prop="{{ $column->field_name }}">
                            <el-date-picker clearable size="small" style="width: 200px"
                                            v-model="form.{{ $column->field_name }}"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            placeholder="选择{{ $column->field_comment }}">
                            </el-date-picker>
                        </el-form-item>
                    @elseif($column->html_type == "textarea")
                        <el-form-item label="{{ $column->field_comment }}" prop="{{ $column->field_name }}">
                            <el-input v-model="form.{{ $column->field_name }}" type="textarea" placeholder="请输入内容"/>
                        </el-form-item>
                    @elseif($column->html_type == "richtext" && $richText = 1)
                        <el-form-item label="{{ $column->field_comment }}" prop="{{ $column->field_name }}">
                            <Tinymce v-model="form.{{ $column->field_name }}" :height="400"/>
                        </el-form-item>
                    @endif
                @endforeach
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitForm">确 定</el-button>
                <el-button @click="cancel">取 消</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
        @if(isset($richText) && $richText)
    import Tinymce from '@/components/Tinymce'
        @endif
    import {
        list{{ $upperFunctionName }},
        get{{ $upperFunctionName }},
        del{{ $upperFunctionName }},
        add{{ $upperFunctionName }},
        update{{ $upperFunctionName }} @if($table->is_export),
        export{{ $upperFunctionName }}@endif

    } from "@/api/{{ $table->module_name }}/{{ $lowerFunctionName }}";

    export default {
        name: "{{ $upperFunctionName }}",
        @if(isset($richText) && $richText)
        components: {
            Tinymce
        },
        @endif
        data() {
            return {
                // 遮罩层
                loading: true,
                // 选中数组
                ids: [],
                // 非单个禁用
                single: true,
                // 非多个禁用
                multiple: true,
                // 总条数
                total: 0,
                // {{ $lowerFunctionName }}表格数据
                {{ $lowerFunctionName }}List: [],
                // 弹出层标题
                title: "",
                // 是否显示弹出层
                open: false,
                @foreach ($columns as $column)
                @if($column->dict_type != '')
                // $comment字典
                {{ $column->field_name }}Options: [],
                @endif
                @endforeach
                // 查询参数
                queryParams: {
                    page: 1,
                    per_page: 10,
            @foreach ($columns as $column)
            @if($column->is_query)
            {{ $column->field_name }}:
            undefined,
            @endif
            @endforeach
        },
            // 表单参数
            form: {
            }
        ,
            // 表单校验
            rules: {
                @foreach ($columns as $column)
                @if($column->is_required)
                {{ $column->field_name }}:
                [
                    {required: true, message: "{{ $column->field_comment }}不能为空", trigger: "blur"}
                ],
                @endif
                @endforeach
            }
        }
            ;
        },
        created() {
            this.getList();
            @foreach ($columns as $column)
                @if($column->dict_type)
                this.getDicts("{{$column->dict_type}}").then(response => {
                this.{{ $column->field_name }}Options = response.data;
            });
            @endif
            @endforeach
        },
        methods: {
            /** 查询{{ $table->table_comment }}列表 */
            getList() {
                this.loading = true;
                list{{ $upperFunctionName }}(this.queryParams).then(response => {
                    this.{{ $lowerFunctionName }}List = response.data;
                    this.total = response.total;
                    this.loading = false;
                });
            },
            @foreach ($columns as $column)
            @if($column->dict_type)
            // {{ $column->field_comment }}字典翻译
            {{ $column->field_name }}Format(row, column) {
                return this.selectDictLabel(this.{{ $column->field_name }}Options, row.{{ $column->field_name }});
            },
            @endif
            @endforeach
            // 取消按钮
            cancel() {
                this.open = false;
                this.reset();
            },
            // 表单重置
            reset() {
                this.form = {
                @foreach ($columns as $column)
                @if($column->html_type == "radio")
                {{$column->field_name}}:
                0,
                @else
                {{$column->field_name}}:
                undefined,
                @endif
                @endforeach
            }
                ;
                this.resetForm("form");
            },
            /** 搜索按钮操作 */
            handleQuery() {
                this.queryParams.page = 1;
                this.getList();
            },
            /** 重置按钮操作 */
            resetQuery() {
                this.resetForm("queryForm");
                this.handleQuery();
            },
            @if($table->is_selection)
            // 多选框选中数据
            handleSelectionChange(selection) {
                this.ids = selection.map(item => item.{{ $pk }})
                this.single = selection.length != 1
                this.multiple = !selection.length
            },
            @endif
            /** 新增按钮操作 */
            handleAdd() {
                this.reset();
                this.open = true;
                this.title = "添加{{ $table->table_comment }}";
            },
            /** 修改按钮操作 */
            handleUpdate(row) {
                this.reset();
                const ids = row.{{ $pk }} || this.ids
                get{{ $upperFunctionName }}(ids).then(response => {
                    this.form = response.data;
                    this.open = true;
                    this.title = "修改{{ $table->table_comment }}";
                });
            },
            /** 提交按钮 */
            submitForm: function () {
                this.$refs["form"].validate(valid => {
                    if (valid) {
                        if (this.form.{{ $pk }} != undefined) {
                            update{{ $upperFunctionName }}(this.form).then(response => {
                                if (response.code === 200) {
                                    this.msgSuccess("修改成功");
                                    this.open = false;
                                    this.getList();
                                } else {
                                    this.msgError(response.msg);
                                }
                            });
                        } else {
                            add{{ $upperFunctionName }}(this.form).then(response => {
                                if (response.code === 200) {
                                    this.msgSuccess("新增成功");
                                    this.open = false;
                                    this.getList();
                                } else {
                                    this.msgError(response.msg);
                                }
                            });
                        }
                    }
                });
            },
            /** 删除按钮操作 */
            handleDelete(row) {
                const ids = row.{{ $pk }} || this.ids;
                this.$confirm('是否确认删除{{ $table->table_comment }}ID为"' + ids + '"的数据项?', "警告", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                }).then(function () {
                    return del{{ $upperFunctionName }}(ids);
                }).then(() => {
                    this.getList();
                    this.msgSuccess("删除成功");
                }).catch(function () {
                });
            }@if($table->is_export),
            /** 导出按钮操作 */
            handleExport(command) {
                const queryParams = {
                    command,
                    ...this.queryParams,
                    ids: this.ids.join(',')
                };
                this.$confirm('是否确认导出{{ $table->table_comment }}数据项?', "提醒", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                }).then(function () {
                    return
                export
                    {{ $upperFunctionName }}(queryParams);
                }).then(response => {
                    this.download(response.message);
                }).catch(function () {
                });
            }@endif

        }
    };
</script>
