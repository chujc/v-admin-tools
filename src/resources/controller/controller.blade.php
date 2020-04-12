{!! $php !!}

namespace App\Admin\Controllers;

use ChuJC\Admin\Support\Result;
use Illuminate\Http\Request;
use App\Models\{{ $model }};
@if($table->is_export)
    use App\Exports\{{ $model }}Export;
    use Illuminate\Support\Collection;
@endif

class {{ $table->class_name }}
{

protected $model = {{ $model }}::class;

/**
* 角色列表
* @param Request $request
* @return \Illuminate\Http\JsonResponse
*/
public function index(Request $request)
{
$perPage = $request->input('per_page');

$data = $this->search($request)->paginate($perPage);

return Result::data($data);
}

/**
* 详情
* @param $id
* @return \Illuminate\Http\JsonResponse
*/
public function show($id)
{
return Result::data($this->model::query()->whereKey($id)->first());
}

/**
* 创建
* @param Request $request
* @return \Illuminate\Http\JsonResponse
* @throws \ChuJC\Admin\Exceptions\ValidaException
*/
public function store(Request $request)
{
$params = $request->only([
@foreach($columns as $column)
    @if($column->is_insert)
        '{{ $column->field_name }}',
    @endif
@endforeach
]);

$model = $this->model::create($params);

if ($model) {
return Result::success('创建成功');
}

return Result::failed('创建失败，请稍后再试！');
}

/**
* 更新
* @param Request $request
* @param $id
* @return \Illuminate\Http\JsonResponse
*/
public function update(Request $request, $id)
{
$params = $request->only([
@foreach($columns as $column)
    @if($column->is_edit)
        '{{ $column->field_name }}',
    @endif
@endforeach
]);

if ($this->model::whereKey($id)->update($params)) {
return Result::success('修改成功');
}

return Result::failed('修改失败');
}

/**
* 删除
* @param $id
* @return \Illuminate\Http\JsonResponse
*/
public function destroy($id)
{
if ($this->model::whereKey($id)->delete()) {
return Result::success('删除成功');
}
return Result::failed('删除失败');
}
@if($table->is_export)
    /**
    * 导出
    * @param Request $request
    * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
    */
    public function export(Request $request)
    {
    $command = $request->input('command');
    switch (strtoupper($command)) {
    case 'PAGE':
    $perPage = $request->input('per_page');
    $collection = Collection::make($this->search($request)->paginate($perPage)->items());
    break;
    case 'SELECT':
    $ids = $request->input('ids');
    $ids = explode(',', $ids);
    $collection = $this->search($request)->whereKey($ids)->get();
    break;
    default:
    $collection = $this->search($request)->get();
    }
    $filename = date('YmdHis') . '{{ $model }}.xlsx';
    return (new {{ $model }}Export($collection))->download($filename);
    }
@endif
/**
* @param Request $request
* @return \Illuminate\Database\Eloquent\Builder|mixed
*/
protected function search(Request $request)
{
$params = $request->all();
$searchField = [
@foreach($columns as $column)
    @if($column->is_query)
        '{{ $column->field_name }}' => '{{ $column->query_type }}',
    @endif
@endforeach
];
return searchModelDateRange(searchModelField($this->model::query(), $params, $searchField), $params)->orderBy((new $this->model)->getKeyName());
}

}
