Scheduler.window.CreateUpdateRun = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('scheduler.run_create')
        ,cls: 'window-with-grid'
		,url: Scheduler.config.connectorUrl
		,baseParams: {
			action: ((config.isUpdate) ? 'mgr/runs/update' : 'mgr/runs/create')
		}
        ,width: 550
        ,modal: true
        ,defaults: { border: false }
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
                    xtype: 'scheduler-combo-tasklist'
                    ,fieldLabel: _('scheduler.task')
                    ,anchor: '100%'
                    ,allowBlank: false
                }]
            },{
                layout: 'form'
                ,columnWidth: .5
                ,items: [{
                    xtype: 'compositefield'
                    ,fieldLabel: 'In about'
                    ,anchor: '100%'
                    ,items: [{
                        xtype: 'numberfield'
                        ,name: 'timesetup_number'
                        ,allowBlank: false
                        ,allowDecimals: false
                        ,allowNegative: false
                        ,value: ((config.record.timesetup) ? config.record.timesetup.number : 1)
                        ,width: 70
                    },{
                        xtype: 'modx-combo'
                        ,store: [
                            ['minute', _('scheduler.time.m')]
                            ,['hour', _('scheduler.time.h')]
                            ,['day', _('scheduler.time.d')]
                            ,['month', _('scheduler.time.mnt')]
                            ,['year', _('scheduler.time.y')]
                        ]
                        ,name: 'timesetup_interval'
                        ,hiddenName: 'timesetup_interval'
                        ,allowBlank: false
                        ,value: ((config.record.timesetup) ? config.record.timesetup.interval : 'minute')
                        ,flex: 1
                    }]
                }]
            }]
        },{
            xtype: 'scheduler-grid-future-run-localdata'
            ,id: 'scheduler-grid-future-run-localdata-'+this.ident
            ,preventRender: true
            ,record: config.record
            ,ident: this.ident
        }]
	});
	Scheduler.window.CreateUpdateRun.superclass.constructor.call(this,config);
    this.on('render', this.initWindow);
    this.on('beforeSubmit', this.beforeSubmit);
};
Ext.extend(Scheduler.window.CreateUpdateRun, MODx.Window, {
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
Ext.reg('scheduler-window-run-createupdate', Scheduler.window.CreateUpdateRun);

// -----------------------
// Add/update data property windows
Scheduler.window.AddDataPropertyRun = function(config) {
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
	Scheduler.window.AddDataPropertyRun.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.window.AddDataPropertyRun, MODx.Window, {
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
Ext.reg('scheduler-window-runs-adddataproperty', Scheduler.window.AddDataPropertyRun);

Scheduler.window.UpdateDataPropertyRun = function(config) {
	config = config || {};
	Ext.applyIf(config,{
        title: _('scheduler.data.update')
        ,forceLayout: true
    });
	Scheduler.window.UpdateDataPropertyRun.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.window.UpdateDataPropertyRun, Scheduler.window.AddDataPropertyRun, {});
Ext.reg('scheduler-window-runs-updatedataproperty', Scheduler.window.UpdateDataPropertyRun);