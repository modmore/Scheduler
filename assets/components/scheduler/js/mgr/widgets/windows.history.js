// ---------------------------
// Create window
Scheduler.window.ReScheduleRun = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('scheduler.reschedule')
        ,cls: 'window-with-grid'
        ,url: Scheduler.config.connectorUrl
		,baseParams: { action: 'mgr/runs/reschedule' }
        ,width: 500
        ,modal: true
        ,defaults: { border: false }
        ,saveBtnText: _('scheduler.reschedule')
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            layout: 'column'
            ,border: false
            ,items: [{
                layout: 'form'
                ,columnWidth: .5
                ,items: [{
                    xtype: 'compositefield'
                    ,fieldLabel: _('scheduler.timing.inabout')
                    ,anchor: '100%'
                    ,items: [{
                        xtype: 'numberfield'
                        ,name: 'timing_number'
                        ,allowBlank: false
                        ,allowDecimals: false
                        ,allowNegative: false
                        ,value: 1
                        ,width: 60
                    },{
                        xtype: 'modx-combo'
                        ,store: [
                            ['minute', _('scheduler.time.m')]
                            ,['hour', _('scheduler.time.h')]
                            ,['day', _('scheduler.time.d')]
                            ,['month', _('scheduler.time.mnt')]
                            ,['year', _('scheduler.time.y')]
                        ]
                        ,name: 'timing_interval'
                        ,hiddenName: 'timing_interval'
                        ,allowBlank: false
                        ,value: 'minute'
                        ,flex: 1
                    }]
                }]
            },{
                layout: 'form'
                ,columnWidth: .5
                ,items: [{
                    xtype: 'xdatetime'
                    ,name: 'timing_new' /* "_new" To avoid setValue features */
                    ,fieldLabel: _('scheduler.timing')
                    ,anchor: '99%'
                    ,allowBlank: true
                }]
            }]
        },{
            xtype: 'label'
            ,html: _('scheduler.timing.desc')
            ,cls: 'desc-under'
            ,style: 'padding-top: 5px;'
        }]
	});
	Scheduler.window.ReScheduleRun.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.window.ReScheduleRun, MODx.Window);
Ext.reg('scheduler-window-run-reschedule', Scheduler.window.ReScheduleRun);