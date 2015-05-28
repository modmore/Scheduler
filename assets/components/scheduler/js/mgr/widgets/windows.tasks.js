Scheduler.window.CreateUpdateTask = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('scheduler.task_create')
		,url: Scheduler.config.connectorUrl
		,baseParams: {
			action: ((config.isUpdate) ? 'mgr/tasks/update' : 'mgr/tasks/create')
		}
        ,width: 600
        ,modal: true
        ,defaults: { border: false }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            layout: 'column'
            ,border: false
            ,items: [{
                layout: 'form'
                ,columnWidth: .5
                ,items: [{
                    xtype: 'textfield'
                    ,name: 'reference'
                    ,fieldLabel: _('scheduler.reference')
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'scheduler-combo-classkeylist'
                    ,name: 'class_key'
                    ,hiddenName: 'class_key'
                    ,fieldLabel: _('scheduler.class_key')
                    ,anchor: '100%'
                    ,allowBlank: false
                    ,value: config.record.class_key || 'sFileTask'
                    ,listeners: {
                        'select': { fn: function(cb,rec,idx) {
                            var val = cb.getValue();
                            this.showHideContents(val);
                        } ,scope: this }
                    }
                },{
                    xtype: 'modx-combo-namespace'
                    ,name: 'namespace'
                    ,hiddenName: 'namespace'
                    ,fieldLabel: _('scheduler.namespace')
                    ,anchor: '100%'
                    ,allowBlank: false
                }]
            },{
                layout: 'form'
                ,columnWidth: .5
                ,items: [{
                    xtype: 'textarea'
                    ,name: 'description'
                    ,fieldLabel: _('scheduler.description')
                    ,anchor: '100%'
                    ,height: 145
                }]
            }]
        },{
            id: 'scheduler-file-content-fields-'+this.ident
            ,layout: 'form'
            ,items: [{
                xtype: 'textarea'
                ,name: 'file-content'
                ,id: 'scheduler-task-file-content'+this.ident
                ,fieldLabel: _('scheduler.content.file')
                ,description: MODx.expandHelp ? '' : _('scheduler.content.file_desc')
                ,anchor: '100%'
                ,value: config.record.content || ''
            },{
                xtype: MODx.expandHelp ? 'label' : 'hidden'
                ,forId: 'scheduler-task-file-content'
                ,html: _('scheduler.content.file_desc')
                ,cls: 'desc-under'
            }]
        },{
            id: 'scheduler-snippet-content-fields-'+this.ident
            ,layout: 'form'
            ,items: [{
                xtype: 'scheduler-combo-snippets'
                ,name: 'snippet-content'
                ,hiddenName: 'snippet-content'
                ,id: 'scheduler-task-snippet-content'+this.ident
                ,fieldLabel: _('scheduler.content.snippet')
                ,description: MODx.expandHelp ? '' : _('scheduler.content.snippet_desc')
                ,anchor: '100%'
                ,value: config.record.content || ''
                ,allowBlank: true
            },{
                xtype: MODx.expandHelp ? 'label' : 'hidden'
                ,forId: 'scheduler-task-snippet-content'
                ,html: _('scheduler.content.snippet_desc')
                ,cls: 'desc-under'
            }]
        },{
            id: 'scheduler-processor-content-fields-'+this.ident
            ,layout: 'form'
            ,items: [{
                xtype: 'textfield'
                ,name: 'processor-content'
                ,id: 'scheduler-task-processor-content'+this.ident
                ,fieldLabel: _('scheduler.content.processor')
                ,description: MODx.expandHelp ? '' : _('scheduler.content.processor_desc')
                ,anchor: '100%'
                ,value: config.record.content || ''
            },{
                xtype: MODx.expandHelp ? 'label' : 'hidden'
                ,forId: 'scheduler-task-processor-content'
                ,html: _('scheduler.content.processor_desc')
                ,cls: 'desc-under'
            }]
        }]
        ,listeners: {
            'afterrender': { fn: this.initDisplays ,scope: this }
        }
	});
	Scheduler.window.CreateUpdateTask.superclass.constructor.call(this,config);

    this.on('show', function() {
        this.fileCntElm = Ext.getCmp('scheduler-file-content-fields-'+this.ident).getEl();
        this.snipCntElm = Ext.getCmp('scheduler-snippet-content-fields-'+this.ident).getEl();
        this.procCntElm = Ext.getCmp('scheduler-processor-content-fields-'+this.ident).getEl();

        this.fileCntElm.setVisibilityMode(Ext.Element.DISPLAY);
        this.fileCntElm.setVisible(true);
        this.snipCntElm.setVisibilityMode(Ext.Element.DISPLAY);
        this.snipCntElm.setVisible(false);
        this.procCntElm.setVisibilityMode(Ext.Element.DISPLAY);
        this.procCntElm.setVisible(false);

        this.showHideContents(( config.record.class_key || 'sFileTask' ));
    });
};
Ext.extend(Scheduler.window.CreateUpdateTask, MODx.Window, {
    showHideContents: function(type) {
        switch(type) {
            case 'sFileTask':
                this.fileCntElm.setVisible(true);
                this.fileCntElm.slideIn();

                this.snipCntElm.slideOut();
                this.snipCntElm.setVisible(false);

                this.procCntElm.slideOut();
                this.procCntElm.setVisible(false);
            break;
            case 'sSnippetTask':
                this.fileCntElm.slideOut();
                this.fileCntElm.setVisible(false);

                this.snipCntElm.setVisible(true);
                this.snipCntElm.slideIn();

                this.procCntElm.slideOut();
                this.procCntElm.setVisible(false);
            break;
            case 'sProcessorTask':
                this.fileCntElm.slideOut();
                this.fileCntElm.setVisible(false);

                this.snipCntElm.slideOut();
                this.snipCntElm.setVisible(false);

                this.procCntElm.setVisible(true);
                this.procCntElm.slideIn();
            break;
        }
    }
});
Ext.reg('scheduler-window-task-createupdate', Scheduler.window.CreateUpdateTask);