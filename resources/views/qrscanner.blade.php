<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Scanner</title>
    <style>
        canvas {
            position: absolute;
            top: 25px;left: 5%;right: 5%;bottom: 5%;
            width: 90%;
            height: 600px;
        }
    </style>
</head>
<body>
    
<canvas id="canvas"></canvas>

<script src="{{ asset('plugins/jsQR/dist/jsQR.js') }}"></script>
<script>
    let video = document.createElement('video')
    let canvasEl = document.querySelector('#canvas')
    let canvas = canvasEl.getContext('2d')

    navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: 'environment'
        }
    })
    .then(stream => {
        video.srcObject = stream
        video.setAttribute('playsinline', true)
        video.play()
        requestAnimationFrame(tick)
    })
    .catch(e => {
        alert(e)
    })

    const tick = () => {
        if(video.readyState === video.HAVE_ENOUGH_DATA) {
            canvasEl.width = video.videoWidth
            canvasEl.height = video.videoHeight
            canvas.drawImage(video, 0, 0, canvasEl.width, canvasEl.height)
            
            let imageData = canvas.getImageData(0, 0, canvasEl.width, canvasEl.height)
            let code = new jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempt: "dontInvert"
            })

            if(code) {
                if(code.data !== undefined) {
                    console.log(code.data)
                }
            }
        }

        requestAnimationFrame(tick)
    }
</script>
    
</body>
</html>