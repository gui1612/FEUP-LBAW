
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

import { showEphemeralToasts } from './utils/toasts';
import { setupNotifications } from './notifications/setup';
import { setupState } from './state/setup'
import { setupButtons } from './buttons/setup';

showEphemeralToasts();
setupNotifications();
setupState();
setupButtons();
