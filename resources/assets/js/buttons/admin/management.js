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
