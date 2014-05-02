Scheduler.combo.ClassKeyList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'class_key'
		,hiddenName: 'class_key'
		,displayField: 'value'
		,valueField: 'key'
		,fields: ['key','value']
		,forceSelection: true
		,typeAhead: false
		,editable: false
		,allowBlank: false
		,autocomplete: false
		,url: Scheduler.config.connectorUrl
		,baseParams: {
            action: 'mgr/common/classes/getList'
			,combo: true
        }
    });
    Scheduler.combo.ClassKeyList.superclass.constructor.call(this, config);
};
Ext.extend(Scheduler.combo.ClassKeyList, MODx.combo.ComboBox);
Ext.reg('scheduler-combo-classkeylist', Scheduler.combo.ClassKeyList);

Scheduler.combo.SnippetList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'snippet'
		,hiddenName: 'snippet'
		,displayField: 'name'
		,valueField: 'id'
		,fields: ['id','name']
		,forceSelection: true
		,typeAhead: true
        ,minChars: 1
		,editable: true
		,allowBlank: false
		,autocomplete: true
        ,pageSize: 10
		,url: Scheduler.config.connectorUrl
		,baseParams: {
            action: 'mgr/common/snippets/getList'
			,combo: true
        }
    });
    Scheduler.combo.SnippetList.superclass.constructor.call(this, config);
};
Ext.extend(Scheduler.combo.SnippetList, MODx.combo.ComboBox);
Ext.reg('scheduler-combo-snippets', Scheduler.combo.SnippetList);

Scheduler.combo.TaskList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'task'
		,hiddenName: 'task'
		,displayField: 'reference'
		,valueField: 'id'
		,fields: ['id','reference','namespace']
		,forceSelection: true
		,typeAhead: true
        ,minChars: 1
		,editable: true
		,allowBlank: false
		,autocomplete: true
        ,pageSize: 10
		,url: Scheduler.config.connectorUrl
		,baseParams: {
            action: 'mgr/tasks/getList'
			,combo: true
        }
        ,tpl: new Ext.XTemplate(
            '<tpl for="."><div class="x-combo-list-item">{namespace} : {reference}</div></tpl>'
        )
    });
    Scheduler.combo.TaskList.superclass.constructor.call(this, config);
};
Ext.extend(Scheduler.combo.TaskList, MODx.combo.ComboBox);
Ext.reg('scheduler-combo-tasklist', Scheduler.combo.TaskList);