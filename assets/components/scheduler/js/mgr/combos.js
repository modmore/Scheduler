Scheduler.combo.ClassKeyList = function (config) {
    config = config || {}
    Ext.applyIf(config, {
        name: 'class_key'
        , hiddenName: 'class_key'
        , displayField: 'value'
        , valueField: 'key'
        , fields: ['key', 'value']
        , forceSelection: true
        , typeAhead: false
        , editable: false
        , allowBlank: false
        , autocomplete: false
        , url: Scheduler.config.connectorUrl
        , baseParams: {
            action: 'mgr/common/classes/getlist'
            , combo: true
        }
    })
    Scheduler.combo.ClassKeyList.superclass.constructor.call(this, config)
}
Ext.extend(Scheduler.combo.ClassKeyList, MODx.combo.ComboBox)
Ext.reg('scheduler-combo-classkeylist', Scheduler.combo.ClassKeyList)

Scheduler.combo.SnippetList = function (config) {
    config = config || {}
    Ext.applyIf(config, {
        name: 'snippet'
        , hiddenName: 'snippet'
        , displayField: 'name'
        , valueField: 'id'
        , fields: ['id', 'name']
        , forceSelection: true
        , typeAhead: true
        , minChars: 1
        , editable: true
        , allowBlank: false
        , autocomplete: true
        , pageSize: 10
        , url: Scheduler.config.connectorUrl
        , baseParams: {
            action: 'mgr/common/snippets/getlist'
            , combo: true
        }
    })
    Scheduler.combo.SnippetList.superclass.constructor.call(this, config)
}
Ext.extend(Scheduler.combo.SnippetList, MODx.combo.ComboBox)
Ext.reg('scheduler-combo-snippets', Scheduler.combo.SnippetList)

Scheduler.combo.TaskList = function (config) {
    config = config || {}
    Ext.applyIf(config, {
        name: 'task'
        , hiddenName: 'task'
        , displayField: 'task_string'
        , valueField: 'id'
        , fields: ['id', 'reference', 'namespace', 'task_string']
        , forceSelection: true
        , typeAhead: true
        , minChars: 1
        , editable: true
        , allowBlank: false
        , autocomplete: true
        , pageSize: 10
        , url: Scheduler.config.connectorUrl
        , baseParams: {
            action: 'mgr/tasks/getlist'
            , combo: true
        }
        , tpl: new Ext.XTemplate(
            '<tpl for="."><div class="x-combo-list-item">{namespace} : {reference}</div></tpl>'
        )
    })
    Scheduler.combo.TaskList.superclass.constructor.call(this, config)
}
Ext.extend(Scheduler.combo.TaskList, MODx.combo.ComboBox)
Ext.reg('scheduler-combo-tasklist', Scheduler.combo.TaskList)

Scheduler.combo.Browser = function (config) {
    config = config || {}

    if (config.length != 0 && config.openTo != undefined) {
        if (!/^\//.test(config.openTo)) {
            config.openTo = '/' + config.openTo
        }
        if (!/$\//.test(config.openTo)) {
            var tmp = config.openTo.split('/')
            delete tmp[tmp.length - 1]
            tmp = tmp.join('/')
            config.openTo = tmp.substr(1)
        }
    }

    Ext.applyIf(config, {
        width: 300,
        triggerAction: 'all'
    })
    Scheduler.combo.Browser.superclass.constructor.call(this, config)
    this.config = config
}
Ext.extend(Scheduler.combo.Browser, Ext.form.TriggerField, {
    browser: null,

    onTriggerClick: function () {
        if (this.disabled) {
            return false
        }
        const browser = MODx.load({
            xtype: 'modx-browser',
            id: Ext.id(),
            multiple: true,
            source: this.config.source || MODx.config['default_media_source'],
            rootVisible: this.config.rootVisible || false,
            allowedFileTypes: this.config.allowedFileTypes || '',
            wctx: this.config.wctx || 'web',
            openTo: this.config.openTo || '',
            rootId: this.config.rootId || '/',
            hideSourceCombo: this.config.hideSourceCombo || false,
            hideFiles: this.config.hideFiles || true,
            listeners: {
                select: {
                    fn: function (data) {
                        this.setValue(data.fullRelativeUrl)
                        this.fireEvent('select', data)
                    }, scope: this
                }
            },
        })
        browser.win.buttons[0].on('disable', function () {
            this.enable()
        })
        browser.win.tree.on('click', function (n) {
            this.setValue(this.getPath(n))
        }, this)
        browser.win.tree.on('dblclick', function (n) {
            this.setValue(this.getPath(n))
            browser.hide()
        }, this)
        browser.show()
    },

    getPath: function (n) {
        if (n.id === '/') {
            return ''
        }

        return n.attributes.path + '/'
    }
})
Ext.reg('scheduler-combo-browser', Scheduler.combo.Browser)