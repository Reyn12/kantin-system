<div>
    <div id="reader"></div>
    <p class="text-sm text-gray-500 text-center mt-4">
        Arahkan kamera ke QR Code yang ada di meja
    </p>
</div>

@push('scripts')
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Redirect ke halaman menu dengan nomor meja dari QR
        window.location.href = '{{ route('order.menu') }}?table=' + decodedText;
    }

    const html5QrCode = new Html5Qrcode("reader");
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch((err) => {
            console.error(`QR Code scanning failed: ${err}`);
            alert("Gagal mengakses kamera. Pastikan kamu sudah memberi izin kamera.");
        });
</script>
@endpush