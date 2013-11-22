Scheduler.grid.UpcomingTasks = function(config) {
    config = config || {};
    config.exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('{summary}{errors}')
    });
    Ext.applyIf(config,{
		url: Scheduler.config.connectorUrl,
		id: 'scheduler-grid-upcomingtasks',
		baseParams: {
            action: 'mgr/tasks/upcoming/getlist'
        },
        emptyText: _('scheduler.error.noresults'),
		fields: [
            {name: 'id', type: 'int'},
            {name: 'reference', type: 'string'},
            {name: 'status', type: 'int'},
            {name: 'status_text', type: 'string'},
            {name: 'type', type: 'string'},
            {name: 'executeon', type: 'date', dateFormat: 'U'},
            {name: 'tte', type: 'string'},
            {name: 'content', type: 'string'},
            //{name: 'data', type: 'object'},
            {name: 'namespace', type: 'string'},
            {name: 'task', type: 'string'},
            {name: 'summary', type: 'string'},
            {name: 'completedon', type: 'date', dateFormat: 'U'},
            {name: 'returned', type: 'string'},
            {name: 'errors', type: 'string'}
        ],
        paging: true,
		remoteSort: true,
        plugins: config.exp,
		columns: [config.exp, {
			header: _('scheduler.id'),
			dataIndex: 'id',
			sortable: true,
			width: 5,
            hidden: true
		},{
			header: _('scheduler.reference'),
			dataIndex: 'reference',
		    sortable: true,
			width: 25
		},{
			header: _('scheduler.status'),
			dataIndex: 'status_text',
		    sortable: false,
			width: 10,
            hidden: true
		},{
			header: _('scheduler.executeon'),
			dataIndex: 'executeon',
		    sortable: true,
			width: 15,
            renderer: this.executeonRenderer
		},{
			header: _('scheduler.content'),
			dataIndex: 'content',
		    sortable: true,
			width: 15,
            hidden: true
		},{
			header: _('scheduler.namespace'),
			dataIndex: 'namespace',
		    sortable: true,
			width: 10
		},{
			header: _('scheduler.task'),
			dataIndex: 'task',
		    sortable: true,
			width: 10
		}],
        tbar: []
    });
    Scheduler.grid.UpcomingTasks.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.UpcomingTasks,MODx.grid.Grid,{
    executeonRenderer: function(value) {
        var v = Ext.util.Format.date(value, 'Y-m-d H:i'),
            now = new Date();

        if (value < now) {
            v = '<span style="color: red;">'+v+'</span>'
        }

        return v;
    },

    getMenu: function() {
        var m = [];
        return m;
    }
});
Ext.reg('scheduler-grid-upcomingtasks',Scheduler.grid.UpcomingTasks);
