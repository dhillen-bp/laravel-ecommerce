<x-filament-panels::page>

    <h1>Variants for {{ $product->name }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Variant Name</th>
                <th>Price</th>
                <th>Stok</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product->variants as $variant)
                <tr>
                    <td>{{ $variant->name }}</td>
                    <td>{{ $variant->sku }}</td>
                    <td>{{ $variant->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</x-filament-panels::page>
