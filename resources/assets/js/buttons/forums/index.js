'use strict';
import { makeRequest } from "../../utils/requests";
import { signal } from "../../state/signals";
import { createEphemeralToast, showEphemeralToasts } from '../../utils/toasts';

function syncButton({ isFollowing, button }) {
    if (!isFollowing) {
        button.setAttribute('data-wt-action', 'forum.follow');
        button.querySelector('span').textContent = 'Follow';
    } else {
        button.setAttribute('data-wt-action', 'forum.unfollow');
        button.querySelector('span').textContent = 'Unfollow';
    }
}

const params = ({ el, csrf }) => ({
    csrf,
    forumId: el.getAttribute('data-wt-forum-id'),
    button: el,
});

function onClick({ type }) {
    return async ({ csrf, forumId, button }) => {
        let res;
        if (type === 'follow') {
            res = await makeRequest(['forum.follow', forumId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });
        } else {
            res = await makeRequest(['forum.unfollow', forumId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });
        }
            
        try {
            const data = await res.json();
            if (res.ok) {
                syncButton({
                    isFollowing: !!data.current,
                    button,
                });

                signal(`forum.${forumId}.followers`).set(data.followers);
            } else {
                throw new Error(data.message);
            }
        } catch (e) {
            createEphemeralToast({
                level: 'danger',
                title: 'Unexpected Error',
                message: e.message,
            });

            showEphemeralToasts();
        }
    };
}

export const onForumFollow = {
    params,
    onClick: onClick({ type: 'follow' }),
};

export const onForumUnfollow = {
    params,
    onClick: onClick({ type: 'unfollow' }),
}
