//

Ext.define('agrad.GloVar', { //agrad.GloVar     agrad.view.main.GloVar
    singleton: true,
    test: 'sds',
    FilterTxtMSel: '', // za bojadisanje Ext.view.MultiSelectorSearch
    // --------
    UserData: { // setuje se u napuniGlovar- app
    },
    ChangeStore: { // podaci o zadnjoj izmeni storea
        saradnici: null
    },
    NapuniGlobalneVarijable: function (Data) {
        agrad.GloVar.UserData = Data;
        var podloga = document.getElementsByClassName('FrontLogo')[0];
        if (Ext.isDefined(podloga)) { // modern je već ubio
            podloga.remove();
        }
    },
    PrikaziGreskuServera: function (form, action) {
        if (action.failureType === 'load') {
            if (Ext.isDefined(action.result)) {
                // console.log('-----------1-------------------------');
                Ext.Msg.alert(action.result.naslov, action.result.opis); // za greske proceduralnog tip, sa sw/hw je sve u redu.
            } else {
                Ext.Msg.alert(agrad.Lang.ops_Greska, agrad.Lang.ops_SqlBlank); // sql završio blanko rezultat 
            }
        } else if (action.failureType === Ext.form.action.Action.CLIENT_INVALID) {
            Ext.Msg.alert('Неисправан клијент', 'нешто је пропуштено, молимо проверите још једном и покушајте поново.');
        } else if (action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
            Ext.Msg.show({
                title: 'Грешка у конекцији са сервером',
                message: 'тип грешке : ' + action.failureType + '</br> веза са сервером тренутно је у прекуиду. </br>Молимо покушајте касније поново.',
                buttons: Ext.Msg.YES,
                buttonText: {
                    yes: 'OK & настави'
                },
                icon: Ext.Msg.ERROR
            });
        } else if (action.failureType === Ext.form.action.Action.SERVER_INVALID) {
            // console.log("action.result SERVER_INVALID:", action);
            if (Ext.isDefined(action.result)) { // sa softverom je sve ok, procdeura je upitanju
                if (Ext.isDefined(action.result.data)) {
                    Ext.Msg.alert('грешка', action.result.data); // za greske proceduralnog tip, sa sw/hw je sve u redu.
                    Ext.MessageBox.show({
                        title: action.result.data.naslov,
                        msg: action.result.data.opis,
                        buttonText: {
                            yes: 'Ok & настави',
                        },
                        icon: Ext.MessageBox.ERROR, // INFO, ERROR, WARNING and QUESTION
                    });
                    Ext.MessageBox.focus(); // izuzetno vazno !!

                } else {
                    Ext.MessageBox.show({
                        title: action.result.naslov,
                        msg: action.result.opis,
                        buttonText: {
                            yes: 'Ok & настави',
                        },
                        icon: Ext.MessageBox.ERROR, // INFO, ERROR, WARNING and QUESTION
                    });
                    Ext.MessageBox.focus(); // izuzetno vazno !!
                }
            } else {
                Ext.MessageBox.show({
                    title: 'Одговор сервера није валидан',
                    msg: 'тип грешке : ' + action.failureType + '  ' + '</br>' + action.response.responseText + '</br>' + action.response.status + '</br>' + action.response.statusText,
                    buttonText: {
                        yes: 'OK & настави'
                    },
                    icon: Ext.Msg.ERROR
                });
                Ext.MessageBox.focus(); // izuzetno vazno !!
            }
        }
        // ---------- za ajax call
        if (!Ext.isDefined(action.failureType)) {
            if (form.status != 200) {
                Ext.Msg.show({
                    title: 'WEB сервер је јавио фаталну грешку',
                    message: 'тип грешке : ' + form.status + '  ' + '</br>' + form.statusText,
                    buttons: Ext.Msg.YES,
                    buttonText: {
                        yes: 'OK & настави'
                    },
                    icon: Ext.Msg.ERROR
                });
            } else {
                var data = Ext.decode(form.responseText);
                Ext.Msg.show({
                    title: 'WEB сервер је јавио грешку',
                    msg: 'тип грешке : ' + form.status + '  ' + '</br>' + data.naslov + '</br>' + data.opis,
                    buttons: Ext.Msg.YES,
                    buttonText: {
                        yes: 'OK & настави'
                    },
                    icon: Ext.Msg.ERROR
                });
            }
        }
    },
    PrikaziGresku404: function (action) {
        if (action.error) {
            Ext.MessageBox.show({
                title: 'WEB сервер се не одазива',
                message: 'тип грешке : ' + action.error.status + ' - ' + action.error.statusText + '</br>' + action.error.response.request.options.url + '</br>узрок може били лоша интернет веза',
                buttons: Ext.Msg.YES,
                buttonText: {
                    yes: 'OK & настави'
                },
                maxWidth: 350,
                icon: Ext.Msg.ERROR
            });
            Ext.MessageBox.focus(); // izuzetno vazno !!
        } else {
            // var data = Ext.decode(action._response.responseJson);
            var data = action._response.responseJson;
            Ext.MessageBox.show({
                title: data.naslov,
                message: data.opis,
                buttons: Ext.Msg.YES,
                buttonText: {
                    yes: 'OK & настави'
                },
                maxWidth: 350,
                icon: Ext.Msg.ERROR
            });
            Ext.MessageBox.focus(); // izuzetno vazno !!

        }
    },

    PrikaziGreskuServeraModrn: function (form, action) {
        Ext.Msg.show({
            title: action.naslov, // 'WEB сервер је јавио грешку',
            message: action.opis, //'тип грешке : ' + form.status + '  ' + '</br>' + data.naslov,
            buttons: Ext.Msg.YES,
            icon: Ext.Msg.ERROR
        });
    },
    strip_html_tags: function (str) {
        if (!str || typeof str === 'undefined' || str === null) {
            return false;
        }
        var re = new RegExp('(<([^>]+)>)', 'ig');
        return str.replace(re, "");

    },
    DodajVodeceNule: function (Broj, Duzina) {
        var s = String(Broj);
        while (s.length < (Duzina || 2)) {
            s = "0" + s;
        }
        return s
    },
    strMarkRedPlus: function (search, subject) {
        console.log("strMarkRedPlus search:", search);
        if (search) {
            return subject.replace(
                new RegExp('(' + search + ')', "gi"), "<span style='color: red;'>$1</span>");
        } else {
            return subject;
        }
    },
    izCiruLat: function (txt) {
        var cir = ['а', 'б', 'в', 'г', 'д', 'е', 'ћ', 'ђ', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'љ', 'м', 'н', 'њ', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'џ', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'Ћ', 'Ђ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'Љ', 'М', 'Н', 'Њ', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Џ', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        var lat = ['a', 'b', 'v', 'g', 'd', 'e', 'c', 'dj', 'e', 'z', 'z', 'i', 'j', 'k', 'l', 'lj', 'm', 'n', 'nj', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'c', 'dz', 's', 's', 'i', 'j', 'j', 'e', 'ju', 'ja',
            'C', 'Dj', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Z', 'Z', 'I', 'J', 'K', 'L', 'Lj', 'M', 'N', 'Nj', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'C', 'Dz', 'S', 'S', 'I', 'J', 'J', 'E', 'Ju', 'Ja'
        ];
        return this.replaceBulk(txt, cir, lat);
    },
    replaceBulk: function (str, findArray, replaceArray) {
        var i, regex = [],
            map = {};
        for (i = 0; i < findArray.length; i++) {
            regex.push(findArray[i].replace(/([-[\]{}()*+?.\\^$|#,])/g, '\\$1'));
            map[findArray[i]] = replaceArray[i];
        }
        regex = regex.join('|');
        str = str.replace(new RegExp(regex, 'g'), function (matched) {
            return map[matched];
        });
        return str;
    }
});