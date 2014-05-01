var Scheduler = function(config) {
    config = config || {};
    Scheduler.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connectorUrl: ''
    },
    attribution: function() {
        return {
            xtype: 'panel',
            bodyStyle: 'text-align: right; background: none; padding: 10px 0;',
            html: '<a href="https://www.modmore.com/extras/scheduler/"><img src="' + Scheduler.config.assetsUrl + 'img/small_modmore_logo.png" alt="a modmore product" /></a>',
            border: false,
            width: '98%',
            hidden: Scheduler.config.hideLogo
        };
    }
});
Ext.reg('scheduler', Scheduler);
Scheduler = new Scheduler();
