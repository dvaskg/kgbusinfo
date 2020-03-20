//
//
Ext.define('agrad.Lang', { //'go.Lang' go.view.main.Lang
    singleton: true,
    // Komentari
    TxtCollapse: 'скупи текст',

    // тоолбар
    txt_RokMainTbar: ' у року: ',

    // Login meni
    Logn_NasEkrana: '<i class="fa fa-user fa-lg"></i> Пријава',
    Logn_User: 'Корисничко име: ',
    Logn_Pass: 'Лозинка: ',
    Logn_UserInvUnos: 'Морате унети корисничко име',
    Logn_Poruka: '<span style="font-size: small; color: grey; float: right;">Молимо унесите Ваше <br/>корисничко име и лозинку</span>',
    Logn_PorukaModern: '<span style="font-size: small; color: grey; ">Молимо унесите Ваше <br/>корисничко име и лозинку</span>',
    Logn_PorukaNe: '<span style="font-size: normal; color: red; float: right;"><strong>нетачно корисничко име или лозинка</strong></span>',
    Logn_PorukaNeModernAdmin: '<span style="font-size: normal; color: red; float: right;"><strong>само ОДБОРНИК или ГОСТ <br/>може може користити таблет <br/>или мобилни телефон</strong></span>',
    Logn_Button: '<i class="fa fa-mail-forward fa-lg"></i> Пријава',


    // tasteri forme
    tst_dodavanje: '<i class="fa fa-plus-square-o fa-2x"></i> Додавање',
    tst_izmena: '<i class="fa fa-edit fa-2x"></i> Измена',
    tst_brisanje: '<i class="fa fa-eraser fa-2x"></i> Брисање',
    tst_odustani: '<i class="fa fa-close fa-lg"></i> Излаз',
    tst_ok: '<i class="fa fa-check fa-lg"></i> ОК',

    // одјава из програма
    EkrOdjNaslov: 'одјава',
    EkrOdjPitanje: 'Желите ли да се одјавите из апликације ?',
    EkrOdjPitanjeModern: '<span style="color: red; float: left; padding-right: 12px"><i class="fa fa-question-circle fa-3x"></i></span>   Желите ли да се одјавите из апликације ?',
    // opcte
    ops_TstOdjava: '<i class="fa fa-power-off fa-x"></i> одјава, ',
    ops_TstOdjavaModern: '<i class="fa fa-power-off fa-lg"></i> одјава, ',
    ops_collapseToolText: 'склопи панел',
    ops_expandToolText: 'рашири панел',
    ops_NemaPodZaPrikaz: 'Нема података за приказ ...',
    ops_NemaKomenZaPrikaz: 'Нема коментара за приказ ...',
    ops_Greska: 'Грешка',
    ops_ucitavam: 'учитавање у току...',
    ops_SqlBlank: 'Сервер је завршио рад, не вративши никакав резултат<br/>функција није завршена исправно',
    ops_GreskaOdzivServera: 'Интернет сервер се не одазива',
    PdfulZat: 'затварање прозора ---->',
    apuNaslov: 'обавештење', // onAppUpdate - kad se posatvi nova verzija
    apuTxt: 'Администратор је поставио нову верзију апликације<br/>страница ће се учитати још једном.',
    apuOkNas: 'OK & настави', // ok & nastavi - taster

    // Ext.toast
    // print ekran sa ptanjem oce'l da stampa
    onTstStampa_title: 'штампа',
    onTstStampa_msg: 'Желите ли да штампате приказани списак ' + '? <br/>' + '<div style="font-size: 11px; color: grey;">*Списак ће се отворити у новом екрану.</div>',
    onTstStampa_yes: 'Да, желим да штампам списак',
    onTstStampa_no: 'Не',

    Toa_okDodato: '<i class="fa fa-check fa-lg fa-2x" style="color:green"> </i> Успешно додато',
    Toa_okIzmenjeno: '<i class="fa fa-check fa-lg fa-2x" style="color:green"> </i> Успешно измењено',
    Toa_okObrisano: '<i class="fa fa-check fa-lg fa-2x" style="color:green"> </i> Успешно обрисано',
    Toa_Cancel: '<i class="fa fa-info-circle fa-2x" style="color:goldenrod"> </i> Одустали сте од уноса',
    Toa_CancelSlanje: '<i class="fa fa-info-circle fa-2x" style="color:goldenrod"> </i> Одустали сте од слања',
    Toa_CancBri: '<i class="fa fa-info-circle fa-2x" style="color:goldenrod"> </i> Одустали сте од брисања',
    Toa_okIzmenjenoReset: '<i class="fa fa-info-circle fa-2x" style="color:red"> </i> Да би промене биве видљиве <br/>потребнан је рестарт <br/>апликације (без кеш меморије)'
});