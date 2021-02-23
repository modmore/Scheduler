Scheduler.grid.History = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();
    this.exp = new Ext.grid.RowExpander({
        renderer : function(v, p, record){
            if (!record.data.message && !record.data.errors) {
                return '';
            }

            p.cellAttr = 'rowspan="2"';
            return '<div class="x-grid3-row-expander">&#160;</div>';
        },
        tpl : new Ext.Template('<pre><code style="width: 100%; overflow-x: scroll; white-space: pre-wrap;">{message:htmlEncode}</code></pre> {errors}')
    });

    Ext.applyIf(config,{
        id: 'scheduler-grid-history'
        ,baseParams: { action: 'mgr/runs/history' }
        ,emptyText: _('scheduler.error.noresults')
		,fields: [
             { name: 'task_id', type: 'int' }
            ,{ name: 'task_string', type: 'string' }
            ,{ name: 'task_class_key', type: 'string' }
            ,{ name: 'task_content', type: 'string' }
            ,{ name: 'task_namespace', type: 'string' }
            ,{ name: 'task_reference', type: 'string' }
            ,{ name: 'task_key', type: 'string' }
            ,{ name: 'task_description', type: 'string' }
            ,{ name: 'id', type: 'int' }
            ,{ name: 'status', type: 'int' }
            ,{ name: 'task', type: 'int' }
            ,{ name: 'timing', type: 'date', dateFormat: 'U' }
            ,{ name: 'data', type: 'string' }
            ,{ name: 'executedon', type: 'date', dateFormat: 'U' }
            ,{ name: 'processing_time', type: 'float' }
            ,{ name: 'errors', type: 'string' }
            ,{ name: 'message', type: 'string' }
        ]
        ,plugins: this.exp
		,columns: [this.exp, {
			header: _('id')
			,dataIndex: 'id'
			,sortable: true
			,width: 50
            ,hidden: true
		},{
			header: _('scheduler.task')
			,dataIndex: 'task_string'
			,sortable: false
			,width: 125
		},{
			header: _('scheduler.namespace')
			,dataIndex: 'task_namespace'
		    ,sortable: true
			,width: 100
            ,hidden: true
		},{
			header: _('scheduler.reference')
			,dataIndex: 'task_reference'
		    ,sortable: true
			,width: 100
            ,hidden: true
		},{
			header: _('scheduler.timing')
			,dataIndex: 'timing'
		    ,sortable: true
			,width: 100
            ,renderer: Ext.util.Format.dateRenderer(MODx.config.manager_date_format + ' ' + MODx.config.manager_time_format)
		},{
			header: _('scheduler.executedon')
			,dataIndex: 'executedon'
		    ,sortable: true
			,width: 100
            ,renderer: Ext.util.Format.dateRenderer(MODx.config.manager_date_format + ' ' + MODx.config.manager_time_format)
		},{
			header: _('scheduler.status')
			,dataIndex: 'status'
		    ,sortable: false
			,width: 50
            ,renderer: this.statusRenderer
		},{
			header: _('scheduler.processing_time')
			,dataIndex: 'processing_time'
		    ,sortable: true
			,width: 50
            ,renderer: function (v) {
			    return v.toFixed(2) + 's';
            }
		},{
            header: _('scheduler.task_key')
            ,dataIndex: 'task_key'
            ,sortable: true
            ,width: 50
        },{
			header: _('scheduler.content')
			,dataIndex: 'task_content'
		    ,sortable: true
			,width: 250
            ,hidden: true
		}]
        ,tbar: ['->',{
            xtype: 'scheduler-combo-tasklist'
            ,id: 'scheduler-filter-run-task-'+this.ident
            ,emptyText: _('scheduler.filter_task')
            ,allowBlank: true
            ,listeners: {
                'select': { fn: this.searchTask ,scope: this }
            }
        },'-',{
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
    Scheduler.grid.History.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.History, Scheduler.grid.Tasks, {
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
    ,searchTask: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.task = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchClear: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = '';
            s.baseParams.namespace = '';
            s.baseParams.task = '';
        this.getBottomToolbar().changePage(1);
        this.refresh();

        Ext.getCmp('scheduler-filter-run-namespace-'+this.ident).reset();
        Ext.getCmp('scheduler-search-run-field-'+this.ident).reset();
        Ext.getCmp('scheduler-filter-run-task-'+this.ident).reset();
    }
    ,getMenu: function() {
        return [{
            text: _('scheduler.reschedule')
            ,handler: this.reScheduleRun
            ,scope: this
        }];
    }
    ,reScheduleRun: function(btn,e) {
        var w = MODx.load({
			xtype: 'scheduler-window-run-reschedule'
			,record: this.menu.record
			,listeners: {
				'success': { fn: this.refresh, scope: this }
				,'hide': { fn: function() { this.destroy(); }}
			}
		});
		w.setValues(this.menu.record);
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
    /** RENDERS **/
    ,statusRenderer: function(value) {
        var v = _('scheduler.status_' + value);
        if (value == 2) {
            v = '<span style="color:green;">'+v+'</span>';
        }
        if (value == 3) {
            v = '<span style="color:red;">'+v+'</span>';
        }
        return v;
    }
});
Ext.reg('scheduler-grid-history',Scheduler.grid.History);
