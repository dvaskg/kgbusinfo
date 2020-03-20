//
//
Ext.define('agrad.view.anketa.anketaRezultat', {
      extend: 'agrad.view.Base.BaseTabela',
      xtype: 'anketaRezultat',
      controller: 'anketaRezultatController',
      // title: 'Доласци аутобуса на станицу 312-sds',
      requires: [
            'Ext.grid.cell.Number',
            'Ext.grid.cell.Widget',
            'Ext.ux.rating.Picker'
      ],
      store: {
            type: 'anketaRez'
      },
      listeners: {
            // beforerender: 'onbeforerender',
            painted: 'onPrikazi'
      },
      viewModel: {
            data: {
                  SamoJednomPrikazi: false, // ako treba samo jednom da prikaze na poziv tabelu
                  ResetRecordToSelect: false // da pri ucitavanju uvek selektuje 1. record
            }
      },

      layout: 'fit',
      columns: [{
                  text: 'Питање',
                  flex: 1,
                  dataIndex: 'pit',
                  menuDisabled: true, // ovo je najvaznije
                  sortable: false, // ipak će pokazivati strelice
                  hideable: false,
                  grouped: false,
                  flex: 1,
                  align: 'left',
                  cellWrap: true,
            },
            {
                  text: 'Резултат',
                  flex: 1,
                  dataIndex: 'prosek',
                  menuDisabled: true, // ovo je najvaznije
                  sortable: false, // ipak će pokazivati strelice
                  hideable: false,
                  grouped: false,
                  flex: 1,
                  align: 'left',
                  width: 117,
                  maxWidth: 117,
                  // disabled: true,
                  // editable: false,
                  cell: {
                        xtype: 'widgetcell',
                        widget: {
                              xtype: 'ratingBezUpdate',
                              overStyle: 'color: lightgreen;',
                              editable: false,
                              // style: 'color: lightgrey; ',
                              selectedStyle: 'color: darkgreen;',
                              trackOver: false,
                              minimum: 0,
                              rounding: 0.0001, // bitno
                              scale: '177%',
                              trackOver: false,
                        }
                  }
            }
      ]
});