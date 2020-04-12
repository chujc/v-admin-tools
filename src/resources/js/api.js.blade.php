import request from '@/utils/request'

// 查询{{ $table->table_comment }}列表
export function list{{ $upperFunctionName }}(query) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}',
method: 'get',
params: query
})
}

// 查询{{ $table->table_comment }}详细
export function get{{ $upperFunctionName }}(id) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}/' + id,
method: 'get'
})
}

// 新增{{ $table->table_comment }}
export function add{{ $upperFunctionName }}(data) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}',
method: 'post',
data: data
})
}

// 修改{{ $table->table_comment }}
export function update{{ $upperFunctionName }}(id, data) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}/' + id,
method: 'put',
data: data
})
}

// 删除{{ $table->table_comment }}
export function del{{ $upperFunctionName }}(id) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}/' + id,
method: 'delete'
})
}

// 导出{{ $table->table_comment }}
export function export{{ $upperFunctionName }}(query) {
return request({
url: '/{{ $table->module_name }}/{{ $table->function_name }}/export/excel',
method: 'get',
params: query
})
}
