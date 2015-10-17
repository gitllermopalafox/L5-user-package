/* eslint no-console: 0 */

// instantiable.js

// Define an instantiable module
define(function () {

    'use strict';

    // Return a constructor method
    return function (settings) {

        // Return the instance's public interface
        return {
            doAction: function () {
                console.log('result from doAction method', settings.name);
            }
        };
    };
});


// Usage of the instantiable module
require(['instantiable'], function (Instantiable) {

    'use strict';

    // Create two new instances of the Instantiable module
    var instance1 = Instantiable({name: 'instance1'}),
        instance2 = Instantiable({name: 'instance2'});

    // Call a public method on instance1
    instance1.doAction(); // Will output 'result from doAction method' instance1


    // Call a public method on instance2
    instance2.doAction(); // Will output 'result from doAction method' instance2
});
