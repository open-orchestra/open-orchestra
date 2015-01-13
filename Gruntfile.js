module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-contrib-symlink');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-coffee');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-commands');

    var filesLess = {},
        filesCoffee = {};

    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        symlink: {
            // BOWER COMPONENT
            fontawesome_font_otf: {
                src: 'bower_components/font-awesome/fonts/FontAwesome.otf',
                dest: 'web/fonts/FontAwesome.otf'
            },
            fontawesome_font_eot: {
                src: 'bower_components/font-awesome/fonts/fontawesome-webfont.eot',
                dest: 'web/fonts/fontawesome-webfont.eot'
            },
            fontawesome_font_svg: {
                src: 'bower_components/font-awesome/fonts/fontawesome-webfont.svg',
                dest: 'web/fonts/fontawesome-webfont.svg'
            },
            fontawesome_font_ttf: {
                src: 'bower_components/font-awesome/fonts/fontawesome-webfont.ttf',
                dest: 'web/fonts/fontawesome-webfont.ttf'
            },
            fontawesome_font_woff: {
                src: 'bower_components/font-awesome/fonts/fontawesome-webfont.woff',
                dest: 'web/fonts/fontawesome-webfont.woff'
            },
            bootstrap_font_eot: {
                src: 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.eot',
                dest: 'web/fonts/glyphicons-halflings-regular.eot'
            },
            bootstrap_font_svg: {
                src: 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.svg',
                dest: 'web/fonts/glyphicons-halflings-regular.svg'
            },
            bootstrap_font_ttf: {
                src: 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.ttf',
                dest: 'web/fonts/glyphicons-halflings-regular.ttf'
            },
            bootstrap_font_woff: {
                src: 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.woff',
                dest: 'web/fonts/glyphicons-halflings-regular.woff'
            },
            datatable_img_sort_asc: {
                src: 'bower_components/datatables/media/images/sort_asc.png',
                dest: 'web/images/sort_asc.png'
            },
            datatable_img_sort_both: {
                src: 'bower_components/datatables/media/images/sort_both.png',
                dest: 'web/images/sort_both.png'
            },
            datatable_img_sort_desc: {
                src: 'bower_components/datatables/media/images/sort_desc.png',
                dest: 'web/images/sort_desc.png'
            },
            pace_js: {
                src: 'bower_components/pace/pace.min.js',
                dest: 'web/js/pace.min.js'
            },
            jcrop_gif: {
                src: 'bower_components/jcrop/css/Jcrop.gif',
                dest: 'web/img/jcrop/Jcrop.gif'
            },
            // SMARTADMIN ASSETS
            smartadmin_bg: {
                src: 'web/bundles/phporchestrabackoffice/smartadmin/img/mybg.png',
                dest: 'web/img/mybg.png'
            },
            smartadmin_flags: {
                src: 'web/bundles/phporchestrabackoffice/smartadmin/img/flags/flags.png',
                dest: 'web/img/flags/flags.png'
            },
            select2_gif: {
                src: 'web/bundles/phporchestrabackoffice/smartadmin/img/select2-spinner.gif',
                dest: 'web/img/select2-spinner.gif'
            },

            // ORCHESTRA ASSET
            no_image: {
                src: 'web/bundles/phporchestrabackoffice/images/no_image_available.jpg',
                dest: 'web/img/no_image_available.jpg'
            }

        },

        clean: {
            built: ["web/built"]
        },

        less: {
            bundles: {
                files: filesLess
            }
        },

        cssmin: {
            minify: {
                expand: true,
                src: ['web/css/all.css'],
                ext: '.min.css'
            }
        },

        coffee: {
            compileBare: {
                options: {
                    bare: true
                },
                files: filesCoffee
            }
        },

        uglify: {
            dist: {
                files: {
                    'web/js/all.min.js': ['web/js/all.js']
                }
            }
        },

        concat: {
            smartadminjs: {
                src: [
                    'bower_components/jquery/dist/jquery.js',
                    'bower_components/jquery-ui/jquery-ui.js',
                    'web/bundles/phporchestrabackoffice/smartadmin/js/app.config.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'bower_components/jcrop/js/jquery.Jcrop.js',
                    'bower_components/select2/select2.js',
                    'web/bundles/phporchestrabackoffice/smartadmin/js/notification/SmartNotification.js',
                    'web/bundles/phporchestrabackoffice/smartadmin/js/smartwidgets/jarvis.widget.js',
                    'web/bundles/phporchestrabackoffice/smartadmin/js/app.js'
                ],
                dest: 'web/built/smartadmin.js'
            },
            
            libjs: {
                src: [
                    'bower_components/underscore/underscore.js',
                    'bower_components/backbone/backbone.js',
                    'bower_components/angular/angular.js',
                    'bower_components/datatables/media/js/jquery.dataTables.js',
                    'bower_components/jquery-form/jquery.form.js',
                    'web/bundles/phporchestrabackoffice/js/latinise.js',
                    'web/bundles/phporchestrabackoffice/js/jQuery.DOMNodeAppear.js',
                    'web/bundles/phporchestrabackoffice/js/underscoreTemplateLoader.js'
                ],
                dest: 'web/built/lib.js'
            },
        
            orchestrajs: {
                src: [
                    'web/built/phporchestrabackoffice/js/orchestraLib.js',
                    'web/built/phporchestrabackoffice/js/orchestraListeners.js',

                    // MISC
                    'web/built/phporchestrabackoffice/js/OrchestraView.js',
                    'web/built/phporchestrabackoffice/js/addPrototype.js',
                    'web/built/phporchestrabackoffice/js/modelBackbone.js',
                    'web/built/phporchestrabackoffice/js/adminFormView.js',
                    'web/built/phporchestrabackoffice/js/generateAlias.js',
                    'web/built/phporchestrabackoffice/js/generateContentTypeId.js',
                    'web/built/phporchestrabackoffice/js/page/makeSortable.js',
                    'web/built/phporchestrabackoffice/js/page/areaView.js',
                    'web/built/phporchestrabackoffice/js/page/blockView.js',
                    'web/built/phporchestrabackoffice/js/page/nodeView.js',
                    'web/built/phporchestrabackoffice/js/page/templateView.js',
                    'web/built/phporchestrabackoffice/js/page/showNode.js',
                    'web/built/phporchestrabackoffice/js/page/showTemplate.js',
                    'web/built/phporchestrabackoffice/js/page/orderNode.js',
                    'web/built/phporchestrabackoffice/js/VersionView.js',
                    'web/built/phporchestrabackoffice/js/LanguageView.js',
                    'web/built/phporchestrabackoffice/js/page/previewLinkView.js',
                    'web/built/phporchestrabackoffice/js/page/pageConfigurationButtonView.js',
                    'web/built/phporchestrabackoffice/js/table/TableviewView.js',
                    'web/built/phporchestrabackoffice/js/table/TableviewCollectionView.js',
                    'web/built/phporchestrabackoffice/js/FullPageFormView.js',
                    'web/built/phporchestrabackoffice/js/ContentTypeChangeTypeListener.js',
                    'web/built/phporchestrabackoffice/js/table/tableviewLoader.js',
                    'web/built/phporchestrabackoffice/js/page/nodeConstructor.js',
                    'web/built/phporchestrabackoffice/js/treeAjaxDelete.js',
                    'web/built/phporchestrabackoffice/js/configurableContentFormListener.js',
                    'web/built/phporchestrabackoffice/js/page/blocksPanel.js',
                    'web/built/phporchestrabackoffice/js/security.js',
                    'web/built/phporchestrabackoffice/js/smartConfirmTitleView.js',
                    'web/built/phporchestrabackoffice/js/smartConfirmButtonView.js',

                    // MEDIATHEQUE
                    'web/built/phporchestrabackoffice/js/mediatheque/*.js',

                    // INDEXATION
                    'web/bundles/phporchestraindexation/js/*.js',

                    // LEXIKTRANSLATION
                    'web/bundles/lexiktranslation/ng-table/ng-table.min.js',
                    'web/built/phporchestratranslation/js/translationView.js',

                    // BACKBONE ROUTER
                    'web/bundles/phporchestrabackoffice/js/backboneRouter.js'
                ],
                dest: 'web/built/orchestra.js'
            },
    
            js: {
                src: [
                    'web/built/smartadmin.js',
                    'web/built/lib.js',
                    'web/built/orchestra.js'
                ],
                dest: 'web/js/all.js'
            },
            
            smartadmincss: {
                src: [
                    // SMARTADMIN PACKAGE
//                    'bower_components/bootstrap/dist/css/bootstrap.css',
                    'web/bundles/phporchestrabackoffice/smartadmin/css/bootstrap.css',
                    'bower_components/font-awesome/css/font-awesome.css',
                    'web/bundles/phporchestrabackoffice/smartadmin/css/smartadmin-production-plugins.css',
                    'web/bundles/phporchestrabackoffice/smartadmin/css/smartadmin-production.css',
                    'web/bundles/phporchestrabackoffice/smartadmin/css/smartadmin-skins.css',
                    'web/bundles/phporchestrabackoffice/smartadmin/css/smartadmin-rtl.css',

                    // ORCHESTRA SMARTADMIN PATCHES
                    'web/built/phporchestrabackoffice/css/smartadminPatches/flags.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/title.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/modal.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/widget.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/checkbox.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/tab.css',
                    'web/built/phporchestrabackoffice/css/smartadminPatches/form.css',

                    // TINYMCE PATCHES
                    'web/built/phporchestrabackoffice/css/tinyMCEPatches/floatPanel.css'

                ],
                dest: 'web/built/smartadmin.css'
            },
            
            libcss: {
                src: [
                      'bower_components/jquery-ui/themes/base/base.css',
                      'bower_components/jquery-ui/themes/base/theme.css',
                      'bower_components/datatables/media/css/jquery.dataTables.css'
                ],
                dest: 'web/built/lib.css'
            },
            
            orchestracss: {
                src: [
                      'web/built/phporchestrabackoffice/css/phporchestra.css',
                      'web/built/phporchestrabackoffice/css/mediatheque.css',
                      'web/built/phporchestrabackoffice/css/template.css',
                      'web/built/phporchestrabackoffice/css/blocksPanel.css',
                      'web/built/phporchestrabackoffice/css/blocksIcon.css',
                      'web/built/phporchestrabackoffice/css/mediaModal.css',
                      'web/bundles/lexiktranslation/ng-table/ng-table.min.css',
                      'web/built/phporchestrabackoffice/css/loginPage.css',
                      'web/built/phporchestrabackoffice/css/editTable.css',
                      'web/built/phporchestrabackoffice/css/node.css'
                ],
                dest: 'web/built/orchestra.css'
            },
            
            css: {
                src: [
                      'web/built/smartadmin.css',
                      'web/built/lib.css',
                      'web/built/orchestra.css'
                ],
                dest: 'web/css/all.css'
            }
        },

        watch: {
            css: {
                files: ['web/bundles/*/less/*.less'],
                tasks: ['css', 'command:assetic_dump']
            },
            javascript: {
                files: ['web/bundles/*/coffee/*.coffee'],
                tasks: ['javascript', 'command:assetic_dump']
            }
        },

        command : {
            assets_install: {
                cmd  : 'php app/console assets:install --symlink'
            },
            assetic_dump: {
                cmd  : 'php app/console assetic:dump'
            }
        }
    });

    // Default task(s).
    grunt.registerTask('default', ['clean', 'command:assets_install', 'symlink', 'css', 'javascript', 'javascriptProd', 'command:assetic_dump']);
    grunt.registerTask('css', ['less:discovering', 'less', 'concat:smartadmincss', 'concat:libcss', 'concat:orchestracss', 'concat:css', 'cssmin']);
    grunt.registerTask('javascript', ['coffee:discovering', 'coffee', 'concat:smartadminjs', 'concat:libjs', 'concat:orchestrajs', 'concat:js']);
    grunt.registerTask('javascriptProd', ['uglify']);
    grunt.registerTask('less:discovering', 'This is a function', function() {
        // LESS Files management
        // Source LESS files are located inside : bundles/[bundle]/less/
        // Destination CSS files are located inside : built/[bundle]/css/
        var mappingFileLess = grunt.file.expandMapping(
            ['*/less/*.less', '*/less/*/*.less'],
            'web/built/', {
                cwd: 'web/bundles/',
                rename: function(dest, matchedSrcPath, options) {
                    return dest + matchedSrcPath.replace(/less/g, 'css');
                }
            });

        grunt.util._.each(mappingFileLess, function(value) {
            // Why value.src is an array ??
            filesLess[value.dest] = value.src[0];
        });
    });
    grunt.registerTask('coffee:discovering', 'This is a function', function() {
        // COFFEE Files management
        // Source COFFEE files are located inside : bundles/[bundle]/coffee/
        // Destination JS files are located inside : built/[bundle]/js/
        var mappingFileCoffee = grunt.file.expandMapping(
            ['*/coffee/*.coffee', '*/coffee/*/*.coffee'],
            'web/built/', {
                cwd: 'web/bundles/',
                rename: function(dest, matchedSrcPath, options) {
                    return dest + matchedSrcPath.replace(/coffee/g, 'js');
                }
            });

        grunt.util._.each(mappingFileCoffee, function(value) {
            // Why value.src is an array ??
            filesCoffee[value.dest] = value.src[0];
        });
    });
};
