{!! $php !!}

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class {{ $className }}Export implements FromCollection, WithMapping, WithHeadings
{
use Exportable;

private $collection;

public function __construct($collection)
{
$this->collection = $collection;
}

/**
* @return \Illuminate\Support\Collection
*/
public function collection()
{
return $this->collection;
}

public function map($row): array
{
return [
@foreach($columns as $column)
    @if($column->is_export)
        $row->{{ $column->field_name }},
    @endif
@endforeach
];
}

public function headings(): array
{
return [
@foreach($columns as $column)
    @if($column->is_export)
        '{{ $column->field_comment }}',
    @endif
@endforeach
];
}
}
