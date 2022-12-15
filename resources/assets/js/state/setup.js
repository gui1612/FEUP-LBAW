import { signal } from './signals';

export function setupState() {
    document.body.querySelectorAll('[data-wt-signal]').forEach((container) => {
        const signalName = container.getAttribute('data-wt-signal');
        let value = container.getAttribute('data-wt-value');

        const { subscribe } = signal(signalName, value);
        subscribe((v) => container.textContent = v.toString());
    });
}
