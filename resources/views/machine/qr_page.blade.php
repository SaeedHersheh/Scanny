<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scan QR - Scanny</title>

<style>
    body {
        background: #0B1033;
        color: white;
        margin: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }

    .logo img {
        width: 130px;
        margin-bottom: 20px;
    }

    .qr-box {
        background: white;
        padding: 20px;
        border-radius: 20px;
        margin-top: 10px;
    }

    .qr-box svg {
        width: 220px;
        height: 220px;
    }
</style>

</head>
<body>

<div class="logo">
    <img src="{{ asset('images/p4.png') }}" alt="Scanny Logo">
</div>

<h2>Scan to Continue</h2>

<div class="qr-box">
    {!! $qrCode !!}
</div>

</body>
</html>
