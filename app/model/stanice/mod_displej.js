//
//
Ext.define('agrad.model.stanice.mod_displej', { // 
      extend: 'Ext.data.Model',
      // string int  number boolean date
      fields: [{
                  name: 'sfr_stan', // 
                  type: 'int'
            },
            {
                  name: 'sfr_auto', //
                  type: 'int'
            },
            {
                  name: 'oceDol', // u koliko sati se ocekuje dolazak na tu stanicu
                  type: 'date',
                  dateFormat: 'H:i:s'
            },
            {
                  name: 'kol_sta', // koliko stanica je daleko
                  type: 'int'
            },
            {
                  name: 'sfr_lin', // sifra linije koja dolazi
                  type: 'int'
            },
      ]
});