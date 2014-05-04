// ---------------------------
// Create window
Scheduler.window.CreateRun = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('scheduler.run_create')
        ,cls: 'window-with-grid'
		,url: Scheduler.config.connectorUrl
		,baseParams: { action: 'mgr/runs/create' }
        ,width: 500
        ,modal: true
        ,defaults: { border: false }
        ,fields: [{
            xtype: 'scheduler-combo-tasklist'
            ,fieldLabel: _('scheduler.task')
            ,anchor: '100%'
            ,allowBlank: false
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
                    ,name: 'timing'
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
        },{
            xtype: 'scheduler-grid-future-run-localdata'
            ,id: 'scheduler-grid-future-run-localdata-'+this.ident
            ,preventRender: true
            ,record: config.record
        }]
	});
	Scheduler.window.CreateRun.superclass.constructor.call(this,config);
    this.on('render', this.initWindow);
    this.on('beforeSubmit', this.beforeSubmit);
};
Ext.extend(Scheduler.window.CreateRun, MODx.Window, {
    initWindow: function() {
        var grid = Ext.getCmp('scheduler-grid-future-run-localdata-'+this.ident),
            data = this.record && this.record.data ? Ext.util.JSON.decode(this.record.data) : false,
            store = grid.getStore();

        if (data) {
            Ext.iterate(data, function(k, v) {
                var rec = new grid.propRecord({ key: k, value: v });
                store.add(rec);
            });
        }
    }
    ,beforeSubmit: function() {
        var f = this.fp.getForm(),
            dataProperties = [],
            grid = Ext.getCmp('scheduler-grid-future-run-localdata-'+this.ident),
            data = grid.getStore().data;

        data.each(function(item) {
            dataProperties.push(item.data);
        });

        dataProperties = Ext.encode(dataProperties);
        Ext.apply(f.baseParams, { data: dataProperties });
    }
});
Ext.reg('scheduler-window-run-create', Scheduler.window.CreateRun);

// ---------------------------
// Update window
Scheduler.window.UpdateRun = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('scheduler.run_update')
        ,cls: 'window-with-grid'
		,url: Scheduler.config.connectorUrl
		,baseParams: { action: 'mgr/runs/update' }
        ,width: 500
        ,modal: true
        ,defaults: { border: false }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'scheduler-combo-tasklist'
            ,fieldLabel: _('scheduler.task')
            ,anchor: '100%'
            ,allowBlank: false
        },{
            xtype: 'xdatetime'
            ,name: 'timing'
            ,fieldLabel: _('scheduler.timing')
            ,anchor: '99%'
            ,allowBlank: true
        },{
            xtype: 'scheduler-grid-future-run-localdata'
            ,id: 'scheduler-grid-future-run-localdata-'+this.ident
            ,preventRender: true
        }]
	});
	Scheduler.window.UpdateRun.superclass.constructor.call(this,config);
    this.on('render', this.initWindow);
    this.on('beforeSubmit', this.beforeSubmit);
};
Ext.extend(Scheduler.window.UpdateRun, MODx.Window, {
    initWindow: function() {
        var grid = Ext.getCmp('scheduler-grid-future-run-localdata-'+this.ident),
            data = this.record && this.record.data ? Ext.util.JSON.decode(this.record.data) : false,
            store = grid.getStore();

        if (data) {
            Ext.iterate(data, function(k, v) {
                var rec = new grid.propRecord({ key: k, value: v });
                store.add(rec);
            });
        }
    }
    ,beforeSubmit: function() {
        var f = this.fp.getForm(),
            dataProperties = [],
            grid = Ext.getCmp('scheduler-grid-future-run-localdata-'+this.ident),
            data = grid.getStore().data;

        data.each(function(item) {
            dataProperties.push(item.data);
        });

        dataProperties = Ext.encode(dataProperties);
        Ext.apply(f.baseParams, { data: dataProperties });
    }
});
Ext.reg('scheduler-window-run-update', Scheduler.window.UpdateRun);

// -----------------------
// Add/update data property windows
Scheduler.window.RunDataPropertyCreate = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		title: _('scheduler.data.add')
        ,width: 450
        ,saveBtnText: _('done')
        ,defaults: { border: false }
        ,fields: [{
            xtype: 'textfield'
            ,name: 'key'
            ,fieldLabel: _('scheduler.data.key')
            ,anchor: '100%'
            ,allowBlank: false
        },{
            xtype: 'textarea'
            ,name: 'value'
            ,fieldLabel: _('scheduler.data.value')
            ,anchor: '100%'
        }]
	});
	Scheduler.window.RunDataPropertyCreate.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.window.RunDataPropertyCreate, MODx.Window, {
    submit: function() {
        var v = this.fp.getForm().getValues();

        var g = this.config.grid;
        var opt = eval(g.encode());
        Ext.apply(v,{
            options: opt
        });

        if (this.fp.getForm().isValid()) {
            if (this.fireEvent('success',v)) {
                this.fp.getForm().reset();
                this.hide();
                return true;
            }
        }
        return false;
    }
});
Ext.reg('scheduler-window-runs-adddataproperty', Scheduler.window.RunDataPropertyCreate);

Scheduler.window.RunDataPropertyUpdate = function(config) {
	config = config || {};
	Ext.applyIf(config,{
        title: _('scheduler.data.update')
        ,forceLayout: true
    });
	Scheduler.window.RunDataPropertyUpdate.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.window.RunDataPropertyUpdate, Scheduler.window.RunDataPropertyCreate, {});
Ext.reg('scheduler-window-runs-updatedataproperty', Scheduler.window.RunDataPropertyUpdate);