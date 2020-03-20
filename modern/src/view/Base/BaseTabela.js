Ext.define('agrad.view.Base.BaseTabela', { // 22/12/18
    extend: 'Ext.grid.Grid',
    requires: [
        'Ext.grid.plugin.RowExpander'
    ],
    listeners: {
        select: 'onRowSelect'
    },
    layout: 'fit',
    selModel: {
        pruneRemoved: true // Remove records from the selection when they are removed from the store
        // should be set to false when using a buffered Store. Defaults to: true
    },
    viewConfig: {
        stripeRows: false,
        forceFit: true,
        preserveScrollOnRefresh: true,
        preserveScrollOnReload: true
    },
    viewModel: {
        data: {
            SamoJednomPrikazi: false, // ako treba samo jednom da prikaze na poziv tabelu

            ResetRecordToSelect: false // da pri ucitavanju uvek selektuje 1. record
        }
    },
    emptyText: agrad.Lang.ops_NemaPodZaPrikaz,
    rowLines: true,
    shadow: true,
    selectable: {
        mode: 'single'
    },
});