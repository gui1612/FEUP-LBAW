import { Toast } from 'bootstrap';

export function createEphemeralToast({ title, message, level }) {

    const template = `<div class="toast fade wt-toast-ephemeral" style="--bs-toast-bg: #fff;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <div class="rounded-1 me-2 wt-toast-level" style="width: 1rem; height: 1rem;"></div>
            <strong class="me-auto wt-toast-title"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span class="wt-toast-message"></span>
        </div>
    </div>`;

    const toastContainer = document.getElementById('wt-toast-container');
    const toast = document.createElement('div');
    
    toast.innerHTML = template;
    
    const toastLevel = toast.querySelector('.wt-toast-level');
    const toastTitle = toast.querySelector('.wt-toast-title');
    const toastMessage = toast.querySelector('.wt-toast-message');
    
    toastLevel.classList.add(`bg-${level}`);
    toastTitle.textContent = title;
    toastMessage.textContent = message;
    
    toastContainer.append(toast.firstChild);
}

export function showEphemeralToasts() {
    document.querySelectorAll('.toast.wt-toast-ephemeral')
    .forEach(toastEl => {
        toastEl.classList.remove('wt-toast-ephemeral');
        
        const toast = new Toast(toastEl);
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => {
            toast.dispose();
            toastEl.remove();
        });
    });
}