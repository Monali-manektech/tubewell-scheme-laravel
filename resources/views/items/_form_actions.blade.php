<div class="d-flex">
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('items.edit', [$data->master_phase_slug, $data->id]) }}" title="Edit Item">
        <i class='fas fa-pen pr-0'></i>
    </a>
    <a class='btn btn-sm btn-info m-1' href="{{ route('items.create.subitem', [$data->master_phase_slug, $data->id]) }}" title="Add Sub Item">
        <i class="fa fa-plus-circle"></i>
    </a>
    <a class='btn btn-sm btn-info m-1' href="{{ route('items.index', [$data->master_phase_slug, $data->id]) }}" title="View Sub Item">
        <i class="fa fa-eye"></i>
    </a>
    {!! Form::open(['route'=>['items.destroy', [$data->master_phase_slug, $data->id]], 'method' => 'get', 'id'=>"item-form-$data->id"]) !!}
        <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete Item">
            <i class='fas fa-trash-alt pr-0'></i>
        </button>
    {!! Form::close() !!}
</div>
