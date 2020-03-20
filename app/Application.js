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
    launch: function () {
        Ext.Loader.setConfig({
            enabled: true,
            paths: {
                'Ext.ux': '../../ux'
            }
        });
        var MainView = Ext.Viewport.add({
            xtype: 'navigationview',
            layout: {
                type: 'card',
                animation: null
            },
            scrollable: true,
            fullscreen: true,
            items: [{
                xtype: 'app-main' //  ovo je FINAL - OSTAJE U FINALU
                // xtype: 'PORUKE' //PRIJAVA  PORUKE (Main - glavni ekr.)

            }]
        });
    },

    onAppUpdate: function () {
        var dialog = Ext.create({
            xtype: 'dialog',
            ui: 'soft-blue',
            title: st.Lang.apuNaslov, // 'обавештење',
            maxWidth: 300,
            html: '<div style="float: left;padding: 0 17px 0 0;">' +
                '<span style="font-size: 47px; color: #008080;"><i class="fa x-fa fa-newspaper-o"></i></span></div><div class="rowDialoga"><p>' +
                st.Lang.apuTxt + '</p></div>',
            buttons: [{
                text: st.Lang.apuOkNas, //
                textAlign: 'left',
                itemId: 'yes',
                ui: 'soft-green',
                maxWidth: '200',
                iconCls: 'x-fa fa-check',
                handler: function () {
                    window.location.reload();
                }
            }]
        }).show();
    }
});