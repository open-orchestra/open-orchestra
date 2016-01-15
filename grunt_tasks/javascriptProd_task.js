module.exports = function(grunt) {
  grunt.registerTask(
    'javascriptProd',
    ['uglify:all_js']
  );
};
