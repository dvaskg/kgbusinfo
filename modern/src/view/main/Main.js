/**
 * This class is the main view for the application. It is specified in app.js as the
 * "mainView" property. That setting causes an instance of this class to be created and
 * added to the Viewport container.
 */
Ext.define('agrad.view.main.Main', {
    extend: 'Ext.Container',
    xtype: 'app-main',

    requires: [
        'Ext.MessageBox',
        'agrad.view.main.MainController',
        'agrad.view.main.MainModel',
        'Ext.layout.VBox',
        'Ext.Button'
    ],
    listeners: {
        painted: 'onMainRender', //painted//
        // resize: 'onOrijentChange'
    },

    controller: 'main',
    viewModel: 'main',
    cls: 'auth-login',

    layout: {
        type: 'vbox',
        align: 'center',
        pack: 'center'
    },

    items: [{
            cls: 'auth-header',
            html: '<div class="title">kgbus.info</div>'

        },
        {
            xtype: 'formpanel',
            reference: 'form',
            layout: 'vbox',
            ui: 'auth',

            items: [{
                    xtype: 'button',
                    text: 'Када долази аутобус',
                    xtip: 'odabirStan', // koji xtype da push
                    padding: '7px 0px 7px 0px',
                    margin: '0px 0px 14px 0px',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-angle-right',
                    handler: 'onChildtap',
                    ui: 'button-tirkiz'
                },
                {
                    xtype: 'button',
                    text: 'Анкета',
                    xtip: 'anketa', // koji xtype da push
                    padding: '7px 0px 7px 0px',
                    margin: '0px 0px 14px 0px',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-angle-right',
                    handler: 'onChildtap',
                    ui: 'button-tirkiz'
                },
                {
                    xtype: 'button',
                    text: 'О апликацији',
                    xtip: 'oProgramu', // koji xtype da push
                    padding: '7px 0px 7px 0px',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-angle-right',
                    handler: 'onChildtap',
                    ui: 'button-tirkiz'
                }
            ]
        },
    ]
});