'use strict';
import { makeRequest } from "../../utils/requests";
import { createEphemeralToast, showEphemeralToasts } from '../../utils/toasts';

function syncButtons({ type, parent }) {
    const like = parent.querySelector(`button[data-wt-action="comment.like"] > i`);
    const dislike = parent.querySelector(`button[data-wt-action="comment.dislike"] > i`);
    
    if (type === 'like') {
        like.classList.replace('bi-hand-thumbs-up', 'bi-hand-thumbs-up-fill');
        dislike.classList.replace('bi-hand-thumbs-down-fill', 'bi-hand-thumbs-down');
    } else if (type === 'dislike') {
        like.classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
        dislike.classList.replace('bi-hand-thumbs-down', 'bi-hand-thumbs-down-fill');
    } else {
        like.classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
        dislike.classList.replace('bi-hand-thumbs-down-fill', 'bi-hand-thumbs-down');
    }
}

const params = ({ el, csrf }) => ({
    csrf,
    commentId: el.getAttribute('data-wt-comment-id'),
    button: el,
});

function onClick({ type }) {
    return async ({ csrf, commentId, button }) => {
        const parent = button.parentElement;
        const active = parent.querySelector(`button[data-wt-action] > i[class*="fill"]`)?.parentElement;

        let res;
        if (!active || active !== button) {
            res = await makeRequest(['comment.rating.set', commentId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                data: JSON.stringify({ type }),
            });
        } else {
            res = await makeRequest(['comment.rating.remove', commentId], {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });
        }
            
        const data = await res.json();
        if (res.ok) {

            const span = parent.querySelector(':scope > span');
            span.textContent = data.rating;

            syncButtons({ 
                type: data.current?.type,
                parent,
            });
        } else {
            createEphemeralToast({
                level:  'danger',
                title: 'Unexpected Error',
                message: data.message,
            });

            showEphemeralToasts();
        }
    };
}

export const onCommentDislike = {
    params,
    onClick: onClick({ type: 'dislike' }),
};

export const onCommentLike = {
    params,
    onClick: onClick({ type: 'like' }),
}
