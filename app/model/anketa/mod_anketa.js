//
//
Ext.define('agrad.model.stanice.mod_anketa', { // 
      extend: 'Ext.data.Model',
      // string int  number boolean date
      fields: [{
                  name: 'sfr', // 
                  type: 'int'
            },
            {
                  name: 'rbr', //
                  type: 'int'
            },
            {
                  name: 'pit', // 
                  type: 'string'
            },
            {
                  name: 'akt', // koliko stanica je daleko
                  type: 'int'
            },
      ]
});