Ext.define('agrad.view.stanice.stanice', {
      extend: 'agrad.view.Base.BaseTabela',
      xtype: 'stanice',
      controller: 'staniceController',
      title: 'Доласци аутобуса на станицу',
      store: {
            type: 'displej'
      },
      viewModel: {
            data: {
                  SamoJednomPrikazi: false, // ako treba samo jednom da prikaze na poziv tabelu
                  ResetRecordToSelect: false // da pri ucitavanju uvek selektuje 1. record
            }
      },

      layout: 'fit',
      columns: [{
                  text: 'Линија',
                  flex: 1,
                  menuDisabled: true, // ovo je najvaznije
                  sortable: false, // ipak će pokazivati strelice
                  hideable: false,
                  grouped: false,
                  dataIndex: 'ozn',
            },
            {
                  text: 'Очекиван</br>долазак',
                  flex: 2,
                  menuDisabled: true, // ovo je najvaznije
                  sortable: false, // ipak će pokazivati strelice
                  hideable: false,
                  grouped: false,
                  dataIndex: 'oceDol',
                  cell: {
                        encodeHtml: false
                  },
                  renderer: function (value, record) {
                        return Ext.Date.format(value, 'i мин s сек');
                  }


            },
            {
                  text: 'Попуњеност/ </br>слободно места',
                  flex: 2,
                  dataIndex: 'ki',
                  menuDisabled: true, // ovo je najvaznije
                  sortable: false, // ipak će pokazivati strelice
                  hideable: false,
                  grouped: false,
                  align: 'left',
                  cell: {
                        xtype: 'widgetcell',
                        widget: {
                              xtype: 'progress',
                              textTpl: new Ext.XTemplate(
                                    '{percent:number("0")}% попуњено'
                              )
                        },
                  }
            },
      ],
});