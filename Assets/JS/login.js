// Este script maneja las interacciones de la página de inicio de sesión.
// La lógica principal se ejecuta solo cuando el DOM está completamente cargado.
document.addEventListener('DOMContentLoaded', function() {
    
    // Función para alternar la visibilidad de la contraseña
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('password-toggle-icon');
        
        // Alternar el tipo de input entre 'password' y 'text'
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
        
        // Alternar el ícono del ojo
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    }

    // Lógica del canvas animado para el fondo
    const canvas = document.getElementById('particle-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    const numParticles = 100;
    const colors = ['#5d5cff', '#b1aaff', '#99f1ff'];

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    function Particle(x, y, vx, vy, radius, color) {
        this.x = x;
        this.y = y;
        this.vx = vx;
        this.vy = vy;
        this.radius = radius;
        this.color = color;
    }

    Particle.prototype.draw = function() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
    };

    Particle.prototype.update = function() {
        this.x += this.vx;
        this.y += this.vy;

        if (this.x < -this.radius || this.x > canvas.width + this.radius) {
            this.vx *= -1;
        }
        if (this.y < -this.radius || this.y > canvas.height + this.radius) {
            this.vy *= -1;
        }
    };

    function createParticles() {
        for (let i = 0; i < numParticles; i++) {
            const radius = Math.random() * 2 + 1;
            const x = Math.random() * (canvas.width - radius * 2) + radius;
            const y = Math.random() * (canvas.height - radius * 2) + radius;
            const vx = (Math.random() - 0.5) * 0.5;
            const vy = (Math.random() - 0.5) * 0.5;
            const color = colors[Math.floor(Math.random() * colors.length)];
            particles.push(new Particle(x, y, vx, vy, radius, color));
        }
    }

    function animate() {
        requestAnimationFrame(animate);
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }
    }

    // Iniciar la animación al cargar la página
    createParticles();
    animate();

    // Exportar la función togglePassword para que sea accesible desde el HTML
    window.togglePassword = togglePassword;
});
