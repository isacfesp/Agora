document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    
    // Remover la clase collapsed si existe
    if (sidebar.classList.contains("collapsed")) {
        sidebar.classList.remove("collapsed");
    }
    
    // Guardar el estado en localStorage si quieres persistencia
    localStorage.setItem('sidebarState', 'expanded');
});

document.getElementById("menu-toggle").addEventListener("click", function() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");

    if (window.innerWidth <= 768) {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                sidebar.classList.remove('collapsed');
            });
        });
    }
});

document.addEventListener('click', function(event) {
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("menu-toggle");

    if (window.innerWidth <= 768 &&
        !sidebar.contains(event.target) &&
        !menuToggle.contains(event.target)) {
        sidebar.classList.remove('collapsed');
    }
});

// Mostrar/ocultar el menú desplegable al hacer clic en el botón
document.getElementById("mobile-menu-toggle").addEventListener("click", function() {
    const mobileMenu = document.getElementById("mobile-menu");
    mobileMenu.style.display = mobileMenu.style.display === "block" ? "none" : "block";
});

// Ocultar el menú desplegable al hacer clic fuera de él
document.addEventListener("click", function(event) {
    const mobileMenu = document.getElementById("mobile-menu");
    const menuToggle = document.getElementById("mobile-menu-toggle");
    const btnUser = document.getElementById("btn-user");

    if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target)) {
        mobileMenu.style.display = "none";
    }

    if (!event.target.closest(".user-icon-container") && btnUser.checked) {
        btnUser.checked = false;
    }
});

// Ocultar el menú desplegable al seleccionar un elemento del menú
const menuItems = document.querySelectorAll("#mobile-menu .menu-item");
menuItems.forEach(item => {
    item.addEventListener("click", function() {
        const mobileMenu = document.getElementById("mobile-menu");
        mobileMenu.style.display = "none";
    });
});

// Detectar clics dentro del iframe para cerrar el menú y el modal
const iframe = document.getElementById("main-frame");
iframe.addEventListener("load", function() {
    const iframeDocument = iframe.contentWindow.document;

    iframeDocument.addEventListener("click", function() {
        const mobileMenu = document.getElementById("mobile-menu");
        const btnUser = document.getElementById("btn-user");

        // Cerrar el menú desplegable si está abierto
        if (mobileMenu.style.display === "block") {
            mobileMenu.style.display = "none";
        }

        // Cerrar el modal del perfil si está abierto
        if (btnUser.checked) {
            btnUser.checked = false;
        }
    });
});