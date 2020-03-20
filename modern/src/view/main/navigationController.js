Ext.define('agrad.view.main.navigationController', {
      extend: 'Ext.app.ViewController',
      alias: 'controller.navigationController',

      onBack: function (thisView, eOpts) {
            var aktItem = thisView.getActiveItem().xtype;
            if (aktItem == 'app-main') { // ako je glavni ekran, sakri navig.bar
                  thisView.getNavigationBar().hide();
            }
      },
      onPush: function (thisView, pushedView, eOpts) {
            thisView.getNavigationBar().show(); // кад га гурне, омогући повратак
      }

});