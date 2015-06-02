module.exports = {
    smartadminjs: {
        src: [
            'bower_components/jquery/dist/jquery.js',
            'bower_components/jquery-ui/jquery-ui.js',
            'web/bundles/openorchestrabackoffice/smartadmin/js/app.config.js',
            'bower_components/bootstrap/dist/js/bootstrap.js',
            'bower_components/jcrop/js/jquery.Jcrop.js',
            'bower_components/select2/select2.js',
            'bower_components/jquery-minicolors/jquery.minicolors.js',
            'web/bundles/openorchestrabackoffice/smartadmin/js/notification/SmartNotification.js',
            'web/bundles/openorchestrabackoffice/smartadmin/js/smartwidgets/jarvis.widget.js',
            'web/bundles/openorchestrabackoffice/smartadmin/js/app.js'
        ],
        dest: 'web/built/smartadmin.js'
    },

    libjs: {
        src: [
            'bower_components/underscore/underscore.js',
            'bower_components/backbone/backbone.js',
            'bower_components/backbone.wreqr/lib/backbone.wreqr.js',
            'bower_components/datatables/media/js/jquery.dataTables.js',
            'bower_components/datatables-colvis/js/dataTables.colVis.js',
            'bower_components/jquery-form/jquery.form.js',
            'web/bundles/openorchestrabackoffice/js/latinise.js',
            'web/bundles/openorchestrabackoffice/js/jQuery.DOMNodeAppear.js',
            'web/bundles/openorchestrabackoffice/js/underscoreTemplateLoader.js'
        ],
        dest: 'web/built/lib.js'
    },

    orchestrajs: {
        src: [
            // MAIN
            'web/built/openorchestrabackoffice/js/orchestraLib.js',
            'web/built/openorchestrabackoffice/js/viewConfigurator.js',
            'web/built/openorchestrabackoffice/js/orchestraListeners.js',
            'web/built/openorchestrabackoffice/js/setUpCallAjax.js',
            'web/built/openorchestrabackoffice/js/OrchestraView.js',
            'web/built/openorchestrabackoffice/js/contentTypeFormAddFieldListener.js',
            'web/built/openorchestrabackoffice/js/addPrototype.js',
            'web/built/openorchestrabackoffice/js/modelBackbone.js',
            'web/built/openorchestrabackoffice/js/FullPageFormView.js',
            'web/built/openorchestrabackoffice/js/FullPagePanelView.js',
            'web/built/openorchestrabackoffice/js/ContentTypeChangeTypeListener.js',
            'web/built/openorchestrabackoffice/js/page/nodeConstructor.js',
            'web/built/openorchestrabackoffice/js/treeAjaxDelete.js',
            'web/built/openorchestrabackoffice/js/configurableContentFormListener.js',
            'web/built/openorchestrabackoffice/js/page/blocksPanel.js',
            'web/built/openorchestrabackoffice/js/security.js',
            'web/built/openorchestrabackoffice/js/smartConfirmView.js',
            'web/built/openorchestrabackoffice/js/block/video.js',
            'web/built/openorchestrabackoffice/js/adminFormView.js',
            'web/built/openorchestrabackoffice/js/generateId.js',
            // EXTEND VIEW
            'web/built/openorchestrabackoffice/js/extendView/addArea.js',
            'web/built/openorchestrabackoffice/js/extendView/commonPage.js',
            'web/built/openorchestrabackoffice/js/extendView/generateId.js',
            // WIDGET
            'web/built/openorchestrabackoffice/js/widget/widgetChannel.js',
            'web/built/openorchestrabackoffice/js/widget/duplicateChannel.js',
            'web/built/openorchestrabackoffice/js/widget/DuplicateView.js',
            'web/built/openorchestrabackoffice/js/widget/languageChannel.js',
            'web/built/openorchestrabackoffice/js/widget/LanguageView.js',
            'web/built/openorchestrabackoffice/js/widget/previewLinkChannel.js',
            'web/built/openorchestrabackoffice/js/widget/PreviewLinkView.js',
            'web/built/openorchestrabackoffice/js/widget/statusChannel.js',
            'web/built/openorchestrabackoffice/js/widget/StatusView.js',
            'web/built/openorchestrabackoffice/js/widget/versionChannel.js',
            'web/built/openorchestrabackoffice/js/widget/VersionView.js',
            // DASHBOARD
            'web/built/openorchestrabackoffice/js/dashboard/dashboardView.js',
            // PAGE
            'web/built/openorchestrabackoffice/js/page/makeSortable.js',
            'web/built/openorchestrabackoffice/js/page/areaView.js',
            'web/built/openorchestrabackoffice/js/page/blockView.js',
            'web/built/openorchestrabackoffice/js/page/nodeView.js',
            'web/built/openorchestrabackoffice/js/page/templateView.js',
            'web/built/openorchestrabackoffice/js/page/showNode.js',
            'web/built/openorchestrabackoffice/js/page/showTemplate.js',
            'web/built/openorchestrabackoffice/js/page/orderNode.js',
            'web/built/openorchestrabackoffice/js/page/pageConfigurationButtonView.js',
            'web/built/openorchestrabackoffice/js/page/viewportChannel.js',
            // TABLE
            'web/built/openorchestrabackoffice/js/table/TableviewAction.js',
            'web/built/openorchestrabackoffice/js/table/TableviewCollectionView.js',
            'web/built/openorchestrabackoffice/js/table/tableviewLoader.js',
            // MEDIATHEQUE
            'web/built/openorchestramediaadmin/js/mediatheque/*.js',
            // USER
            'web/built/openorchestrauseradmin/js/user/*.js',
            // INDEXATION
            'web/bundles/openorchestraindexation/js/*.js',

            // BACKBONE ROUTER
            'web/bundles/openorchestrabackoffice/js/backboneRouter.js'
        ],
        dest: 'web/built/orchestra.js'
    },

    js: {
        src: [
            'web/built/smartadmin.js',
            'web/built/lib.js',
            'web/built/orchestra.js'
        ],
        dest: 'web/js/all.js'
    },

    smartadmincss: {
        src: [
            // SMARTADMIN PACKAGE
//            'bower_components/bootstrap/dist/css/bootstrap.css',
            'bower_components/open-sans/css/open-sans.css',
            'bower_components/jquery-minicolors/jquery.minicolors.css',
            'web/bundles/openorchestrabackoffice/smartadmin/css/bootstrap.css',
            'bower_components/font-awesome/css/font-awesome.css',
            'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-production-plugins.css',
            'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-production.css',
            'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-skins.css',
            'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-rtl.css',

            // ORCHESTRA SMARTADMIN PATCHES
            'web/built/openorchestrabackoffice/css/smartadminPatches/flags.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/title.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/modal.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/widget.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/checkbox.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/tab.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/form.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/minicolors.css',
            'web/built/openorchestrabackoffice/css/smartadminPatches/logo.css',

            // TINYMCE PATCHES
            'web/built/openorchestrabackoffice/css/tinyMCEPatches/floatPanel.css'
        ],
        dest: 'web/built/smartadmin.css'
    },

    libcss: {
        src: [
            'bower_components/jquery-ui/themes/base/base.css',
            'bower_components/jquery-ui/themes/base/theme.css',
            'bower_components/datatables/media/css/jquery.dataTables.css'
        ],
        dest: 'web/built/lib.css'
    },

    orchestracss: {
        src: [
            'web/built/openorchestrabackoffice/css/openorchestra.css',
            'web/built/openorchestrabackoffice/css/mediatheque.css',
            'web/built/openorchestrabackoffice/css/template.css',
            'web/built/openorchestrabackoffice/css/blocksPanel.css',
            'web/built/openorchestrabackoffice/css/blocksIcon.css',
            'web/built/openorchestrabackoffice/css/mediaModal.css',
            'web/built/openorchestrabackoffice/css/loginPage.css',
            'web/built/openorchestrabackoffice/css/editTable.css',
            'web/built/openorchestrabackoffice/css/node.css'
        ],
        dest: 'web/built/orchestra.css'
    },

    css: {
        src: [
            'web/built/smartadmin.css',
            'web/built/lib.css',
            'web/built/orchestra.css'
        ],
        dest: 'web/css/all.css'
    }
};
