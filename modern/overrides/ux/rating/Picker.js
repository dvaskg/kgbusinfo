Ext.define('Ext.override.rating.Picker', {
      extend: 'Ext.ux.rating.Picker', //
      xtype: 'ratingBezUpdate',
      onClick: function (event) { // da ne mož se edituje
            // var value = this.valueFromEvent(event);
            // console.log('----------onClick---------onClick-----------------');
            // this.setValue(value);
      }
});