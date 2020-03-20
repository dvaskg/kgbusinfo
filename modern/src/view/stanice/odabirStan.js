//
//
Ext.define('agrad.view.stanice.odabirStan', {
      extend: 'Ext.Container',
      xtype: 'odabirStan',
      controller: 'odabirStanController',
      viewModel: {
            data: {
                  DisableClrImputStan: true, // po defaultu ONEMOGUĆEN
            }
      },
      listeners: {
            // beforerender: 'onbeforerender',
            painted: 'onAfterrender'
      },
      title: 'Одабир стајалишта',

      layout: {
            type: 'vbox',
            align: 'center',
            pack: 'center'
      },
      // width: '100%',

      items: [{
                  cls: 'auth-header',
                  maxWidth: 270,
                  html: 'Унесите број стајалишта на коме чекате аутобус.</br>' +
                        'Број станице се налази на табли стајалишта на коме стојите' +
                        ''
            },
            {
                  reference: 'refTxtStanice',
                  cls: 'pitanje',
                  // maxWidth: 270,
                  margin: '14, 0, 0, 0s',
                  maxWidth: '77%',
                  html: '',
                  // 'Број станице се налази на табли стајалишта на коме стојите' +
                  // ''
            },
            {
                  xtype: 'formpanel',
                  reference: 'form',
                  defaultFocus: 'ItmID_LookStan',
                  layout: 'vbox',
                  // ui: 'auth',
                  items: [{
                              // xtype: 'Lookup_Stanice',
                              xtype: 'textfield',
                              text: 'Смер превоза',
                              flex: 1,
                              required: true,
                              reference: 'refLookStan',
                              labelAlign: 'placeholder',
                              label: 'Број стајалишта',
                              // name: 'LookStan',
                              itemId: 'ItmID_LookStan',
                              // margin: '0 8 7 0', //(top, right, bottom, left) 
                              listeners: {
                                    // scope: this,
                                    change: 'onChange_LookStan' // dal da omogući unos opisnih ocena
                              }
                        },
                        {
                              xtype: 'button',
                              text: 'Одабир',
                              formBind: true,
                              padding: '7px 0px 7px 0px',
                              iconAlign: 'right',
                              iconCls: 'x-fa fa-angle-right',
                              handler: 'onOdabirStanice',
                              bind: {
                                    disabled: '{DisableClrImputStan}',
                              },
                              ui: 'button-tirkiz'
                        }
                  ]
            }
      ]
});