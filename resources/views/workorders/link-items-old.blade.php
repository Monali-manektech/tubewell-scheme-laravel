@extends('layouts.admin.app')
@section('contents')
@php
    foreach($items as $item){
        $totalNchild = 0;
        $item->totalNCount = $totalNchild;

        if(isset($item->ItemDetailsParent) && count($item->ItemDetailsParent) > 0){
            foreach($item->ItemDetailsParent as $itemDetail){
                $totalNchild = $totalNchild + ($itemDetail->item_detail_childs_count != 0 ? $itemDetail->item_detail_childs_count : 1);
            }
            $item->totalNCount = $totalNchild;
        }
    }
@endphp
<div class="card h-100">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <h5>Scheme: {{ $workOrder->name }}</h5>
            </div>
            <div class="col-md-4">
                <h5>Block: {{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->blocks : null }}</h5>
            </div>
            <div class="col-md-4">
                <h5>Gram Panchayat: {{ $workOrder->GramPanchayat ? $workOrder->GramPanchayat->name : null }}</h5>
            </div>
        </div>
    </div>
    <div class="card-body" style="overflow-x: scroll">
        {!! Form::open(['route' => ['work-orders.StoreLinkItems', $workOrder]]) !!}
        <input type="hidden" name="previous_item_ids" value="{{ implode(',', $workOrderItemsID) }}">
        <div class="row pb-3">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success">Link Items</button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Item Number</th>
                    <th>Link</th>
                    <th>Discipline</th>
                    <th>Legend</th>
                    <th>Item Description</th>
                    <th>Units</th>
                    <th>Subitem Counts</th>
                    <th>Qty</th>
                    <th>Rate Per Unit</th>
                    <th>Total Rate</th>
                    <th>% of Payment allowed as per RFP</th>
                    <th>Proposed billing Breakup / % of Payment Proposed</th>
                    <th>Proposed billing Breakup / % of Payment Proposed</th>
                    {{-- <th scope="col">
                        <table>
                            <tr>
                                <td width="50%"></td>
                                <td width="50%"></td>
                            </tr>
                        </table>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @php
                    $checkOuterIteration = 0;
                    $checkInnerIteration = 0;
                @endphp
                @forelse ($items as $key => $item)
                    <tr>
                        @php
                            // dd($item);
                            // $endItemDetailCount = 
                            //     (isset($item->ItemDetailsParent[$key]) ? $item->ItemDetailsParent[$key]->ItemDetailChilds->count() : 0);
                            // $currentItemParentCount = $item->ItemDetailsParent->count();

                            // $rowCount = $endItemDetailCount * $currentItemParentCount + ($currentItemParentCount + 1) ;
                            $itemDetailsParentRemaining = $item->ItemDetailsParent->filter(function($itemDetailsParent, $key) {
                                if($key > 0) {
                                    return $itemDetailsParent;
                                }
                            });
                            
                            $rowCount = $item->totalNCount + $itemDetailsParentRemaining->count();

                            $itemDetailsParentFirst = $item->ItemDetailsParent->first();
                            $itemDetailsChildFirst = $itemDetailsParentFirst->ItemDetailChilds->first();

                            $item->ItemDetailsParent[0]->is_first = true;
                            $item->ItemDetailsParent[0]->ItemDetailChilds[0]->is_first = true;

                        @endphp

                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>
                            <input type="checkbox" name="item[{{ $item->id }}]" 
                            @checked(in_array($item->id, $workOrderItemsID))>
                        </td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->item_no }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->link }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->discipline }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->legend }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ Str::limit($item->description, 100) }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->Unit ? $item->Unit->name : null}}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->child_items_count }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->quantity }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->rate }}</td>
                        <td @if($rowCount > 0) rowspan="{{ $rowCount }}"  @endif>{{ $item->rate*$item->quantity }}</td>
                        <td 
                            @if($itemDetailsParentFirst->ItemDetailChilds->count() > 0) 
                                rowspan="{{ ($itemDetailsParentFirst->ItemDetailChilds->count()) }}" 
                            @endif>
                            
                            @if(isset($itemDetailsParentFirst)) 
                                {{ $itemDetailsParentFirst->item_praposed }}
                            @else
                                - 
                            @endif
                        </td>

                        <td>
                            {{ $itemDetailsChildFirst->name ?? '-' }}
                        </td>
                        <td>
                            {{ $itemDetailsChildFirst->percentage ?? '-' }}
                        </td>
                    </tr>
                    @forelse ($item->ItemDetailsParent as $k => $itemDetail)
                        @if (!isset($itemDetail->is_first))
                            <tr>
                                <td @if($itemDetail->ItemDetailChilds->count() > 0) rowspan="{{ ($itemDetail->ItemDetailChilds->count() + 1) }}" @endif>{{ $itemDetail->item_praposed }}</td>
                                {{-- <td>{{ $itemDetail->item_praposed }}</td> --}}
                                
                                @if($itemDetail->ItemDetailChilds->count() == 0)
                                    <td>-</td>
                                    <td>-</td>
                                @endif
                            </tr>
                        @endif
                        @forelse ($itemDetail->ItemDetailChilds as $c_key => $itemDetailChild)
                            @if(!isset($itemDetailChild->is_first))
                                <tr>
                                    <td>{{ $itemDetailChild->name }}</td>    
                                    <td>{{ $itemDetailChild->percentage }}%</td>   
                                </tr> 
                            @endif
                        @empty
                        @endforelse
                    @empty
                    @endforelse
                @empty
                    <tr>
                        <td colspan="14">No Data Available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="row pt-3">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success">Link Items</button>
            </div>
        </div>
    </div>
</div>
@endsection