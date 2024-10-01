<table class="table table-bordered">
    <thead>
    <tr>
        <th>Amount</th>
        <th>Description</th>
        <th>Date/Time</th>
    </tr>
    </thead>
    <tbody id="item-lists">
    @foreach ($operations as $operation)
        <tr class="{{ $operation->amount >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
            <td>{{ $operation->amount }} EU</td>
            <td>{{ $operation->description }}</td>
            <td>{{ $operation->created_at->format('d.m.Y H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $operations->links('pagination::bootstrap-5') !!}

{{-- wait animation --}}
<div id="loader" class="loader-overlay">
    <div class="loader"></div>
</div>
