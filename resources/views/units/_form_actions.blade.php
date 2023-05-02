{!! Form::open(['route' => ['units.destroy', [$data->master_phase_slug, $data->id]], 'method' => 'get', 'id' => "unit-form-$data->id"]) !!}
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('units.edit', [$data->master_phase_slug, $data->id]) }}" title="Edit Unit">
        <i class='fas fa-pen pr-0'></i>
    </a>
    <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete Unit">
        <i class='fas fa-trash-alt pr-0'></i>
    </button>
{!! Form::close() !!}
