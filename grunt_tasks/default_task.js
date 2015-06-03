module.exports = function(grunt) {
    grunt.registerTask('default',
        [
            'clean',
            'command:assets_install',
            'symlink',
            'css',
            'javascript',
            'javascriptProd',
            'command:assetic_dump'
         ]
    );
};
