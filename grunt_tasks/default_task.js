module.exports = function(grunt) {
    grunt.registerTask('default',
        [
            'clean',
            'command:assets_install',
            'symlink',
            'symlink_media',
            'css',
            'javascript',
            'javascriptProd',
            'command:assetic_dump'
         ]
    );
};
