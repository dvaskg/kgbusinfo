Ext.define('agrad.view.Base.BaseTabelaController', { // 01/10/18
    extend: 'Ext.app.ViewController', // ver 1.0, sa tasterom brisanje
    init: function () { // izmena i brisanje - tasteri
        this.View = this.getView();
        this.VModel = this.getViewModel(); // treba za kasnije, za prikaz sume u dnu tabele
        this.Store = this.View.getStore();
        this.Proxy = this.Store.getProxy();
        this.ExtraParams = this.Proxy.getExtraParams();
        this.Controller = this;
        this.Store.on('beforeload', 'onBeforeload', this);
        this.Store.on('load', 'onStoreLoad', this);
        this.InitDodatno(this); // dodatna inicijalizacija
    },
    InitDodatno: function (control) {},


    onRowSelect: function (ThisView, record, index, eOpts) { // ako treba nesto da se na row select
        if (!Ext.isDefined(record)) {
            var record = {
                data: {}
            };
        } // ponisti sledbenu tabelu
        this.onRowSelectDodatno(ThisView, record, index, eOpts);

    },
    onRowSelectDodatno: function (ThisView, record, index, eOpts) { // ako treba nesto da se na row select
    },

    onPrikazi: function (controller, record) { // - ne koristi se u principu, ngo ovo dole nije pravi render - nego kad stigne listener da treba da se ucita nova priča
        // console.log("record:", record);
        this.DataStiglo = record; // ZAPAMTI pristigle podatke
        this.UcitajDodatneStore()
        if (this.VModel.data.ResetRecordToSelect) { // ako hoce na prikaz da resetuje poiner reda na 0
            this.Store.getProxy().RecordToSelect = 0; // na prikazi, uvek prikazuje 0.red
        }
        if (this.VModel.data.SamoJednomPrikazi) { // ako nece da se samo jednom prikazuje
            if (!this.prikazano) {
                this.prikazano = true;
                this.PrikaziMainStore();
            }
        } else {
            this.PrikaziMainStore();
        }
        this.onPrikaziDodatno();
    },
    onPrikaziDodatno: function (controller, record) { // - ne koristi se u principu, ngo ovo dole nije pravi render - nego kad stigne listener da treba da se ucita nova priča
        //nesto
    },
    UcitajDodatneStore: function () { // ucitava dodatne store za lookup

    },
    PrikaziMainStore: function () { // ucitava glavni store procedure, ovo se DISABLUJE, AKO SE CEKAJU OSTALI store-i
        this.Store.load(); // OVO SE DISABLUJE, AKO SE CEKAJU OSTALI store-i..
    },

    onBeforeload: function (store, records, successful, operation, eOpts) {
        this.ExtraParams.action = 0;
        this.onBeforeloadDodatno(store, records, successful, operation, eOpts);
    },
    onBeforeloadDodatno: function (store, records, successful, operation, eOpts) {},
    onStoreLoad: function (store, records, successful, operation, eOpts) { // sel.1. & prikaze tstere
        var me = this,
            tabela = this.View,
            controller = this.Controller; // nadje ovdi referencu do tabele
        if (!records.length) { // ako nema podataka, disable izmenu i brisanje
            controller['onSakriTastere'].call(me, controller); // , arg1, arg2
            controller['onRowSelect'].call(me, controller); // , arg1, arg2
        } else {
            Ext.Function.defer(function () {
                if (store.proxy.RecordToSelect > records.length - 1) {
                    store.proxy.RecordToSelect = 0;
                }
                tabela.select(store.proxy.RecordToSelect, true); // selektuje 1.red - ok radi
                // poziva fukciju u kontroleruu
                controller['onPrikaziTastere'].call(me, controller); // , arg1, arg2
            }, 100);
        }
        this.PrikaziSume(store, records, successful, operation);
    },
    // ---- ako ima jos tastera u bbau, pa treba da se disabluju
    onPrikaziTastere: function (ThisController) { // ovo ovveride za ostale tastere

    },
    onSakriTastere: function (ThisController) { // ovo ovveride za ostale tastere

    },

    PrikaziSume: function (store, records, successful, operation) { // prikazuje sume studenata u dnu tabele
    },
    onKeyup: function (field, event, eOpts) {
        var me = this,
            value = field.getValue(),
            controller = this.Controller;
        if (value == '') {
            field.getTrigger('clear').hide();
            controller.filterStore(value);
            controller.lastFilterValue = value;
        } else if (value && value !== this.lastFilterValue) {
            field.getTrigger('clear')[(value.length > 0) ? 'show' : 'hide']();
            controller.filterStore(value);
            controller.lastFilterValue = value;
        }
    },
    onRenderSearchField: function (field) {
        this.searchField = field; // zapamti koje je to polje
    },

    onClearTriggerClick: function (field) {
        this.ExtraParams.FilterTxt = null;
        this.Store.load();
        field.setValue();
        field.getTrigger('clear').hide();
    },
    onSearchTriggerClick: function (field) {
        this.filterStore(field.getValue());
    },
    filterStore: function (value) {
        var me = this,
            store = this.Store,
            searchString = value.toLowerCase(),
            filterFn = function (node) {
                var children = node.childNodes,
                    len = children && children.length,
                    visible = v.test(node.get('text')),
                    i;
                // If the current node does NOT match the search condition
                // specified by the user...
                if (!visible) {
                    // Check to see if any of the child nodes of this node
                    // match the search condition.  If they do then we will
                    // mark the current node as visible as well.
                    for (i = 0; i < len; i++) {
                        if (children[i].isLeaf()) {
                            visible = children[i].get('visible');
                        } else {
                            visible = filterFn(children[i]);
                        }
                        if (visible) {
                            break;
                        }
                    }
                } else { // Current node matches the search condition...
                    // Force all of its child nodes to be visible as well so
                    // that the user is able to select an example to display.
                    for (i = 0; i < len; i++) {
                        children[i].set('visible', true);
                    }
                }
                return visible;
            },
            v;
        this.ExtraParams.FilterTxt = value;
        this.Store.load();
    },
    strMarkRedPlus: function (search, subject) {
        return subject.replace(
            new RegExp('(' + search + ')', "gi"), "<span style='color: red;'><b>$1</b></span>");
    }

});