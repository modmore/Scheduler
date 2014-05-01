Ext.onReady(function() {
    MODx.load({
        xtype: 'scheduler-page-home'
        ,renderTo: 'scheduler-wrapper-div'
    });
    MODx.config.help_url = 'https://www.modmore.com/extras/scheduler/documentation/?embed=1';
});

Scheduler.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'scheduler-page-home'
        ,components: [{
            xtype: 'scheduler-panel-home'
        }
        ,Scheduler.attribution()]
        ,buttons: ['<b>' + _('scheduler.tbar.queued') + ':</b>',{
            xtype: 'tbtext'
            ,text: '0'
            ,id: 'scheduler-upcoming-queued'
        }, '&bull;', '<b>' + _('scheduler.tbar.pastdue') + ':</b>', {
            xtype: 'tbtext'
            ,text: '0'
            ,id: 'scheduler-upcoming-pastdue'
        }, '&bull;', '<b>' + _('scheduler.tbar.running') + ':</b>', {
            xtype: 'tbtext'
            ,text: '0'
            ,id: 'scheduler-upcoming-running'
        }, '&bull;', '<b>' + _('scheduler.tbar.completed') + ':</b>', {
            xtype: 'tbtext'
            ,text: '0'
            ,id: 'scheduler-upcoming-completed'
        },' ',{
            text: _('help_ex')
            ,handler: MODx.loadHelpPane
            ,id: 'modx-abtn-help'
        }]
        ,listeners: {
            render: this.loadStats
        }
    });
    Scheduler.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.page.Home,MODx.Component,{
    initiatedInterval: false,
    loadStats: function() {
        if (!this.initiatedInterval) {
            setInterval(this.loadStats, 30000);
            this.initiatedInterval = true;
        }
        MODx.Ajax.request({
            url: Scheduler.config.connectorUrl
            ,params: {
                action: 'mgr/tasks/getstats'
            }
            ,listeners: {
                'success': {fn: function(result) {
                    Ext.iterate(result.stats, function(id, value) {
                        var cmp = Ext.getCmp(id);
                        if (cmp) cmp.setText(value);
                    });
                }, scope: this}
            }
        });
    }
});
Ext.reg('scheduler-page-home',Scheduler.page.Home);
