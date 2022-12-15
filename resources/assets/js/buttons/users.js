'use strict';
import { makeRequest } from "../utils/requests";
import { signal } from "../state/signals";
import { createEphemeralToast, showEphemeralToasts } from '../utils/toasts';

function syncButton({ isFollowing, button }) {
    if (!isFollowing) {
        button.setAttribute('data-wt-action', 'user.follow');
        button.querySelector('span').textContent = 'Follow';
        button.querySelector('i').classList.replace('bi-person-check-fill', 'bi-person-add');
    } else {
        button.setAttribute('data-wt-action', 'user.unfollow');
        button.querySelector('span').textContent = 'Unfollow';
        button.querySelector('i').classList.replace('bi-person-add', 'bi-person-check-fill');
    }
}

const params = ({ el, csrf }) => ({
    csrf,
    userId: el.getAttribute('data-wt-user-id'),
    button: el,
});

function onClick({ type }) {
    return async ({ csrf, userId, button }) => {
        let res;
        if (type === 'follow') {
            res = await makeRequest(['user.follow', userId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });
        } else {
            res = await makeRequest(['user.unfollow', userId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });
        }
            
        const data = await res.json();
        if (res.ok) {
            syncButton({
                isFollowing: !!data.current,
                button,
            });

            signal(`user.${userId}.followers`).set(data.followers);
        } else {
            createEphemeralToast({
                level: 'danger',
                title: 'Unexpected Error',
                message: data.message,
            });

            showEphemeralToasts();
        }
    };
}

export const onUserFollow = {
    params,
    onClick: onClick({ type: 'follow' }),
};

export const onUserUnfollow = {
    params,
    onClick: onClick({ type: 'unfollow' }),
}
