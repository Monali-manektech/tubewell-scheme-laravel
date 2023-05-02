<div class="d-flex">
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('legend.edit', [$data->master_phase_slug, $data->id]) }}" title="Edit Item">
        <i class='fas fa-pen pr-0'></i>
    </a>
    {!! Form::open(['route'=>['legend.destroy', [$data->master_phase_slug, $data->id]], 'method' => 'get', 'id'=>"item-form-$data->id"]) !!}
        <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete Item">
            <i class='fas fa-trash-alt pr-0'></i>
        </button>
    {!! Form::close() !!}
</div>
