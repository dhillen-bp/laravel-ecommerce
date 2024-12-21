<span
    class="@if ($status == 'paid') badge-soft badge-primary
    @elseif($status == 'pending') badge-soft badge-warning
    @elseif($status == 'processed') badge-soft badge-neutral
    @elseif($status == 'shipped') badge-soft badge-info
    @elseif($status == 'delivered') badge-soft badge-accent
    @elseif($status == 'completed') badge-soft badge-success
    @elseif($status == 'cancelled') badge-soft badge-error
    @else badge-soft badge-default @endif badge badge-sm">
    {{ ucfirst($status) }}
</span>
