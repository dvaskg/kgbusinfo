/**
 * The main application class. An instance of this class is created by app.js when it
 * calls Ext.application(). This is the ideal place to handle application launch and
 * initialization details.
 */
Ext.define('agrad.Application', {
    extend: 'Ext.app.Application',

    name: 'agrad',

    quickTips: false,
    platformConfig: {
        desktop: {
            quickTips: true
        }
    },

    onAppUpdate: function () {
        Ext.Msg.show({
            title: 'обавештење',
            message: 'Администратор је поставио нову верзију апликације<br/>страница ће се учитати још једном.',
            closable: false,
            buttons: Ext.Msg.YES,
            buttonText: {
                yes: 'OK & настави'
            },
            fn: function () {
                window.location.reload();
            },
            icon: Ext.Msg.INFO
        });
    }

});