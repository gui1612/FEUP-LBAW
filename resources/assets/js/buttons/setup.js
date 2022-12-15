import { onPostLike, onPostDislike } from './ratings';
import { onUserFollow, onUserUnfollow } from './users';

const actions = {
    'ratings.like': onPostLike,
    'ratings.dislike': onPostDislike,
    'user.follow': onUserFollow,
    'user.unfollow': onUserUnfollow,
};

const csrf = document.head.querySelector('meta[name="csrf-token"]')?.content;

export function setupButtons() {
    document.body.querySelectorAll('button[data-wt-action]').forEach((el) => {
        const actionAttr = el.getAttribute('data-wt-action');
        const action = actions[actionAttr];

        if (!action) {
            console.warn(`No handler found for the following button with action ${actionAttr}, skipping...`);
            console.warn(el);
            return;
        }

        el.addEventListener('click', () => {
            const params = action.params({ csrf, el });
            return action.onClick(params)
        });
    });
}