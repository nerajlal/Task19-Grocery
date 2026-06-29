@forelse($discounts as $discount)
<tr class="cursor-pointer" onclick="window.location='{{ route('admin.discounts.edit', $discount->id) }}'">
    <td class="px-3 py-3" onclick="event.stopPropagation()"><div class="form-check"><input type="checkbox" class="form-check-input" value="{{ $discount->id }}"></div></td>
    <td class="px-3 py-3">
        <div class="d-flex flex-column">
            <span class="fw-bold text-dark">{{ $discount->code }}</span>
            <span class="small text-muted">
                @if($discount->products->count() > 0)
                    {{ $discount->products->first()->title }} 
                    @if($discount->products->count() > 1) 
                        + {{ $discount->products->count() - 1 }} more 
                    @endif
                @else
                    All Products
                @endif
            </span>
        </div>
    </td>
    <td class="px-3 py-3">
        @php
            $status = $discount->computed_status;
            $badgeClass = match($status) {
                'active' => 'bg-success bg-opacity-10 text-success',
                'scheduled' => 'bg-info bg-opacity-10 text-info',
                'expired' => 'bg-secondary bg-opacity-10 text-secondary',
                'draft' => 'bg-warning bg-opacity-10 text-warning',
                'archived' => 'bg-light text-muted border',
                default => 'bg-secondary bg-opacity-10 text-secondary'
            };
        @endphp
        <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1 fw-medium">
            {{ ucfirst($status) }}
        </span>
    </td>
    <td class="px-3 py-3 text-dark">
        {{ $discount->value }}{{ $discount->type == 'percentage' ? '%' : ' AED' }} off
    </td>
    <td class="px-3 py-3 text-muted small">
        {{ $discount->starts_at->format('M d, Y') }} 
        @if($discount->ends_at)
            - {{ $discount->ends_at->format('M d, Y') }}
        @endif
    </td>
    <td class="px-3 py-3 text-end">
        {{ $discount->uses_count }}
    </td>
    <td class="px-3 py-3 text-end">
        <div class="d-flex justify-content-end gap-2" onclick="event.stopPropagation()">
             <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-white btn-sm border-0 text-secondary hover-text-primary p-1"><i class="fas fa-edit"></i></a>
             
             <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this discount?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-white btn-sm border-0 text-secondary hover-text-danger p-1"><i class="fas fa-trash"></i></button>
             </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center py-5 text-muted">No discounts found.</td>
</tr>
@endforelse
<tr>
    <td colspan="7" class="px-3 py-3 border-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="text-secondary small">
                Showing
                <span class="fw-medium">{{ $discounts->firstItem() ?? 0 }}</span>
                to
                <span class="fw-medium">{{ $discounts->lastItem() ?? 0 }}</span>
                of
                <span class="fw-medium">{{ $discounts->total() }}</span>
                results
            </div>
            <div>
                {{ $discounts->appends(request()->query())->links() }}
            </div>
        </div>
    </td>
</tr>
