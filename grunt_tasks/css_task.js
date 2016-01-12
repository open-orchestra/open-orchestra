module.exports = function(grunt) {
    grunt.registerTask('css',
        [
            'less:discovering',
            'less',
            'concat:libcss',
            'concat:smartadminpatchescss',
            'concat:orchestracss',
            'concat:mediacss',
            'concat:presmartadmincss',
            'concat:postsmartadmincss',
            'cssmin'
        ]
    );
};
