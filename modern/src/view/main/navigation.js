Ext.define('agrad.view.main.navigation', {
      extend: 'Ext.navigation.View',
      xtype: 'navigation',
      controller: 'navigationController',
      defaultBackButtonText: 'повратак',

      listeners: {
            back: 'onBack', //
            push: 'onPush', //
            // resize: 'onOrijentChange'
      },

});