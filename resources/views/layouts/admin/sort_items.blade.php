@extends('layouts.admin.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.css') }}">
    <style>
        ul {
            list-style: none;
        }

        li > div {
            border: 1px solid;
            padding: 6px 6px;
            margin: 2px;
        }
    </style>
@endpush
@section('contents')
<div class="card">
    <div class="card-header">
    </div>
  <div class="card-body">
    <ul id="draggable">
        @foreach ($items as $item)
            <li data-id="{{ $item->id }}">
                <div>{{ $item->item_no }}</div>
                @if (isset($item->ChildItems) && $item->ChildItems->count() > 0)
                    <ul data-id="{{ $item->id }}">
                        @foreach ($item->ChildItems as $subItem)
                            <li data-id="{{ $subItem->id }}">
                                <div>{{ $subItem->item_no }}</div>
                            
                                @if (isset($subItem->ChildItems) && $subItem->ChildItems->count() > 0)
                                    <ul data-id="{{ $subItem->id }}">
                                        @foreach ($subItem->ChildItems as $subSubItem)
                                            <li data-id="{{ $subSubItem->id }}">
                                                <div>{{ $subSubItem->item_no }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
  </div>
</div>
@endsection
@push('js')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js.map"></script> --}}
    <script>
        $( function() {
            $( "#draggable" ).sortable({
                items: 'li',
                toleranceElement: '> div'
            });
        });
    </script>
@endpush