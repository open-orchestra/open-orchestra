module.exports = {
    browserify : {
        dest : 'web/built/',
        pattern: ['web/built/openorchestra/**/*.js', '!web/built/**/Lib/*.js']
    }
};
