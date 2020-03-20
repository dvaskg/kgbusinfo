//
//
Ext.define('agrad.store.Lookup.stLookup_Stanice', {
    extend: 'agrad.store.BaseStore',
    alias: 'store.Lookup_Stanice',
    proxy: {
        type: 'BaseProxy',
        api: {
            read: 'resources/SQL/Lookup/SQL_Lookup_Stanice.php',
        }
    }
});