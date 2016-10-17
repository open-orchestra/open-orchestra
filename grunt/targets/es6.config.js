module.exports = {
    babel : {
        bundles: [
            'openorchestrabackoffice',
            'openorchestramediaadmin'
        ],
        dest : 'web/built/openorchestra/'
    },
    browserify : {
        dest : 'web/built/',
        pattern: ['web/built/openorchestra/**/*.js', '!web/built/**/Lib/*.js']
    }
};
