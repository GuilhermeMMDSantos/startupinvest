window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { Modal, Toast, Dropdown, Collapse, Tooltip, Popover } from 'bootstrap';

if (window.jQuery) {
    const bridge = (name, Component) => {
        window.jQuery.fn[name] = function (action) {
            return this.each(function () {
                const instance = Component.getOrCreateInstance(this);
                if (typeof action === 'string' && typeof instance[action] === 'function') {
                    instance[action]();
                }
            });
        };
    };

    bridge('modal', Modal);
    bridge('toast', Toast);
    bridge('dropdown', Dropdown);
    bridge('collapse', Collapse);
    bridge('tooltip', Tooltip);
    bridge('popover', Popover);
}

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: false,
    enabledTransports: ['ws', 'wss']
});
