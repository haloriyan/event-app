<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Generator</title>
    <style>
        #area {
            position: absolute;
            top: 90px;left: 20%;
        }
    </style>
</head>
<body>
    
<div id="area"></div>

<script src="{{ asset('plugins/qrcodejs/qrcode.min.js') }}"></script>
<script>
    let area = document.querySelector('#area')
    let qr = new QRCode(area, {
        text: 'https://www.facebook.com',
        width: 500,
        height: 500
    })
</script>

</body>
</html>