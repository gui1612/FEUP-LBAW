'use strict';
import { signal } from "../../state/signals";

export const onForumDemoteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.forum.demote.username").set(username);
        signal("modals.forum.demote.url").set(url);
    }
}

export const onForumPromoteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.forum.promote.username").set(username);
        signal("modals.forum.promote.url").set(url);
    }
}

export const onForumDeleteOpen = {
    params: ({el}) => ({
        forum_name: el.getAttribute("data-wt-forum_name")
    }),
    onClick: ({forum_name}) => {
        signal("modals.forum.delete.forum_name").set(forum_name);
    }
}