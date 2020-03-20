//
//
Ext.define('agrad.view.anketa.anketaKraj', {
      extend: 'Ext.Container',
      xtype: 'anketaKraj',
      controller: 'anketaKrajController',
      viewModel: {
            data: {
                  DisableClrImputStan: true, // po defaultu ONEMOGUĆEN
            }
      },
      listeners: {
            painted: 'onAfterrender'
      },
      title: 'Одабир стајалишта',

      layout: {
            type: 'vbox',
            align: 'center',
            pack: 'center'
      },
      viewModel: {
            data: {
                  ankBtnDisabled: true, // // 14 висе од onoga u fieldset-u
            }
      },
      items: [{
                  cls: 'pitanjeUvod',
                  reference: 'refTxtPitanja',
                  maxWidth: 270,
                  html: 'Захваљујемо на стрпљену и одговорима на сва питања из Анкете. ' +
                        '</br>У наставку можете видети резултате анкете, како су други грађани, ' +
                        ' у просеку одговорили на иста питања',
            },
            {
                  xtype: 'formpanel',
                  reference: 'form',
                  defaultFocus: 'ItmID_LookStan',
                  layout: 'vbox',
                  // ui: 'auth',
                  items: [{
                        xtype: 'button',
                        text: 'Резулат анкете',
                        formBind: true,
                        padding: '7px 0px 7px 0px',
                        iconAlign: 'right',
                        iconCls: 'x-fa fa-angle-right',
                        handler: 'onanketaKraj',
                        ui: 'button-tirkiz',
                        // bind: {
                        //       disabled: '{ankBtnDisabled}'
                        // }
                  }]
            }
      ]
});