module.exports = {
    application : {
        bundles: [
            'openorchestrabackoffice',
            'openorchestrauseradmin',
            'openorchestragroup',
            'openorchestralog',
            'openorchestraworkflowadmin',
            'openorchestramediaadmin',
            'itkgreference'
        ],
        dest: {
            template : 'web/built/', //web/build/template/template.js
            menu : 'web/built/', //web/build/menu/menu.js
            javascript : 'web/built/openorchestra/'
        }
    }
};
