module.exports = function(grunt) {
  grunt.registerTask(
    'css',
    'Main project task to generate stylesheets',
    [
      'less:discovering',
      'less',
      'concat:lib_css',
      'concat:smartadmin_patches_css',
      'concat:orchestra_css',
      'concat:media_css',
      'concat:pre_smartadmin_css',
      'concat:post_smartadmin_css',
      'cssmin'
    ]
  );
};
