//
//
Ext.define('agrad.view.anketa.anketa', {
      extend: 'Ext.Container',
      xtype: 'anketa',
      controller: 'anketaController',
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
      // width: '100%',
      viewModel: {
            data: {
                  ankBtnDisabled: true, // // 14 висе од onoga u fieldset-u
            }
      },
      items: [{
                  cls: 'auth-header',
                  maxWidth: 270,
                  cls: 'pitanjeUvod',
                  html: 'Молимо да одговите на следећа питања анонимне анкете, која ће помоћи побољшању квалитета јавног превоза у нашем граду.',
                  // 'Број станице се налази на табли стајалишта на коме стојите' +
                  // ''
            },
            {
                  xtype: 'formpanel',
                  reference: 'form',
                  defaultFocus: 'ItmID_LookStan',
                  layout: 'vbox',
                  items: [{
                        xtype: 'button',
                        text: 'АНКЕТА',
                        formBind: true,
                        padding: '7px 0px 7px 0px',
                        iconAlign: 'right',
                        iconCls: 'x-fa fa-angle-right',
                        handler: 'onanketaZeli',
                        ui: 'button-tirkiz',
                        bind: {
                              disabled: '{ankBtnDisabled}'
                        }
                  }]
            }
      ]
});