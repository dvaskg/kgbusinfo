//
//
Ext.define('agrad.view.anketa.anketaKrajController', {
      extend: 'Ext.app.ViewController',
      alias: 'controller.anketaKrajController',
      init: function (component) { // izmena i brisanje - tasteri
            this.View = this.getView(); // .getView()
            this.VModel = this.getViewModel();
            this.MainView = Ext.Viewport.down('navigationview');
      },
      onAfterrender: function (senderComponent, element, eOpts) {

      },
      onanketaKraj: function (thisButton, e, eOpts) {
            this.MainView.push({
                  xtype: 'anketaRezultat'
            }); //
      }
});