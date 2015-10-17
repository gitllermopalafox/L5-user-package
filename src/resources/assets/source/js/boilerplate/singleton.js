/* eslint no-console: 0 */

// singleton.js:

// Define a singleton module
define(function () {

    'use strict';

    // Return the singleton's public interface
    return {
        init: function () {
            console.log('result from init method');
        },
        testProperty: 'unchanged'
    };
});


// Usage of the singleton module
require(['singleton'], function (Singleton) {

    'use strict';

    // Change the testProperty property
    Singleton.testProperty = 'changed';
});

require(['singleton'], function (Singleton) {

    'use strict';

    // Call a method on the Singleton module
    Singleton.init(); // Will output 'result from init method'

    // Log the testProperty property of the Singleton module
    console.log(Singleton.testProperty); // Will output 'changed'
});
