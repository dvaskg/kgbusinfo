//
//
Ext.define('agrad.view.anketa.anketaController', {
      extend: 'Ext.app.ViewController',
      alias: 'controller.anketaController',
      init: function () { // izmena i brisanje - tasteri

            this.View = this.getView(); // .getView()
            this.VModel = this.getViewModel();
            this.LookStanField = this.View.lookupReference('refLookStan');
            this.formField = this.View.lookupReference('form');
            this.MainView = Ext.Viewport.down('navigationview');
      },
      onAfterrender: function (senderComponent, element, eOpts) {
            var me = this;
            Ext.Ajax.request({
                  url: 'resources/SQL/anketa/SQL_ankPitanja.php',
                  success: function (r) {
                        //create a json object from the response string
                        var res = Ext.decode(r.responseText, true);
                        // if we have a valid json object, then process it
                        if (res !== null && typeof (res) !== 'undefined') {
                              me.VModel.set('ankBtnDisabled', false); // oslobodi taster za anketu
                              me.rbrPitanja = 0;
                              me.pitanja = res.podaci;
                        }
                  },
                  failure: function (r) {

                  }
            });

      },
      onanketaZeli: function (thisButton, e, eOpts) {
            if (this.formField.validate()) {
                  this.MainView.push({
                        // Ext.Viewport.push({
                        xtype: 'anketaODG',
                        pitanja: this.pitanja,
                        rbrPitanja: 0 // da zna koje sledece da postavi
                  }); //
            }
      }
});