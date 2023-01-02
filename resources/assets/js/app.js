
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import { setupButtons } from './buttons/setup';
import { setupState } from './state/setup'
import { showEphemeralToasts } from './utils/toasts';

showEphemeralToasts();
setupState();
setupButtons();

const edit_btn = document.getElementById('edit-comment-button');
const edit_form = document.getElementById('edit-comment-form');
const cancel_edit_btn = document.getElementById('edit-cancel-button');
const comment_body = document.getElementById('comment-body');


if (edit_btn) {
    edit_btn.addEventListener('click', function() {
        edit_form.style.display = 'flex';
        edit_btn.style.display = 'none';
        comment_body.style.display = 'none';
    });
}

if (cancel_edit_btn) {
    cancel_edit_btn.addEventListener('click', function() {
        edit_form.style.display = 'none';
        edit_btn.style.display = 'block';
        comment_body.style.display = 'block';
    });
}

// Demote buttons
const demote_btns = document.querySelectorAll('.demote-button');

if (demote_btns) {
    if (demote_btns.length > 0) {
        demote_btns.forEach(function(btn, idx) {
            btn.addEventListener('click', function(event) {
                let username = event.target.dataset.wtUsername;
                document.getElementById('demotion-modal-title').textContent = `Demote ${username}`;
            })
        })
    }
}
