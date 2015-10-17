/* eslint no-console: 0 */

// Subscribe to events
require(['unicorn/pubsub'], function (PubSub) {

    'use strict';

    var callback = function () {
            console.log('a.test.event received');
        };
 
    // Subscribe to an event
    PubSub.on('a.test.event', callback);
});

// Unsubscribe from events
require(['unicorn/pubsub'], function (PubSub) {

    'use strict';

    var callback = function () {
            console.log('a.test.event received');
        };
 
    // Unsubscribe from an event
    PubSub.off('a.test.event', callback);
});

// Fire events
require(['unicorn/pubsub'], function (PubSub) {

    'use strict';

    // Fire an event
    PubSub.fire('a.test.event');
});
