'use strict';
import { signal } from "../../state/signals";

export const onCommentDeleteOpen = {
    params: ({el}) => ({
        url: el.getAttribute("data-wt-url"),
    }),
    onClick: ({url}) => {
        signal("modals.comment.delete.url").set(url);
    }
}