//
//
Ext.define('agrad.view.anketaODG.anketaODG', {
      extend: 'Ext.Container',
      xtype: 'anketaODG',
      controller: 'anketaODGController',
      viewModel: {
            data: {
                  DisableClrImputStan: true, // po defaultu ONEMOGUĆEN
            }
      },
      requires: [
            'Ext.ux.rating.Picker',
      ],
      title: 'Одабир стајалишта',

      layout: {
            type: 'vbox',
            align: 'center',
            pack: 'center'
      },
      // width: '100%',
      cls: 'anketaODG',
      viewModel: {
            data: {
                  ankBtnDisabled: true, // // 14 висе од onoga u fieldset-u
            }
      },
      items: [{
                  reference: 'refTxtPitanja',
                  cls: 'pitanje',
                  maxWidth: '77%',
                  html: 'Молимо да одговите на следећа питања анонимне анкете, која ће помоћи побољшању квалитета јавног превоза у нашем граду.',
            },
            {
                  xtype: 'formpanel',
                  reference: 'form',
                  defaultFocus: 'ItmID_LookStan',
                  layout: 'vbox',
                  items: [{
                              xtype: 'rating',
                              margin: '14px, 0px, 0px, 0px, ',
                              overStyle: 'color: lightgreen;',
                              reference: 'refZvezdice',
                              // style: 'color: lightgrey; ',
                              selectedStyle: 'color: darkgreen;',
                              trackOver: false,
                              minimum: 0,
                              rounding: 0.25, // bitno
                              scale: '377%',
                              listeners: {
                                    change: 'onDaoOcenu'
                              }
                        },
                        {
                              xtype: 'button',
                              text: 'Следеће питање',
                              // width: '77%',
                              formBind: true,
                              margin: '21px, 0px, 0px, 0px, ',
                              padding: '7px 0px 7px 0px',
                              iconAlign: 'right',
                              iconCls: 'x-fa fa-angle-right',
                              handler: 'onanketaOdgovor',
                              ui: 'button-tirkiz',
                              bind: {
                                    disabled: '{ankBtnDisabled}'
                              }
                        }
                  ]
            }
      ]
});