'use strict';
import { signal } from "../../state/signals";
import { onClick } from "../forums/index"

export const onAdminTeamDemoteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.team.demote.username").set(username);
        signal("modals.admin.team.demote.url").set(url);
    }
}

export const onAdminUsersDemoteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.users.demote.username").set(username);
        signal("modals.admin.users.demote.url").set(url);
    }
}

export const onAdminUsersPromoteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.users.promote.username").set(username);
        signal("modals.admin.users.promote.url").set(url);
    }
}

export const onAdminUsersDeleteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.users.delete.username").set(username);
        signal("modals.admin.users.delete.url").set(url);
    }
}

export const onAdminUsersBlockOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.users.block.username").set(username);
        signal("modals.admin.users.block.url").set(url);
    }
}

export const onAdminUsersUnblockOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
        username: el.getAttribute("data-wt-username")
    }),
    onClick: ({url, username}) => {
        signal("modals.admin.users.unblock.username").set(username);
        signal("modals.admin.users.unblock.url").set(url);
    }
}