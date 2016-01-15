module.exports = function(grunt) {
  grunt.registerTask(
    'javascript',
    [
      'coffee:discovering',
      'coffee',
      'concat:smartadmin_js',
      'concat:lib_js',
      'concat:orchestra_js',
      'concat:mediajs',
      'concat:all_js'
    ]
  );
};
