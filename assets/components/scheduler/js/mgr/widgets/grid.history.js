Scheduler.grid.History = function(config) {
    config = config || {};
    var exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('<p>{message}</p> {errors}')
    });
    Ext.applyIf(config,{
		id: 'scheduler-grid-history',
        url: Scheduler.config.connectorUrl,
        baseParams: {
            action: 'mgr/runs/history'
        },
        emptyText: _('scheduler.error.noresults'),
		fields: [
            {name: 'task_id', type: 'int'},
            {name: 'task_class_key', type: 'string'},
            {name: 'task_content', type: 'string'},
            {name: 'task_namespace', type: 'string'},
            {name: 'task_reference', type: 'string'},
            {name: 'task_description', type: 'string'},
            {name: 'id', type: 'int'},
            {name: 'status', type: 'int'},
            {name: 'task', type: 'int'},
            {name: 'timing', type: 'date', dateFormat: 'U'},
            {name: 'data', type: 'string'},
            {name: 'executedon', type: 'date', dateFormat: 'U'},
            {name: 'errors', type: 'string'},
            {name: 'message', type: 'string'}
        ],
        plugins: exp,
		columns: [exp, {
			header: _('id'),
			dataIndex: 'id',
			sortable: true,
			width: 5,
            hidden: true
		},{
			header: _('scheduler.task'),
			dataIndex: 'task',
			sortable: true,
			width: 5,
            hidden: true
		},{
			header: _('scheduler.namespace'),
			dataIndex: 'task_namespace',
		    sortable: true,
			width: 20
		},{
			header: _('scheduler.reference'),
			dataIndex: 'task_reference',
		    sortable: true,
			width: 20
		},{
			header: _('scheduler.timing'),
			dataIndex: 'timing',
		    sortable: true,
			width: 15,
            renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.executedon'),
			dataIndex: 'executedon',
		    sortable: true,
			width: 15,
            renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.status'),
			dataIndex: 'status',
		    sortable: false,
			width: 10,
            renderer: this.statusRenderer
		},{
			header: _('scheduler.content'),
			dataIndex: 'task_content',
		    sortable: true,
			width: 25,
            hidden: true
		}],
        tbar: []
    });
    Scheduler.grid.History.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.History,Scheduler.grid.Tasks,{
    statusRenderer: function(value) {
        var v = _('scheduler.status_' + value);
        if (value == 2) {
            v = '<span style="color:green;">'+v+'</span>';
        }
        if (value == 3) {
            v = '<span style="color:red;">'+v+'</span>';
        }
        return v;
    },

    getMenu: function() {
        var m = [];
        return m;
    }
});
Ext.reg('scheduler-grid-history',Scheduler.grid.History);
