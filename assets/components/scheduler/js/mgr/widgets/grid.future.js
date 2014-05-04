Scheduler.grid.Future = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();
    this.exp = new Ext.grid.RowExpander({
        tpl: new Ext.Template('<p>{task_description}</p> {data}')
    });

    Ext.applyIf(config,{
		id: 'scheduler-grid-future'
        ,baseParams: { action: 'mgr/runs/future' }
        ,emptyText: _('scheduler.error.noresults')
        ,fields: [
            { name: 'id', type: 'int' }
            ,{ name: 'status', type: 'string' }
            ,{ name: 'task', type: 'string' }
            ,{ name: 'task_namespace', type: 'string' }
            ,{ name: 'task_reference', type: 'string' }
            ,{ name: 'task_content', type: 'string' }
            ,{ name: 'timing', type: 'date', dateFormat: 'U' }
            ,{ name: 'data', type: 'string' }
            ,{ name: 'data_view', type: 'string' }
            ,{ name: 'executedon', type: 'date', dateFormat: 'U' }
            ,{ name: 'errors', type: 'string' }
            ,{ name: 'message', type: 'string' }
        ]
        ,paging: true
		,remoteSort: true
        ,plugins: this.exp
		,columns: [this.exp, {
			header: _('id')
			,dataIndex: 'id'
			,sortable: true
			,width: 5
            ,hidden: true
		},{
			header: _('scheduler.task')
			,dataIndex: 'task'
			,sortable: true
			,width: 5
            ,hidden: true
		},{
			header: _('scheduler.namespace')
			,dataIndex: 'task_namespace'
		    ,sortable: true
			,width: 15
		},{
			header: _('scheduler.reference')
			,dataIndex: 'task_reference'
		    ,sortable: true
			,width: 15
		},{
			header: _('scheduler.timing')
			,dataIndex: 'timing'
		    ,sortable: true
			,width: 15
            ,renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.content')
			,dataIndex: 'task_content'
		    ,sortable: true
			,width: 25
            ,hidden: true
		},{
			header: _('scheduler.data')
			,dataIndex: 'data_view'
		    ,sortable: false
			,width: 25
		}]
        ,tbar: [{
            text: _('scheduler.run_create')
            ,handler: {
                xtype: 'scheduler-window-run-create'
                ,blankValues: true
                ,isUpdate: false
            }
        },'->',{
            xtype: 'modx-combo-namespace'
            ,id: 'scheduler-filter-run-namespace-'+this.ident
            ,emptyText: _('scheduler.filter_namespace...')
            ,allowBlank: true
            ,listeners: {
                'select': { fn: this.searchNamespace ,scope: this }
            }
        },'-',{
            xtype: 'textfield'
            ,id: 'scheduler-search-run-field-'+this.ident
            ,emptyText: _('scheduler.search...')
            ,listeners: {
                'change': { fn: this.search ,scope: this }
                ,'render': { fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                } ,scope: this }
            }
        },'-',{
            text: _('scheduler.search_clear')
            ,handler: this.searchClear
            ,scope: this
        }]
    });
    Scheduler.grid.Future.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.Future, Scheduler.grid.Tasks, {
    search: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchNamespace: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.namespace = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchClear: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = '';
            s.baseParams.namespace = '';
        this.getBottomToolbar().changePage(1);
        this.refresh();

        Ext.getCmp('scheduler-filter-run-namespace-'+this.ident).reset();
        Ext.getCmp('scheduler-search-run-field-'+this.ident).reset();
    }
    ,getMenu: function() {
        var m = [{
            text: _('scheduler.run_update')
            ,handler: this.updateRun
        },'-',{
            text: _('scheduler.run_remove')
            ,handler: this.removeRun
        }];
        return m;
    }
    ,updateRun: function(btn, e) {
        var w = MODx.load({
			xtype: 'scheduler-window-run-update'
			,record: this.menu.record
            ,isUpdate: true
            ,listeners: {
				'success': { fn: this.refresh, scope: this }
				,'hide': { fn: function() { this.destroy(); }}
			}
		});
		w.setTitle(_('scheduler.run_update'));
		w.setValues(this.menu.record);
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
    ,removeRun: function(btn, e) {
        MODx.msg.confirm({
			title: _('scheduler.run_remove')
			,text: _('scheduler.run_remove_confirm', { reference: this.menu.record.reference })
			,url: this.config.url
			,params: {
				action: 'mgr/runs/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': { fn:this.refresh, scope:this }
			}
		});
    }
});
Ext.reg('scheduler-grid-future',Scheduler.grid.Future);

// -----------------------
// Create/update local data grid
Scheduler.grid.CreateUpdateLocalData = function(config) {
    config = config || {};
	Ext.applyIf(config,{
        fields: ['key','value']
        ,emptyText: _('scheduler.error.noresults')
        ,paging: false
        ,grouping: false
        ,autoExpandColumn: 'key'
        ,autoHeight: true
        ,maxHeight: 100
        ,columns: [{
			header: _('scheduler.data.key')
			,dataIndex: 'key'
			,sortable: true
		},{
			header: _('scheduler.data.value')
			,dataIndex: 'value'
			,sortable: true
		}]
        ,tbar: [{
            text: _('scheduler.data.add')
            ,handler: this.create
            ,scope: this
        }]
    });
    Scheduler.grid.CreateUpdateLocalData.superclass.constructor.call(this,config);
    this.propRecord = Ext.data.Record.create(config.fields);
};
Ext.extend(Scheduler.grid.CreateUpdateLocalData,MODx.grid.LocalProperty,{
    getMenu: function() {
        var m = [{
            text: _('scheduler.data.update')
            ,handler: this.update
            ,scope: this
        },'-',{
            text: _('scheduler.data.remove')
            ,handler: this.remove
            ,scope: this
        }];
        return m;
    }
    ,create: function(btn,e) {
        var w = MODx.load({
			xtype: 'scheduler-window-runs-adddataproperty'
			,record: this.menu.record
            ,blankValues: true
            ,grid: this
            ,listeners: {
                'success': { fn: function(r) {
                    var rec = new this.propRecord({
                        key: r.key
                        ,value: r.value
                    });
                    this.getStore().add(rec);
                } ,scope: this }
            }
		});
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
    ,update: function(btn,e) {
        var w = MODx.load({
			xtype: 'scheduler-window-runs-updatedataproperty'
			,record: this.menu.record
            ,isUpdate: true
            ,grid: this
            ,listeners: {
                'success': { fn: function(r) {
                    var s = this.getStore();
                    var rec = s.getAt(this.menu.recordIndex);
                        rec.set('key',r.key);
                        rec.set('value',r.value);
                    this.getView().refresh();
                } ,scope: this }
            }
		});
		w.setValues(this.menu.record);
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
});
Ext.reg('scheduler-grid-future-run-localdata',Scheduler.grid.CreateUpdateLocalData);