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
            open_sans_fonts_bold: {
                src: 'bower_components/open-sans/fonts/bold',
                dest: 'web/fonts/bold'
            },
            open_sans_fonts_bold_italic: {
                src: 'bower_components/open-sans/fonts/bold-italic',
                dest: 'web/fonts/bold-italic'
            },
            open_sans_fonts_extrabold: {
                src: 'bower_components/open-sans/fonts/extrabold',
                dest: 'web/fonts/extrabold'
            },
            open_sans_fonts_extrabold_italic: {
                src: 'bower_components/open-sans/fonts/extrabold-italic',
                dest: 'web/fonts/extrabold-italic'
            },
            open_sans_fonts_italic: {
                src: 'bower_components/open-sans/fonts/italic',
                dest: 'web/fonts/italic'
            },
            open_sans_fonts_light: {
                src: 'bower_components/open-sans/fonts/light',
                dest: 'web/fonts/light'
            },
            open_sans_fonts_light_italic: {
                src: 'bower_components/open-sans/fonts/light-italic',
                dest: 'web/fonts/light-italic'
            },
            open_sans_fonts_regular: {
                src: 'bower_components/open-sans/fonts/regular',
                dest: 'web/fonts/regular'
            },
            open_sans_fonts_semibold: {
                src: 'bower_components/open-sans/fonts/semibold',
                dest: 'web/fonts/semibold'
            },
            open_sans_fontssemibold_italic: {
                src: 'bower_components/open-sans/fonts/semibold-italic',
                dest: 'web/fonts/semibold-italic'
            },
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
                src: 'web/bundles/openorchestrabackoffice/smartadmin/img/mybg.png',
                dest: 'web/img/mybg.png'
            },
            smartadmin_flags: {
                src: 'web/bundles/openorchestrabackoffice/smartadmin/img/flags/flags.png',
                dest: 'web/img/flags/flags.png'
            },
            jquery_minicolors: {
                src: 'bower_components/jquery-minicolors/jquery.minicolors.png',
                dest: 'web/css/images/jquery.minicolors.png'
            },
            select2_gif: {
                src: 'web/bundles/openorchestrabackoffice/smartadmin/img/select2-spinner.gif',
                dest: 'web/img/select2-spinner.gif'
            },

            // ORCHESTRA ASSET
            no_image: {
                src: 'web/bundles/openorchestrabackoffice/images/no_image_available.jpg',
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
                    'web/bundles/openorchestrabackoffice/smartadmin/js/app.config.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'bower_components/jcrop/js/jquery.Jcrop.js',
                    'bower_components/select2/select2.js',
                    'bower_components/jquery-minicolors/jquery.minicolors.js',
                    'web/bundles/openorchestrabackoffice/smartadmin/js/notification/SmartNotification.js',
                    'web/bundles/openorchestrabackoffice/smartadmin/js/smartwidgets/jarvis.widget.js',
                    'web/bundles/openorchestrabackoffice/smartadmin/js/app.js'
                ],
                dest: 'web/built/smartadmin.js'
            },
            
            libjs: {
                src: [
                    'bower_components/underscore/underscore.js',
                    'bower_components/backbone/backbone.js',
                    'bower_components/backbone.wreqr/lib/backbone.wreqr.js',
                    'bower_components/angular/angular.js',
                    'bower_components/datatables/media/js/jquery.dataTables.js',
                    'bower_components/jquery-form/jquery.form.js',
                    'web/bundles/openorchestrabackoffice/js/latinise.js',
                    'web/bundles/openorchestrabackoffice/js/jQuery.DOMNodeAppear.js',
                    'web/bundles/openorchestrabackoffice/js/underscoreTemplateLoader.js'
                ],
                dest: 'web/built/lib.js'
            },
            
            orchestrajs: {
                src: [
                    'web/built/openorchestrabackoffice/js/orchestraLib.js',
                    'web/built/openorchestrabackoffice/js/orchestraListeners.js',
                    // MISC
                    'web/built/openorchestrabackoffice/js/wreqr/widget.js',
                    'web/built/openorchestrabackoffice/js/wreqr/viewport.js',
                    'web/built/openorchestrabackoffice/js/wreqr/widget/*.js',
                    'web/built/openorchestrabackoffice/js/OrchestraView.js',
                    'web/built/openorchestrabackoffice/js/dashboard/dashboardView.js',
                    'web/built/openorchestrabackoffice/js/addPrototype.js',
                    'web/built/openorchestrabackoffice/js/modelBackbone.js',
                    'web/built/openorchestrabackoffice/js/adminFormView.js',
                    'web/built/openorchestrabackoffice/js/generateId.js',
                    'web/built/openorchestrabackoffice/js/page/makeSortable.js',
                    'web/built/openorchestrabackoffice/js/page/areaView.js',
                    'web/built/openorchestrabackoffice/js/page/blockView.js',
                    'web/built/openorchestrabackoffice/js/page/nodeView.js',
                    'web/built/openorchestrabackoffice/js/page/templateView.js',
                    'web/built/openorchestrabackoffice/js/page/showNode.js',
                    'web/built/openorchestrabackoffice/js/page/showTemplate.js',
                    'web/built/openorchestrabackoffice/js/page/orderNode.js',
                    'web/built/openorchestrabackoffice/js/VersionView.js',
                    'web/built/openorchestrabackoffice/js/LanguageView.js',
                    'web/built/openorchestrabackoffice/js/WidgetStatusView.js',
                    'web/built/openorchestrabackoffice/js/page/previewLinkView.js',
                    'web/built/openorchestrabackoffice/js/page/pageConfigurationButtonView.js',
                    'web/built/openorchestrabackoffice/js/table/TableviewView.js',
                    'web/built/openorchestrabackoffice/js/table/TableviewCollectionView.js',
                    'web/built/openorchestrabackoffice/js/FullPageFormView.js',
                    'web/built/openorchestrabackoffice/js/ContentTypeChangeTypeListener.js',
                    'web/built/openorchestrabackoffice/js/table/tableviewLoader.js',
                    'web/built/openorchestrabackoffice/js/page/nodeConstructor.js',
                    'web/built/openorchestrabackoffice/js/treeAjaxDelete.js',
                    'web/built/openorchestrabackoffice/js/configurableContentFormListener.js',
                    'web/built/openorchestrabackoffice/js/page/blocksPanel.js',
                    'web/built/openorchestrabackoffice/js/security.js',
                    'web/built/openorchestrabackoffice/js/smartConfirmView.js',
                    'web/built/openorchestrabackoffice/js/block/video.js',

                    // MEDIATHEQUE
                    'web/built/openorchestrabackoffice/js/mediatheque/*.js',

                    // INDEXATION
                    'web/bundles/openorchestraindexation/js/*.js',

                    // BACKBONE ROUTER
                    'web/bundles/openorchestrabackoffice/js/backboneRouter.js'
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
                    'bower_components/open-sans/css/open-sans.css',
                    'bower_components/jquery-minicolors/jquery.minicolors.css',
                    'web/bundles/openorchestrabackoffice/smartadmin/css/bootstrap.css',
                    'bower_components/font-awesome/css/font-awesome.css',
                    'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-production-plugins.css',
                    'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-production.css',
                    'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-skins.css',
                    'web/bundles/openorchestrabackoffice/smartadmin/css/smartadmin-rtl.css',

                    // ORCHESTRA SMARTADMIN PATCHES
                    'web/built/openorchestrabackoffice/css/smartadminPatches/flags.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/title.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/modal.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/widget.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/checkbox.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/tab.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/form.css',
                    'web/built/openorchestrabackoffice/css/smartadminPatches/minicolors.css',

                    // TINYMCE PATCHES
                    'web/built/openorchestrabackoffice/css/tinyMCEPatches/floatPanel.css'

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
                      'web/built/openorchestrabackoffice/css/openorchestra.css',
                      'web/built/openorchestrabackoffice/css/mediatheque.css',
                      'web/built/openorchestrabackoffice/css/template.css',
                      'web/built/openorchestrabackoffice/css/blocksPanel.css',
                      'web/built/openorchestrabackoffice/css/blocksIcon.css',
                      'web/built/openorchestrabackoffice/css/mediaModal.css',
                      'web/built/openorchestrabackoffice/css/loginPage.css',
                      'web/built/openorchestrabackoffice/css/editTable.css',
                      'web/built/openorchestrabackoffice/css/node.css'
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
            ['*/coffee/*.coffee', '*/coffee/*/*.coffee', '*/coffee/*/*/*.coffee'],
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
