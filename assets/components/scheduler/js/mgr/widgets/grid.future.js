Scheduler.grid.Future = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		id: 'scheduler-grid-future'
        ,baseParams: { action: 'mgr/runs/future' }
        ,emptyText: _('scheduler.error.noresults')
        ,fields: [
            { name: 'id', type: 'int' }
            ,{ name: 'status', type: 'string' }
            ,{ name: 'task', type: 'string' }
            ,{ name: 'timing', type: 'date', dateFormat: 'U' }
            ,{ name: 'data', type: 'string' }
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
			,dataIndex: 'data'
		    ,sortable: false
			,width: 25
		}]
        ,tbar: []
    });
    Scheduler.grid.Future.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.Future,Scheduler.grid.History,{
    exp: new Ext.grid.RowExpander({ tpl : new Ext.Template('<p>{task_description}</p> {data}') })

    ,getMenu: function() {
        var m = [];
        return m;
    }
});
Ext.reg('scheduler-grid-future',Scheduler.grid.Future);
