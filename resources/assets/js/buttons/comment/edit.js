'use strict';
import { signal } from "../../state/signals";

const params = ({el}) => {
    const commentId = el.getAttribute("data-wt-comment-id"); 

    const editBtn = document.getElementById(`edit-comment-button.${commentId}`);
    const editForm = document.getElementById(`edit-comment-form.${commentId}`);
    const commentBody = document.getElementById(`comment-body.${commentId}`);

    return {
        commentId,
        editBtn,
        editForm,
        commentBody
    };
};

function onClick({ show }) {
    return ({ editBtn, editForm, commentBody}) => {
        if (show) {
            editForm.style.display = 'flex';
            editBtn.style.display = 'none';
            commentBody.style.display = 'none';
        } else {        
            editForm.style.display = 'none';
            editBtn.style.display = 'block';
            commentBody.style.display = 'block';
        }
    }
}

export const onCommentEditShow = {
    params,
    onClick: onClick({ show: true })
}

export const onCommentEditHide = {
    params,
    onClick: onClick({ show: false })
}
