Scheduler.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config, {
		id: 'scheduler-home-panel'
		,baseCls: 'modx-formpanel'
		,cls: 'container'
        ,border: false
        ,items: [{
            xtype: 'panel'
            ,html: '<h2>' + _('scheduler') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,border: true
            ,autoTabs: true
            ,plain: true
            ,deferredRender: false

            ,stateful: true
            ,stateId: 'scheduler-tasks-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState: function() {
                return { activeTab: this.items.indexOf(this.getActiveTab()) };
            }

            ,defaults: {
                border: false
                ,autoHeight: true
                ,defaults: { border: false }
            }
            ,items: [{
                title: _('scheduler.tasks')
                ,items: [{
                    html: '<p>' + _('scheduler.tasks_desc') + '</p>'
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'scheduler-grid-upcomingtasks'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('scheduler.future')
                ,items: [{
                    html: '<p>' + _('scheduler.future_desc') + '</p>'
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'scheduler-grid-future'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('scheduler.history')
                ,items: [{
                    html: '<p>' + _('scheduler.history_desc') + '</p>'
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'scheduler-grid-history'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }]
        }]
    });

    Scheduler.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Scheduler.panel.Home, MODx.Panel);
Ext.reg('scheduler-panel-home', Scheduler.panel.Home);