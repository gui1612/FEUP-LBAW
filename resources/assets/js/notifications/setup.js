import { makeRequest } from "../utils/requests";
import { createEphemeralToast, showEphemeralToasts } from "../utils/toasts";

export function setupNotifications() {
    const userId = document.head.querySelector('meta[name="user-id"]')?.content;

    if (userId) {

        const pusher = new Pusher('0cfc9a96608452b0127b', {
            encrypted: true,
            cluster: 'eu',
        });

        const channel = pusher.subscribe('users.' + userId);

        channel.bind('update_notifications', async ({ type }) => {
            const res = await makeRequest(['notifications.navbar'], { data: undefined });
            
            const { mobile, widescreen } = await res.json();

            const mobileNotifications = document.getElementById('notifications-dropdown-mobile');
            const widescreenNotifications = document.getElementById('notifications-dropdown');

            mobileNotifications.outerHTML = mobile;
            widescreenNotifications.outerHTML = widescreen;

            if (type === 'new') {
                createEphemeralToast({
                    level: 'info',
                    title: 'Notifications',
                    message: 'You have received a new notification.',
                });

                showEphemeralToasts();
            }
        });
    }
}