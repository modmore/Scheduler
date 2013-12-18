Scheduler.grid.Future = function(config) {
    config = config || {};
    var exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('<p>{task_description}</p> {data}')
    });
    Ext.applyIf(config,{
		id: 'scheduler-grid-future',
        baseParams: {
            action: 'mgr/runs/future'
        },
        emptyText: _('scheduler.error.noresults'),
        plugins: exp,
		columns: [exp, {
			header: _('scheduler.id'),
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
			width: 15
		},{
			header: _('scheduler.reference'),
			dataIndex: 'task_reference',
		    sortable: true,
			width: 15
		},{
			header: _('scheduler.timing'),
			dataIndex: 'timing',
		    sortable: true,
			width: 15,
            renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.content'),
			dataIndex: 'task_content',
		    sortable: true,
			width: 25,
            hidden: true
		},{
			header: _('scheduler.data'),
			dataIndex: 'data',
		    sortable: false,
			width: 25
		}],
        tbar: []
    });
    Scheduler.grid.Future.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.Future,Scheduler.grid.History,{
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
Ext.reg('scheduler-grid-future',Scheduler.grid.Future);
