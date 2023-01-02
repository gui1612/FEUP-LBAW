import { onPostLike, onPostDislike } from './ratings';
import { onCommentLike, onCommentDislike } from './ratings/comment';
import { onUserFollow, onUserUnfollow } from './users';

const actions = {
    'ratings.like': onPostLike,
    'ratings.dislike': onPostDislike,
    'user.follow': onUserFollow,
    'user.unfollow': onUserUnfollow,
    'comment.like': onCommentLike,
    'comment.dislike': onCommentDislike,
};

const csrf = document.head.querySelector('meta[name="csrf-token"]')?.content;

export function setupButtons() {
    document.body.querySelectorAll('button[data-wt-action]').forEach((button) => {
        function attachAction(el) {
            const actionAttr = el.getAttribute('data-wt-action');
            const action = actions[actionAttr];

            if (!action) {
                console.warn(`No handler found for the following button with action ${actionAttr}, skipping...`);
                console.warn(el);
                return;
            }

            const listener = () => {
                const params = action.params({ csrf, el });
                return action.onClick(params)
            };

            el.addEventListener('click', listener);
            return () => el.removeEventListener('click', listener);
        }

        let cleanup = attachAction(button);
        const observer = new MutationObserver((mutations) => {
            let reload = false;
            mutations.forEach((mutation) => {
                if (!reload && mutation.type === 'attributes' && mutation.attributeName === 'data-wt-action') {
                    reload = true;
                }
            });

            if (reload) {
                cleanup();
                cleanup = attachAction(button);
            }
        });

        observer.observe(button, { attributes: true });
    });
}