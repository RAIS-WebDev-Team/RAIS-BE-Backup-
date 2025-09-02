<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logoulit.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to RAIS</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #000;
        }
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
            transition: opacity 1.5s ease-out;
            z-index: 10000;
        }
        #splash-screen.fade-out {
            opacity: 0;
        }
        #animation-video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div id="splash-screen">
        <video id="animation-video" autoplay muted playsinline>
            <source src="vids/intro.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const splashScreen = document.getElementById('splash-screen');
            const animationVideo = document.getElementById('animation-video');

            // Redirect to index.php if the video fails to load or play
            animationVideo.onerror = function() {
                console.error("Video could not be loaded.");
                window.location.href = 'index.php?animation=done';
            };

            animationVideo.addEventListener('ended', () => {
                splashScreen.classList.add('fade-out');
                
                // Wait for the fade-out transition to finish before redirecting
                setTimeout(() => {
                    window.location.href = 'index.php?animation=done';
                }, 1500); // This timeout should match the CSS transition duration
            });

            // Fallback in case the 'ended' event doesn't fire
            setTimeout(() => {
                 // Check if the video has played, if not, redirect
                if (animationVideo.paused) {
                     window.location.href = 'index.php?animation=done';
                }
            }, 10000); // 10-second fallback
        });
    </script>
</body>
</html>
