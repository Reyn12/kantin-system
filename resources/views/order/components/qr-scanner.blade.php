<div>
    <div id="reader" class="w-full bg-black aspect-square rounded-lg mb-4"></div>
    <p class="text-sm text-gray-500 text-center">
        Arahkan kamera ke QR Code yang ada di meja
    </p>
</div>

@push('scripts')
<script>
    // Initialize QR Scanner when component is mounted
    document.addEventListener('DOMContentLoaded', function() {
        let html5QrCode;

        function onScanSuccess(decodedText, decodedResult) {
            console.log("QR Code detected:", decodedText); // Debug line
            
            // Stop scanner dulu
            if (html5QrCode) {
                html5QrCode.stop();
            }
            
            // Create form data
            const formData = new FormData();
            formData.append('table_number', decodedText.toUpperCase());
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            // Submit table number via POST
            fetch('{{ route('order.set-table') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Response status:", response.status);
                return response.json();
            })
            .then(data => {
                console.log("Response data:", data);
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Nomor meja tidak valid!');
                    // Restart scanner kalo gagal
                    startScanner();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses nomor meja');
                // Restart scanner kalo error
                startScanner();
            });
        }

        function startScanner() {
            html5QrCode = new Html5Qrcode("reader");
            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ]
            };

            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                onScanSuccess,
                (errorMessage) => {
                    console.log(errorMessage);
                }
            ).catch((err) => {
                console.error(`QR Code scanning failed: ${err}`);
                alert("Gagal mengakses kamera. Pastikan kamu sudah memberi izin kamera.");
            });
        }

        // Start scanner pertama kali
        startScanner();
    });
</script>
@endpush