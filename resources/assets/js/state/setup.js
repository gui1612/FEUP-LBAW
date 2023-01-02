import { signal } from './signals';

export function setupState() {
    document.body.querySelectorAll('[data-wt-signal]').forEach((container) => {
        const signalName = container.getAttribute('data-wt-signal');
        if (signalName == null) return;

        const signalInfomation = signalName.split(':');

        let name, attribute = null;
        if (signalInfomation.length === 1) {
            [name] = signalInfomation;
        } else if (signalInfomation.length === 2) {
            [name, attribute] = signalInfomation;
        } else {
            console.warn(`Invalid signal name ${signalName}, expected format is "name" or "name:attribute"`);
            return;
        }

        let defaultValue = container.getAttribute('data-wt-value');

        const { subscribe } = signal(name, defaultValue);
        subscribe((v) => {
            let value;
            try {
                value = v.toString();
            } catch(e) {
                value = '';
            }

            if (attribute) {
                container.setAttribute(attribute, value);
            } else {
                container.textContent = value;
            }
        });
    });
}
