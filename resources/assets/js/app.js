
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import { Toast } from 'bootstrap';

document.querySelectorAll('.toast.js-toast-ephemeral')
    .forEach(toastEl => {
        const toast = new Toast(toastEl);
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => {
            toast.dispose();
            toastEl.remove();
        });
    });
