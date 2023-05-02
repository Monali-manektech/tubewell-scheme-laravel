{!! Form::open(['route' => ['gram-panchayats.destroy', [$data->master_phase_slug, $data->id]], 'method' => 'get', 'id' => "panchayat-form-$data->id"]) !!}
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('gram-panchayats.edit', [$data->master_phase_slug, $data->id]) }}" title="Edit Gram Panchayat">
        <i class='fas fa-pen pr-0'></i>
    </a>
    <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete Gram Panchayat">
        <i class='fas fa-trash-alt pr-0'></i>
    </button>
{!! Form::close() !!}
