module.exports = function(grunt) {
  grunt.registerTask(
    'css',
    [
      'less:discovering',
      'less',
      'concat:lib_css',
      'concat:smartadmin_patches_css',
      'concat:orchestra_css',
      'concat:mediacss',
      'concat:pre_smartadmin_css',
      'concat:post_smartadmin_css',
      'cssmin'
    ]
  );
};
