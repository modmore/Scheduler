Ext.onReady(function() {
    MODx.load({
        xtype: 'scheduler-page-home',
        renderTo: 'scheduler-wrapper-div'
    });
    MODx.config.help_url = 'https://www.modmore.com/extras/scheduler/documentation/';
});

Scheduler.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        cls: 'container form-with-labels',
        id: 'scheduler-page-home',
        border: false,
        components: [{
            xtype: 'panel',
            html: '<h2>' + _('scheduler') + '</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                defaults: {
                    border: false
                }
            },
            items: [{
                title: _('scheduler.tasks'),
                cls: 'main-wrapper',
                items: [{
                    xtype: 'scheduler-grid-upcomingtasks'
                }]
            },{
                title: _('scheduler.history'),
                cls: 'main-wrapper',
                items: [{
                    xtype: 'scheduler-grid-history'
                }]
            }]
        },Scheduler.attribution()],
        buttons: ['<b>' + _('scheduler.queued') + ':</b>',{
            xtype: 'tbtext',
            text: '0',
            id: 'scheduler-upcoming-queued'
        }, '&bull;', '<b>' + _('scheduler.pastdue') + ':</b>', {
            xtype: 'tbtext',
            text: '0',
            id: 'scheduler-upcoming-pastdue'
        }, '&bull;', '<b>' + _('scheduler.running') + ':</b>', {
            xtype: 'tbtext',
            text: '0',
            id: 'scheduler-upcoming-running'
        }, '&bull;', '<b>' + _('scheduler.completed') + ':</b>', {
            xtype: 'tbtext',
            text: '0',
            id: 'scheduler-upcoming-completed'
        },' ',{
            text: _('help_ex')
            ,handler: MODx.loadHelpPane
            ,id: 'modx-abtn-help'
        }],

        listeners: {
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
