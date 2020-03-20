//
//
Ext.define('agrad.proxy.BaseProxy', {
    extend: 'Ext.data.proxy.Ajax',
    alias: 'proxy.BaseProxy',
    type: 'rest',
    batchActions: false, // da ne saje sve recs. odjednom
    reader: {
        type: 'json',
        rootProperty: 'podaci',
        totalProperty: 'TotalRecs',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'Procedure_RowID'
    },
    writer: {
        type: 'json',
        encode: true,
        allowSingle: true,
        writeAllFields: true,
        // autoSync: true,
        rootProperty: 'podaci'
    },
    actionMethods: {
        create: 'POST',
        read: 'POST',
        update: 'POST',
        destroy: 'POST'
    },
    extraParams: {
        'action': null, // akcija
    },

    listeners: {
        exception: function (proxy, response, operation) {
            this.fireEvent('ProxyGreska', this, response, operation);
        }
    },
    afterRequest: function (request, success) { // override metod, kad je ok, daje toast
        var Operacija = request.getOperation();
        var action = Operacija.getProxy().extraParams.action;
        if (!Operacija.exception & action != 0) {
            switch (action) {
                case 1:
                    Ext.toast(agrad.Lang.Toa_okDodato);
                    break;
                case 2:
                    Ext.toast(agrad.Lang.Toa_okIzmenjeno);
                    break;
                case 3:
                    Ext.toast(agrad.Lang.Toa_okObrisano);
                    break;
            }
            this.fireEvent('ProxyOK', this, request, success);
        } else {
            if (Operacija.exception) {
                agrad.GloVar.PrikaziGresku404(Operacija); // prikaže 404
            }
        }
    },
    RecordToSelect: 0
});