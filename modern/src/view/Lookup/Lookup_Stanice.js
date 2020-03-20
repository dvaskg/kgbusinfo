//
//
Ext.define('agrad.view.system.Lookup_Stanice', { // IZBOR STANICE
      extend: 'Ext.form.field.ComboBox',
      xtype: 'Lookup_Stanice',
      store: {
            type: 'Lookup_Stanice',
      },
      reference: 'refComboStanice',
      valueField: 'sfr',
      displayField: 'sfr_korIme',
      queryMode: 'remote',
      queryCaching: true,
      pageSize: 10, // mora i u storeu

      triggers: {
            foo: {
                  // cls: 'x-form-date-trigger my-foo-trigger',
                  iconCls: 'x-fa fa-times',
                  handler: function () {
                        this.clearValue;
                        this.setValue(null);
                        this.setSelection(null);
                        this.getPicker().clearValue;

                        this.clearValue;
                        this.setValue(null);
                        this.setSelection(null);
                        this.getPicker().clearValue;

                        // console.log('foo trigger clicked', this);
                  },
                  bind: {
                        hidden: '{DisableClrImputStan}',
                  }
            }
      }, // },
      flex: 1,
      loadingText: 'Претрага у току...',
      selectOnFocus: true,
      minChars: 1,
      triggerAction: 'all',
      anyMatch: true,
      autoSelect: true,
      typeAhead: true,
      collapseOnSelect: true,
      enableKeyEvents: true,
      selectOnTab: true,
      editable: true,
      forceSelection: true,
      allowBlank: false,
      minWidth: 270,
      itemTpl: [ // lista - prikaz
            '{[values.sfr_korIme]}'
      ],
      displayTpl: Ext.create('Ext.XTemplate', // u polju kako da prikazuje, bez tagova
            '<tpl for=".">',
            '{sfr_korIme:stripTags}',
            '</tpl>'
      ),

});