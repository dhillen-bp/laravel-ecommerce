<span
    class="@if ($status == 'paid') badge-soft badge-success
    @elseif($status == 'pending')
        badge-soft badge-warning
    @elseif($status == 'failed')
        badge-soft badge-error
    @else
        badge-soft badge-secondary @endif badge badge-sm">
    {{ ucfirst($status) }}
</span>
