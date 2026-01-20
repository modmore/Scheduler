Scheduler.window.CreateUpdateTask = function (config) {
    config = config || {}
    this.ident = config.ident || Ext.id()

    Ext.applyIf(config, {
        title: _('scheduler.task_create')
        , url: Scheduler.config.connectorUrl
        , baseParams: {
            action: ((config.isUpdate) ? 'mgr/tasks/update' : 'mgr/tasks/create')
        }
        , width: 600
        , modal: true
        , defaults: { border: false }
        , fields: [
            {
                xtype: 'hidden'
                , name: 'id'
            },
            {
                layout: 'column'
                , border: false
                , items: [{
                    layout: 'form'
                    , columnWidth: .5
                    , items: [{
                        xtype: 'textfield'
                        , name: 'reference'
                        , fieldLabel: _('scheduler.reference')
                        , anchor: '100%'
                        , allowBlank: false
                    }, {
                        xtype: 'scheduler-combo-classkeylist'
                        , name: 'class_key'
                        , hiddenName: 'class_key'
                        , fieldLabel: _('scheduler.class_key')
                        , anchor: '100%'
                        , allowBlank: false
                        , value: config.record.class_key || 'sFileTask'
                        , listeners: {
                            'select': {
                                fn: function (cb, rec, idx) {
                                    var val = cb.getValue()
                                    this.showHideContents(val)
                                }, scope: this
                            }
                        }
                    }, {
                        xtype: 'modx-combo-namespace'
                        , name: 'namespace'
                        , hiddenName: 'namespace'
                        , fieldLabel: _('scheduler.namespace')
                        , anchor: '100%'
                        , allowBlank: false
                    }]
                }, {
                    layout: 'form'
                    , columnWidth: .5
                    , items: [{
                        xtype: 'textarea'
                        , name: 'description'
                        , fieldLabel: _('scheduler.description')
                        , anchor: '100%'
                        , height: 80
                    }, {
                        xtype: 'numberfield'
                        , name: 'max_retries'
                        , fieldLabel: _('scheduler.max_retries')
                        , description: _('scheduler.max_retries_desc')
                        , anchor: '100%'
                        , allowNegative: false
                        , allowDecimals: false
                        , value: config.record.max_retries || 0
                    }, {
                        xtype: 'numberfield'
                        , name: 'retry_delay'
                        , fieldLabel: _('scheduler.retry_delay')
                        , description: _('scheduler.retry_delay_desc')
                        , anchor: '100%'
                        , allowNegative: false
                        , allowDecimals: false
                        , value: config.record.retry_delay || 60
                    }]
                }]
            },
            {
                layout: 'form'
                , items: [{
                    xtype: 'xcheckbox'
                    , fieldLabel: _('scheduler.recurring')
                    , description: MODx.expandHelp ? '' : _('scheduler.recurring_desc')
                    , name: 'recurring'
                    , id: 'scheduler-task-recurring-' + this.ident
                    , inputValue: 1
                    , listeners: {
                        check: { fn: function(cb, checked) {
                            var intervalField = Ext.getCmp('scheduler-task-interval-' + this.ident);
                            if (intervalField) {
                                intervalField.setVisible(checked);
                                intervalField.allowBlank = !checked;
                            }
                            var intervalDesc = Ext.getCmp('scheduler-task-interval-desc-' + this.ident);
                            if (intervalDesc) {
                                intervalDesc.setVisible(checked);
                            }
                        }, scope: this }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden'
                    , forId: 'scheduler-task-recurring-' + this.ident
                    , html: _('scheduler.recurring_desc')
                    , cls: 'desc-under'
                }, {
                    xtype: 'textfield'
                    , fieldLabel: _('scheduler.interval')
                    , description: MODx.expandHelp ? '' : _('scheduler.interval_desc')
                    , name: 'interval'
                    , id: 'scheduler-task-interval-' + this.ident
                    , anchor: '100%'
                    , hidden: true
                    , emptyText: '+30 minutes'
                    , value: config.record.interval || ''
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden'
                    , id: 'scheduler-task-interval-desc-' + this.ident
                    , forId: 'scheduler-task-interval-' + this.ident
                    , html: _('scheduler.interval_desc')
                    , cls: 'desc-under'
                    , hidden: true
                }]
            },
            {
                id: 'scheduler-file-content-fields-' + this.ident
                , layout: 'form'
                , items: [
                    {
                        xtype: 'scheduler-combo-browser',
                        fieldLabel: _('scheduler.content.file'),
                        name: 'file-content',
                        anchor: '99%',
                        id: 'scheduler-task-file-content' + this.ident,
                        description: MODx.expandHelp ? '' : _('scheduler.content.file_desc'),
                        triggerClass: 'x-form-image-trigger',
                        allowedFileTypes: 'php',
                        value: config.record.content || ''
                    },
                    {
                        xtype: MODx.expandHelp ? 'label' : 'hidden'
                        , forId: 'scheduler-task-file-content'
                        , html: _('scheduler.content.file_desc')
                        , cls: 'desc-under'
                    }
                ]
            },
            {
                id: 'scheduler-snippet-content-fields-' + this.ident
                , layout: 'form'
                , items: [{
                    xtype: 'scheduler-combo-snippets'
                    , name: 'snippet-content'
                    , hiddenName: 'snippet-content'
                    , id: 'scheduler-task-snippet-content' + this.ident
                    , fieldLabel: _('scheduler.content.snippet')
                    , description: MODx.expandHelp ? '' : _('scheduler.content.snippet_desc')
                    , anchor: '100%'
                    , value: config.record.content || ''
                    , allowBlank: true
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden'
                    , forId: 'scheduler-task-snippet-content'
                    , html: _('scheduler.content.snippet_desc')
                    , cls: 'desc-under'
                }]
            },
            {
                id: 'scheduler-processor-content-fields-' + this.ident
                , layout: 'form'
                , items: [{
                    xtype: 'textfield'
                    , name: 'processor-content'
                    , id: 'scheduler-task-processor-content' + this.ident
                    , fieldLabel: _('scheduler.content.processor')
                    , description: MODx.expandHelp ? '' : _('scheduler.content.processor_desc')
                    , anchor: '100%'
                    , value: config.record.content || ''
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden'
                    , forId: 'scheduler-task-processor-content'
                    , html: _('scheduler.content.processor_desc')
                    , cls: 'desc-under'
                }]
            }
        ]
        , listeners: {
            'afterrender': { fn: this.initDisplays, scope: this }
        }
    })
    Scheduler.window.CreateUpdateTask.superclass.constructor.call(this, config)

    this.on('show', function () {
        this.fileCntElm = Ext.getCmp('scheduler-file-content-fields-' + this.ident).getEl()
        this.snipCntElm = Ext.getCmp('scheduler-snippet-content-fields-' + this.ident).getEl()
        this.procCntElm = Ext.getCmp('scheduler-processor-content-fields-' + this.ident).getEl()

        this.fileCntElm.setVisibilityMode(Ext.Element.DISPLAY)
        this.fileCntElm.setVisible(true)
        this.snipCntElm.setVisibilityMode(Ext.Element.DISPLAY)
        this.snipCntElm.setVisible(false)
        this.procCntElm.setVisibilityMode(Ext.Element.DISPLAY)
        this.procCntElm.setVisible(false)

        this.showHideContents((config.record.class_key || 'sFileTask'))

        // Show interval field if recurring is enabled
        var isRecurring = config.record.recurring || false;
        var intervalField = Ext.getCmp('scheduler-task-interval-' + this.ident);
        var intervalDesc = Ext.getCmp('scheduler-task-interval-desc-' + this.ident);
        if (intervalField) {
            intervalField.setVisible(isRecurring);
            intervalField.allowBlank = !isRecurring;
        }
        if (intervalDesc && MODx.expandHelp) {
            intervalDesc.setVisible(isRecurring);
        }
    })
}
Ext.extend(Scheduler.window.CreateUpdateTask, MODx.Window, {
    showHideContents: function (type) {
        switch (type) {
            case 'sFileTask':
                this.fileCntElm.setVisible(true)
                this.fileCntElm.slideIn()

                this.snipCntElm.slideOut()
                this.snipCntElm.setVisible(false)

                this.procCntElm.slideOut()
                this.procCntElm.setVisible(false)
                break
            case 'sSnippetTask':
                this.fileCntElm.slideOut()
                this.fileCntElm.setVisible(false)

                this.snipCntElm.setVisible(true)
                this.snipCntElm.slideIn()

                this.procCntElm.slideOut()
                this.procCntElm.setVisible(false)
                break
            case 'sProcessorTask':
                this.fileCntElm.slideOut()
                this.fileCntElm.setVisible(false)

                this.snipCntElm.slideOut()
                this.snipCntElm.setVisible(false)

                this.procCntElm.setVisible(true)
                this.procCntElm.slideIn()
                break
        }
    }
})
Ext.reg('scheduler-window-task-createupdate', Scheduler.window.CreateUpdateTask)