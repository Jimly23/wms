<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Code Rak - {{ $rack->nama_rak }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    
    <div class="bg-white p-8 rounded shadow-lg text-center border border-gray-200">
        <h2 class="text-xl font-bold mb-2">{{ $rack->nama_rak }}</h2>
        <p class="text-sm text-gray-500 mb-6">{{ $rack->lokasi }}</p>
        
        <div class="mb-4 flex justify-center">
            <div id="qrcode"></div>
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-6">{{ $rack->barcode }}</p>
        
        <div class="no-print space-x-4">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Cetak QR Code
            </button>
            <button onclick="window.close()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
                Tutup
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{!! route('scan.search', ['barcode' => $rack->barcode]) !!}",
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
