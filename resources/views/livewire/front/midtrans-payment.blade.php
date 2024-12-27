<div>
    <button id="pay-button" class="btn btn-primary w-full">Bayar</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function() {
            fetch('/payment/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: "{{ $order->id }}"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // window.location.href = '/my-order';
                            Livewire.navigate('/my_order')
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran!');
                            console.log(result);
                        },
                        onError: async function(result) {
                            alert('Pembayaran gagal!');

                            try {
                                const response = await fetch(
                                    "/payment-failed/{{ $order->id }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        },
                                        body: JSON
                                            .stringify({}),
                                    });

                                if (response.ok) {
                                    window.location.href = '/payment-failed';
                                } else {
                                    alert('Gagal memperbarui status pesanan');
                                }
                            } catch (error) {
                                console.error('Terjadi kesalahan:', error);
                            }
                        }

                    });
                });
        });
    </script>
</div>
