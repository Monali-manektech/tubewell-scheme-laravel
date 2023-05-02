{!! Form::open(['route' => ['ra.destroy', $data], 'method' => 'delete', 'id' => "ra-form-$data->id"]) !!}
    <a class='btn btn-sm btn-info m-1' href="{{ route('work-orders.linkRaDetails', [$data->work_order_id, $data->id]) }}" title="Update RA Details in work order">
        <i class='fa-solid fa-pen-to-square'></i>
    </a>
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('ra.edit', $data) }}" title="Edit RA">
        <i class='fas fa-pen pr-0'></i>
    </a>
    <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete RA">
        <i class='fas fa-trash-alt pr-0'></i>
    </button>
{!! Form::close() !!}
