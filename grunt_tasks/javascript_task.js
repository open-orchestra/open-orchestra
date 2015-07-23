module.exports = function(grunt) {
    grunt.registerTask('javascript',
        [
            'coffee:discovering',
            'coffee',
            'concat:smartadminjs',
            'concat:libjs',
            'concat:orchestrajs',
            'concat:mediajs',
            'concat:js'
        ]
    );
};
