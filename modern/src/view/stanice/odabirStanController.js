//
//
Ext.define('agrad.view.stanice.odabirStanController', {
      extend: 'Ext.app.ViewController',
      alias: 'controller.odabirStanController',
      init: function () { // izmena i brisanje - tasteri
            // console.log('-----init-------------------------------');

            this.View = this.getView(); // .getView()
            this.VModel = this.getViewModel();
            this.LookStanField = this.View.lookupReference('refLookStan');
            this.formField = this.View.lookupReference('form');
            this.MainView = Ext.Viewport.down('navigationview');
            this.FldTxtStanice = this.lookupReference('refTxtStanice');

      },
      onAfterrender: function (senderComponent, element, eOpts) {
            var me = this;
            Ext.Function.defer(function () {
                  me.LookStanField.focus();
            }, 500);
      },
      onChange_LookStan: function (thisComboBox, newValue, oldValue, eOpts) { // kad otkuca broj stanice
            var me = this;
            Ext.Ajax.request({
                  url: 'resources/SQL/Lookup/SQL_Lookup_StaniceSingl.php',
                  params: {
                        query: this.LookStanField.getValue()
                  },
                  success: function (r) {
                        var res = Ext.decode(r.responseText, true);
                        if (Ext.isDefined(res.podaci[0]) && typeof (res) !== 'undefined') {
                              // console.log("res:", res);
                              me.FldTxtStanice.setHtml(res.podaci[0].sfr_korIme);
                              me.VModel.set('DisableClrImputStan', false);
                        } else {
                              // console.log('-----nedef------------------');
                              me.FldTxtStanice.setHtml(null);
                              me.VModel.set('DisableClrImputStan', true);
                        }
                  },
                  failure: function (r) {
                        me.VModel.set('DisableClrImputStan', true);
                  }
            });

      },
      onOdabirStanice: function (thisButton, e, eOpts) {
            if (this.formField.validate()) {
                  this.MainView.push({
                        xtype: 'stanice',
                  }); //
                  this.fireEvent('Activatedisplay', this, this.LookStanField.getValue());
            } else {
                  Ext.toast('Молимо унесите број стајалишта са табле станице на којој чекате аутобус.');
                  this.LookStanField.focus();
            }
      }
});