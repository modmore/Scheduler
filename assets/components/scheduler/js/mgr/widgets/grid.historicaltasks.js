Scheduler.grid.HistoricalTasks = function(config) {
    config = config || {};
    config.exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('<p>{returned}</p> {errors}')
    });
    Ext.applyIf(config,{
		id: 'scheduler-grid-historicaltasks',
		baseParams: {
            action: 'mgr/tasks/historical/getlist'
        },
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
			header: _('scheduler.namespace'),
			dataIndex: 'namespace',
		    sortable: true,
			width: 10
		},{
			header: _('scheduler.task'),
			dataIndex: 'task',
		    sortable: true,
			width: 10
		},{
			header: _('scheduler.executeon'),
			dataIndex: 'executeon',
		    sortable: true,
			width: 15,
            renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.completedon'),
			dataIndex: 'completedon',
		    sortable: true,
			width: 15,
            renderer: Ext.util.Format.dateRenderer('Y-m-d H:i')
		},{
			header: _('scheduler.status'),
			dataIndex: 'status',
		    sortable: false,
			width: 10,
            renderer: this.statusRenderer
		}],
        tbar: []
    });
    Scheduler.grid.HistoricalTasks.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.HistoricalTasks,Scheduler.grid.UpcomingTasks,{
    statusRenderer: function(value) {
        var v = _('scheduler.status_' + value);
        if (value < 1) {
            v = '<span style="color:red;">'+v+'</span>';
        }
        return v;
    },

    getMenu: function() {
        var m = [];
        return m;
    }
});
Ext.reg('scheduler-grid-historicaltasks',Scheduler.grid.HistoricalTasks);
