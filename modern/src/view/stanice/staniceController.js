//
//
Ext.define('agrad.view.stanice.staniceController', {
      extend: 'agrad.view.Base.BaseTabelaController',
      alias: 'controller.staniceController',
      listen: { // NE TREBAJU LISTENERI ZA STORE, to atomatski dobije na onPrikazi
            controller: { // popuniti contr & event
                  'odabirStanController': { // kontroler koji slušamo, salje  (sfr_saz, zadnji)
                        Activatedisplay: 'onPrikazi' // slusa isti event kao conteiner
                  }
            },
      },
      onBeforeloadDodatno: function (store, records, successful, operation, eOpts) {
            // console.log(this.DataStiglo);
            this.ExtraParams.sfr_stan = this.DataStiglo;
      },
      onWigAttStanje: function (col, widget, record) {
            console.log("record:", record);

      }

});