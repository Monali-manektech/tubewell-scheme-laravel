
@forelse ($itemDetailChild as $child)
    @php
        $childWorkDoneRAQuantity = $workDoneRA[$child->id]['quantity'] ?? 0;
        $childWorkDoneRAAmount = $workDoneRA[$child->id]['amount'] ?? 0; ;
        $balanceWorkDoneQTY = $item->quantity - $childWorkDoneRAQuantity;
        $balanceWorkDoneAmount = $item->quantity - $childWorkDoneRAQuantity;
    @endphp
    <tr>
        <td>{{ $child->name }}</td>
        <td>{{ $child->percentage }}%</td>
        @forelse ($workOrderRas as $workOrderRa)
            @if (isset($child->id))
                <td> {{ $workOrderRasLink[$workOrderRa->id][$child->id]['quantity'] ?? 0 }} </td>
                <td> {{ isset($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) ? format_amount($workOrderRasLink[$workOrderRa->id][$child->id]['amount']) : 0 }} </td>
            @else
                <td>0</td>
                <td>0</td>
            @endif
        @empty
        @endforelse

        <td>{{ $childWorkDoneRAQuantity }}</td>
        <td>{{ format_amount($childWorkDoneRAAmount) }}</td>
        <td>{{ $balanceWorkDoneQTY }}</td>
        <td>{{ format_amount($balanceWorkDoneAmount) }}</td>
    </tr>
@empty
    
@endforelse