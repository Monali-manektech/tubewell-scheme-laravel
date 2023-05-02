{!! Form::open(['route' => ['work-orders.destroy', $data], 'method' => 'delete', 'id' => "workorder-form-$data->id"]) !!}
    <a class='btn btn-sm btn-secondary m-1 edit' href="{{ route('work-orders.linkRaDetails', $data->id) }}" title="view work order">
        <i class="fa fa-eye"></i>
    </a>
    <a class='btn btn-sm btn-primary m-1 edit' href="{{ route('work-orders.edit', $data) }}" title="Edit work order">
        <i class='fas fa-pen pr-0'></i>
    </a>
    <button class='btn btn-sm btn-danger m-1 delete' data-id="{{ $data->id }}" type="submit" title="Delete work Order">
        <i class='fas fa-trash-alt pr-0'></i>
    </button>
    <a class='btn btn-sm btn-info m-1 edit' href="{{ route('work-orders.linkItems', $data) }}" title="Link Items">
        <i class="fa fa-plus-circle"></i>
    </a>
    <a class='btn btn-sm btn-warning m-1 edit' href="{{ route('ra.index', $data) }}" title="View RA">
        <i class="fa fa-money-check-alt"></i>
    </a>
{!! Form::close() !!}
