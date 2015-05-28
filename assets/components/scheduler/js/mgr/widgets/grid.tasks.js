Scheduler.grid.Tasks = function(config) {
    config = config || {};
    this.exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('{description}{data}')
    });

    Ext.applyIf(config,{
		url: Scheduler.config.connectorUrl
		,id: 'scheduler-grid-tasks'
		,baseParams: { action: 'mgr/tasks/getlist' }
        ,emptyText: _('scheduler.error.noresults')
		,fields: [
            { name: 'id', type: 'int' }
            ,{ name: 'class_key', type: 'string' }
            ,{ name: 'content', type: 'string' }
            ,{ name: 'namespace', type: 'string' }
            ,{ name: 'reference', type: 'string' }
            ,{ name: 'description', type: 'string' }
            ,{ name: 'data', type: 'string' }
            ,{ name: 'next_run', type: 'date', dateFormat: 'U' }
            ,{ name: 'runs', type: 'int' }
        ]
        ,stateful: true
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
			header: _('scheduler.class_key')
			,dataIndex: 'class_key'
		    ,sortable: true
			,width: 15
            ,hidden: true
            ,renderer: this.renderClassKey
		},{
			header: _('scheduler.namespace')
			,dataIndex: 'namespace'
		    ,sortable: true
			,width: 15
		},{
			header: _('scheduler.reference')
			,dataIndex: 'reference'
		    ,sortable: true
			,width: 20
		},{
			header: _('scheduler.content')
			,dataIndex: 'content'
		    ,sortable: true
			,width: 20
            ,hidden: true
		},{
			header: _('scheduler.next_run')
			,dataIndex: 'next_run'
		    ,sortable: true
			,width: 15
            ,renderer: this.renderNextRun
		},{
			header: _('scheduler.runs')
			,dataIndex: 'runs'
		    ,sortable: false
			,width: 5
		}]
        ,tbar: [{
            text: _('scheduler.task_create')
            ,handler: {
                xtype: 'scheduler-window-task-createupdate'
                ,blankValues: true
            }
        },'->',{
            xtype: 'scheduler-combo-classkeylist'
            ,id: 'scheduler-filter-task-type'
            ,emptyText: _('scheduler.filter_type...')
            ,allowBlank: true
            ,listeners: {
                'select': { fn: this.searchType ,scope: this }
            }
        },'-',{
            xtype: 'textfield'
            ,id: 'scheduler-search-task-field'
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
        }]
    });
    Scheduler.grid.Tasks.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.Tasks,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchType: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.class_key = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchClear: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = '';
            s.baseParams.class_key = '';
        this.getBottomToolbar().changePage(1);
        this.refresh();

        Ext.getCmp('scheduler-filter-task-type').reset();
        Ext.getCmp('scheduler-search-task-field').reset();
    }

    ,getMenu: function() {
        return [{
            text: _('scheduler.run_create')
            ,handler: this.createRun
        },{
            text: _('scheduler.task_update')
            ,handler: this.updateTask
        },'-',{
            text: _('scheduler.task_remove')
            ,handler: this.removeTask
        }];
    }
    ,updateTask: function(btn, e) {
        var w = MODx.load({
			xtype: 'scheduler-window-task-createupdate'
            ,isUpdate: true
			,record: this.menu.record
			,listeners: {
				'success': { fn: this.refresh, scope: this }
				,'hide': { fn: function() { this.destroy(); }}
			}
		});
		w.setTitle(_('scheduler.task_update'));
		w.setValues(this.menu.record);
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
    ,removeTask: function(btn, e) {
        MODx.msg.confirm({
			title: _('scheduler.task_remove')
			,text: _('scheduler.task_remove_confirm', { reference: this.menu.record.reference })
			,url: this.config.url
			,params: {
				action: 'mgr/tasks/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				'success': { fn:this.refresh, scope:this }
			}
		});
    }

    ,createRun: function() {
        var win = MODx.load({
            xtype: 'scheduler-window-run-create'
            ,blankValues: true
            ,isUpdate: false
        });
        win.setValues({
            task: this.menu.record.id
        });
        win.show();
    }

    /** RENDERS **/
    ,renderClassKey: function(value) {
        return _('scheduler.class.' + value);
    }
    ,renderNextRun: function(value) {
        var v = Ext.util.Format.date(value, 'Y-m-d H:i'),
            now = new Date();
        if (value < now) { v = '<span style="color: red;">'+v+'</span>' }
        return v;
    }
});
Ext.reg('scheduler-grid-upcomingtasks',Scheduler.grid.Tasks);
