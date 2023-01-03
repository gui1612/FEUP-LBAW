import { onPostLike, onPostDislike } from './ratings';
import { onCommentLike, onCommentDislike } from './ratings/comment';
import { onUserFollow, onUserUnfollow } from './users';
import { onForumFollow, onForumUnfollow } from './forums';
import { onForumDemoteOpen, onForumPromoteOpen, onForumDeleteOpen } from './forums/management';
import { onAdminTeamDemoteOpen, onAdminUsersDemoteOpen, onAdminUsersPromoteOpen, onAdminUsersDeleteOpen, onAdminUsersBlockOpen, onAdminUsersUnblockOpen } from './admin/management';
import { onCommentDeleteOpen } from './comment/management';
import { onCommentEditShow, onCommentEditHide } from './comment/edit';

const actions = {
    'ratings.like': onPostLike,
    'ratings.dislike': onPostDislike,
    'user.follow': onUserFollow,
    'user.unfollow': onUserUnfollow,
    'comment.like': onCommentLike,
    'comment.dislike': onCommentDislike,
    'forum.follow': onForumFollow,
    'forum.unfollow': onForumUnfollow,    
    'modals.forum.demote.open': onForumDemoteOpen,    
    'modals.forum.promote.open': onForumPromoteOpen, 
    'modals.forum.delete.open': onForumDeleteOpen,
    'modals.admin.team.demote.open': onAdminTeamDemoteOpen,
    'modals.admin.users.demote.open': onAdminUsersDemoteOpen,
    'modals.admin.users.promote.open': onAdminUsersPromoteOpen,
    'modals.admin.users.delete.open': onAdminUsersDeleteOpen,
    'modals.admin.users.block.open': onAdminUsersBlockOpen,
    'modals.admin.users.unblock.open': onAdminUsersUnblockOpen,
    'modals.comment.delete.open': onCommentDeleteOpen,
    'comment.edit.show': onCommentEditShow,
    'comment.edit.hide': onCommentEditHide,
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