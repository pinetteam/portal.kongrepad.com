<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            text-align: center;
            padding: 20px;
        }
        .qr-code {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Hesabınıza Giriş</h1>
    </div>
    <div class="content">
        <p>Merhaba, {{ $recipient['full_name'] ?? 'Kullanıcı' }}</p>
        <p>Aşağıdaki QR kodu kullanarak hesabınıza giriş yapabilirsiniz:</p>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qr_code_image }}" alt="QR Kod">
        </div>
        <p>Ya da şu kodu kullanabilirsiniz:</p>
        <h3>{{ $recipient['username'] ?? '-' }}</h3>
    </div>
    <div class="footer">
        <p>© {{ now()->year }} KongrePad. Tüm hakları saklıdır.</p>
    </div>
</div>
</body>
</html>
