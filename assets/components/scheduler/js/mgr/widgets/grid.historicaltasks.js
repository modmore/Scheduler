Scheduler.grid.HistoricalTasks = function(config) {
    config = config || {};
    var exp = new Ext.grid.RowExpander({
        tpl : new Ext.Template('<p>{returned}</p> {errors}')
    });
    Ext.applyIf(config,{
		id: 'scheduler-grid-historicaltasks',
		baseParams: {
            action: 'mgr/tasks/historical/getlist'
        },
        plugins: exp,
		columns: [exp, {
			header: _('scheduler.id'),
			dataIndex: 'id',
			sortable: true,
			width: 5,
            hidden: true
		},{
			header: _('scheduler.class_key'),
			dataIndex: 'class_key',
		    sortable: true,
			width: 25,
            hidden: true
		},{
			header: _('scheduler.content'),
			dataIndex: 'content',
		    sortable: true,
			width: 25,
            hidden: true
		},{
			header: _('scheduler.namespace'),
			dataIndex: 'namespace',
		    sortable: true,
			width: 10
		},{
			header: _('scheduler.reference'),
			dataIndex: 'reference',
		    sortable: true,
			width: 25
		},{
			header: _('scheduler.status'),
			dataIndex: 'status',
		    sortable: false,
			width: 10,
            renderer: this.statusRenderer
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
		}],
        tbar: []
    });
    Scheduler.grid.HistoricalTasks.superclass.constructor.call(this,config);
};
Ext.extend(Scheduler.grid.HistoricalTasks,Scheduler.grid.Tasks,{
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
Ext.reg('scheduler-grid-historicaltasks',Scheduler.grid.HistoricalTasks);
