module.exports = function(grunt) {
  grunt.registerTask(
    'javascript',
    'Main project task to generate javascripts',
    [
      'coffee:discovering',
      'coffee:compile',
      'commands:routing_dump',
      'commands:translation_dump',
      'es6:config',
      'babel:es6',
      'browserify',
      'concat:smartadmin_js',
      'concat:lib_js',
      'concat:orchestra_js',
      'concat:media_js',
      'concat:all_js'
    ]
  );
};
