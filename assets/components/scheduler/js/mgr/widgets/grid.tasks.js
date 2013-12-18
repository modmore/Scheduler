Scheduler.grid.Tasks = function(config) {
    config = config || {};
    config.exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('{description}{data}')
    });
    Ext.applyIf(config,{
		url: Scheduler.config.connectorUrl,
		id: 'scheduler-grid-tasks',
		baseParams: {
            action: 'mgr/tasks/getlist'
        },
        emptyText: _('scheduler.error.noresults'),
		fields: [
            {name: 'id', type: 'int'},
            {name: 'class_key', type: 'string'},
            {name: 'content', type: 'string'},
            {name: 'namespace', type: 'string'},
            {name: 'reference', type: 'string'},
            {name: 'description', type: 'string'},
            {name: 'data', type: 'string'},
            {name: 'next_run', type: 'date', dateFormat: 'U'},
            {name: 'runs', type: 'int'},
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
			header: _('scheduler.class_key'),
			dataIndex: 'reference',
		    sortable: true,
			width: 15,
            hidden: true
		},{
			header: _('scheduler.namespace'),
			dataIndex: 'namespace',
		    sortable: true,
			width: 15
		},{
			header: _('scheduler.reference'),
			dataIndex: 'reference',
		    sortable: true,
			width: 20
		},{
			header: _('scheduler.content'),
			dataIndex: 'content',
		    sortable: true,
			width: 20,
            hidden: true
		},{
			header: _('scheduler.next_run'),
			dataIndex: 'next_run',
		    sortable: true,
			width: 15,
            renderer: this.formatNextRun
		},{
			header: _('scheduler.runs'),
			dataIndex: 'runs',
		    sortable: false,
			width: 5
		}],
        tbar: []
    });
    Scheduler.grid.Tasks.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.Tasks,MODx.grid.Grid,{
    formatNextRun: function(value) {
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
Ext.reg('scheduler-grid-upcomingtasks',Scheduler.grid.Tasks);
