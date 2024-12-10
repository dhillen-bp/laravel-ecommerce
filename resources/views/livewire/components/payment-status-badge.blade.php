<span
    class="@if ($status == 'success') badge-soft badge-success
    @elseif($status == 'pending')
        badge-soft badge-warning
    @elseif($status == 'failed')
        badge-soft badge-error
    @else
        badge-soft badge-secondary @endif badge badge-sm">
    {{ ucfirst($status) }}
</span>
