//
//
Ext.define('agrad.view.anketa.anketaODGController', {
      extend: 'Ext.app.ViewController',
      alias: 'controller.anketaODGController',
      init: function (component) { // izmena i brisanje - tasteri
            // console.log('-----init-------------', component.pitanja);
            this.FldTxtPitanja = this.lookupReference('refTxtPitanja');
            this.FldTxtPitanja.setHtml(component.pitanja[component.rbrPitanja].pit);
            this.View = this.getView(); // .getView()
            this.VModel = this.getViewModel();

            this.FldZvezdice = this.lookupReference('refZvezdice');

            this.MainView = Ext.Viewport.down('navigationview');

      },
      onDaoOcenu: function (thisButton, e, eOpts) {
            this.VModel.set('ankBtnDisabled', false); // oslobodi dugme 'dalje'
      },
      onanketaOdgovor: function (thisButton, e, eOpts) {
            // console.log(" this.view.pitanja[this.view.rbrPitanja]:", this.view.pitanja[this.view.rbrPitanja]);
            // this.view.pitanja[this.view.rbrPitanja]
            Ext.Ajax.request({
                  url: 'resources/SQL/anketa/SQL_odgovorNaPitanje.php',
                  params: {
                        sfr: this.view.pitanja[this.view.rbrPitanja].sfr,
                        oce: this.FldZvezdice.getValue()
                  },
                  success: function (r) {},
                  failure: function (r) {

                  }
            });

            if ((this.view.pitanja.length - 1) == this.view.rbrPitanja) {
                  // console.log('------krsj---------');
                  this.MainView.push({
                        xtype: 'anketaKraj',
                        pitanja: this.view.pitanja,
                        rbrPitanja: this.view.rbrPitanja + 1 // da zna koje sledece da postavi
                  }); //
            } else {
                  this.MainView.push({
                        xtype: 'anketaODG',
                        pitanja: this.view.pitanja,
                        rbrPitanja: this.view.rbrPitanja + 1 // da zna koje sledece da postavi
                  }); //
            }
      }
});