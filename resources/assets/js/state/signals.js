'use strict';
const signals = new Map();

export function signal(name, defaultValue) {
    if (signals.has(name)) {
        const signal = signals.get(name)
        if (typeof signal.get() === 'undefined') {
            signal.set(defaultValue);
        }

        return signal;
    }

    if (typeof defaultValue === 'undefined') {
        console.warn(`No default value provided for signal ${name}, notification will be sent once value is set...`);
    }

    let value = defaultValue;
    const listeners = new Set();

    function set(newValue) {
        let nextValue;
        if (typeof newValue === 'function') {
            nextValue = newValue(value);
        } else {
            nextValue = newValue;
        }

        if (typeof nextValue === 'undefined') {
            console.warn(`Next value for signal ${name} is undefined, no notification will be sent and value will be ignored...`);
            return;
        }

        value = nextValue;
        listeners.forEach(listener => listener(value));
    }

    function get() {
        return value;
    }

    function subscribe(callback) {
        let cleanup = callback(value);

        const notify = (v) => {
            if (typeof cleanup === 'function') {
                cleanup();
            }
            
            cleanup = callback(v);
        };

        listeners.add(notify);
        return () => listeners.delete(notify);
    }

    const signal = {
        set,
        get,
        subscribe,
    };

    signals.set(name, signal);
    return signal;
}