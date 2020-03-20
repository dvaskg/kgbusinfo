//
//
Ext.define('agrad.view.oProgramu.oProgramu', {
      extend: 'Ext.Container',
      xtype: 'oProgramu',
      // controller: 'oProgramuController',
      viewModel: {
            data: {
                  DisableClrImputStan: true, // po defaultu ONEMOGUĆEN
            }
      },
      layout: {
            type: 'vbox',
            align: 'center',
            // pack: 'center'
      },
      scrollable: true,
      cls: 'oProgramu',
      viewModel: {
            data: {
                  ankBtnDisabled: true, // // 14 висе од onoga u fieldset-u
            }
      },
      height: '100%',
      bodyPadding: 7,
      items: [{
                  html: '<p style="font-size: x-small; text-align: center;">Иницијатива је подржана од стране пројекта “Отворени подаци – отворене могућности”, који спроводе Канцеларија за информационе технологије и електронску управу и Програм Уједињених нација за развој, уз подршку Светске банке и Фонда за добру управу Уједињеног Краљевства</p>',
                  maxWidth: '80%',
            },
            {
                  html: '<table  align="center">' +

                        '<tr valign="center">' +
                        '<th colspan="2"><img src="/resources/images/euprava-cir.gif" alt=""></th>' +
                        '</tr>' +

                        '<tr valign="center">' +
                        '<th colspan="2"><img style="width: 272px;"; src="/resources/images/WBG_Horizontal-black-web.jpg" alt="" ></th>' +
                        '</tr>' +


                        '<tr valign="center">' +
                        '<th><img style="height: 97px;" src="/resources/images/britAmbBeograd.gif" alt=""></th>' +
                        '<th><img style="height: 97px;" src="/resources/images/UK_aid.gif" alt=""></th>' +
                        '</tr>' +

                        '<tr valign="center">' +
                        '<th colspan="2"><img  src="/resources/images/UNDP_Logo--ENG.png" alt=""></th>' +
                        '</tr>' +

                        '</table>'
            },
            {
                  html: '<p style="font-size: x-small; text-align: center;">За садржај ове апликације одговорни су искључиво аутори, а изнети ставови не представљају нужно ставове Владе Уједињеног Краљевства, Светске банке, Канцеларије за информационе технологије и електронску управу, Уједињених нација и Програма за развој Уједињених нација.</p>',
                  maxWidth: '80%',
            },
      ]
});