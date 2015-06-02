module.exports = function(grunt) {
    grunt.registerTask('css',
        [
            'less:discovering',
            'less',
            'concat:smartadmincss',
            'concat:libcss',
            'concat:orchestracss',
            'concat:css',
            'cssmin'
        ]
    );
};
