// Función para mostrar el toast
function showToast(title, message, type) {
    let toastContainer = document.getElementById('toast-container');

    // Crear el contenedor de toasts si no existe
    if (!toastContainer) {
        const body = document.querySelector('body');
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '5rem';
        toastContainer.style.right = '1rem';
        toastContainer.style.zIndex = '9999';
        toastContainer.style.marginBottom = '2rem'; // Agregar margen inferior entre toasts

        body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    toast.classList.add('bs-toast', 'toast', 'fade', 'show', `bg-${type}`, 'mb-2');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    const iconClass = type === 'success' ? 'bx bx-bell' : 'bx bx-bell-off';

    toast.innerHTML = `
        <div class="toast-header">
            <i class="${iconClass} me-2"></i>
            <div class="me-auto fw-medium">${title}</div>
            <small>${new Date().toLocaleTimeString()}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">${message}</div>`;

    toastContainer.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    // Eliminar el toast después de 5 segundos
    setTimeout(() => {
        bsToast.hide();
        setTimeout(() => {
            toastContainer.removeChild(toast);
        }, 500);
    }, 5000);
}