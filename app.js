/*
 * This file launches the application by asking Ext JS to create
 * and launch() the Application class.
 */
Ext.application({
    extend: 'agrad.Application',

    name: 'agrad',

    requires: [
        // This will automatically load all classes in the agrad namespace
        // so that application classes do not need to require each other.
        'agrad.*'
    ],

    // The name of the initial view to create.
    // mainView: 'agrad.view.main.Main'
});