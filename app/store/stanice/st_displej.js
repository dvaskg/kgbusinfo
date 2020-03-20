//
//
Ext.define('agrad.store.stanice.st_displej', {
      extend: 'agrad.store.BaseStore',
      alias: 'store.displej',
      model: 'agrad.model.stanice.mod_displej',
      autoLoad: false,
      autoSync: false, // ovaj store je WinEdit CRUD
      remoteSort: true,
      // pageSize: 20,

      proxy: {
            type: 'BaseProxy',
            api: {
                  read: 'resources/SQL/stanice/SQL_displej.php',
            }
      }
});