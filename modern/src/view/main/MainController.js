/**
 * This class is the controller for the main view for the application. It is specified as
 * the "controller" of the Main view class.
 */
Ext.define('agrad.view.main.MainController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.main',
    onMainRender: function (choice) {
        // console.log('------------------------------------');
        // console.log(Ext.query('.abp-badge')[0]);

        // u dataviewu je vec implementuran div class
        // ako u store, rec, upises set.badge, on se pojavi
        this.MainView = Ext.Viewport.down('navigationview');
        this.View = this.getView();
        this.VModel = this.getViewModel();




        this.MainView.on('back', function (thisView) {
            thisView.pop(this.getItems().length - 1);
            thisView.getNavigationBar().hide();
        });

    },
    onChildtap: function (thisButton, thisEventObject, eOpts) {
        this.MainView.getNavigationBar().show(); // PRIKAŽE toolbar, u Application.js ga je sakrio kad je prikazao Main.js
        this.MainView.push({
            xtype: thisButton.xtip,
        }); // 
    }

});