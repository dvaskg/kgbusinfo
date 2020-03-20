//
//
Ext.define('agrad.store.anketa.st_anketaRez', {
      extend: 'agrad.store.BaseStore',
      alias: 'store.anketaRez',
      model: 'agrad.model.stanice.mod_anketa',
      autoLoad: false,
      autoSync: false, // ovaj store je WinEdit CRUD
      remoteSort: true,
      // pageSize: 20,

      proxy: {
            type: 'BaseProxy',
            api: {
                  read: 'resources/SQL/anketa/SQL_anketaRezultat.php',
            }
      }
});