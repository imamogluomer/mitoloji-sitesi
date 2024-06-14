// snowfall.js

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('snowCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let snowflakes = [];

    function createSnowflake() {
        const x = Math.random() * canvas.width;
        const y = -5;
        const radius = Math.random() * 3 + 1;
        const speed = Math.random() * 3 + 1;

        snowflakes.push({ x, y, radius, speed });
    }

    function drawSnowflakes() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#fff';

        for (let i = 0; i < snowflakes.length; i++) {
            const flake = snowflakes[i];
            ctx.beginPath();
            ctx.arc(flake.x, flake.y, flake.radius, 0, Math.PI * 2);
            ctx.fill();
            flake.y += flake.speed;
            if (flake.y > canvas.height) {
                snowflakes.splice(i, 1);
                i--;
            }
        }
    }

    function updateSnowflakes() {
        if (Math.random() > 0.97) {
            createSnowflake();
        }

        drawSnowflakes();

        requestAnimationFrame(updateSnowflakes);
    }

    updateSnowflakes();
});
