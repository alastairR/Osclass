/*
 * grunt-js
 */

module.exports = function (grunt) {
    'use strict';

    var assetsDir = 'oc-includes/assets',
        nodeDir = 'node_modules';

    grunt.initConfig({
        clean: {
            vendors: [assetsDir]
        },
        copy: {
            'jquery': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/jquery/dist/jquery.min.js',
                        nodeDir + '/jquery/README.md',
                        nodeDir + '/jquery/LICENSE.txt'
                    ],
                    dest: assetsDir + '/jquery',
                    flatten: true
                }]
            },
            'jquery-migrate': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/jquery-migrate/dist/jquery-migrate.min.js',
                        nodeDir + '/jquery-migrate/README.md',
                        nodeDir + '/jquery-migrate/LICENSE.txt'
                    ],
                    dest: assetsDir + '/jquery-migrate',
                    flatten: true
                }]
            },
            'jquery-ui': {
                files: [
                    {
                        expand: true,
                        src: [
                            nodeDir + '/jquery-ui-dist/*.min.js',
                            nodeDir + '/jquery-ui-dist/*.min.css',
                            nodeDir + '/jquery-ui-dist/README.md',
                            nodeDir + '/jquery-ui-dist/LICENSE.txt'
                        ],
                        dest: assetsDir + '/jquery-ui',
                        flatten: true
                    },
                    {
                        expand: true, src: nodeDir + '/jquery-ui-dist/images/*',
                        dest: assetsDir + '/jquery-ui/images',
                        flatten: true
                    }]
            },
            'jquery-treeview': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/jquery-treeview/jquery.treeview.js',
                        nodeDir + '/jquery-treeview/README.md'
                    ],
                    dest: assetsDir + '/jquery-treeview',
                    flatten: true
                }]
            },
            'jquery-validation': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/jquery-validation/dist/jquery.validate.min.js',
                        nodeDir + '/jquery-validation/dist/additional-methods.min.js',
                        nodeDir + '/jquery-validation/README.md',
                        nodeDir + '/jquery-validation/LICENSE.md'
                    ],
                    dest: assetsDir + '/jquery-validation',
                    flatten: true
                }]
            },
            'jquery-ui-nested': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/jquery-ui-nested/jquery-ui-nested.js',
                        nodeDir + '/jquery-ui-nested/README.md'
                    ],
                    dest: assetsDir + '/jquery-ui-nested',
                    flatten: true
                }]
            },
            'spectrum-colorpicker': {
                files: [
                    {
                        expand: true,
                        src: [
                            nodeDir + '/spectrum-colorpicker/spectrum.js',
                            nodeDir + '/spectrum-colorpicker/README.md',
                            nodeDir + '/spectrum-colorpicker/LICENSE',
                            nodeDir + '/spectrum-colorpicker/spectrum.css'
                        ],
                        dest: assetsDir + '/spectrum-colorpicker',
                        flatten: true
                    }]
            },
            'bootstrap-icons': {
                files: [
                    {
                        expand: true,
                        src: nodeDir + '/bootstrap-icons/LICENSE.md',
                        dest: assetsDir + '/bootstrap-icons',
                        flatten: true
                    },
                    {
                        expand: true,
                        cwd: nodeDir + '/bootstrap-icons/font',
                        src: '**/*',
                        dest: assetsDir + '/bootstrap-icons',
                        flatten: false
                    }]
            },
            'tinymce': {
                files: [
                    {
                        expand: true,
                        cwd: nodeDir + '/tinymce',
                        src: ['license.txt', 'tinymce.min.js'],
                        dest: assetsDir + '/tinymce',
                        flatten: false
                    },
                    {
                        expand: true,
                        cwd: nodeDir + '/tinymce',
                        src: ['icons/**/**/*.min.*', 'skins/ui/oxide/**/*.min.*', 'skins/content/default/**/*.min.*', 'themes/silver/**/**/*.min.*'],
                        dest: assetsDir + '/tinymce',
                        flatten: false
                    },
                    {
                        expand: true,
                        cwd: nodeDir + '/tinymce/plugins',
                        src: ['advlist/*.min.js', 'anchor/*.min.js', 'autolink/*.min.js', 'charmap/*.min.js', 'code/*.min.js', 'fullscreen/*.min.js',
                            'image/*.min.js', 'imagetools/*.min.js', 'insertdatetime/*.min.js', 'link/*.min.js', 'lists/*.min.js', 'media/*.min.js', 'paste/*.min.js', 'preview/*.min.js',
                            'searchreplace/*.min.js', 'table/*.min.js', 'visualblocks/*.min.js'
                        ],
                        dest: assetsDir + '/tinymce/plugins',
                    }
                ]

            },
            'opensans-regular-font': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/npm-font-open-sans/fonts/Regular/OpenSans-Regular.ttf',
                        nodeDir + '/npm-font-open-sans/LICENSE',
                        nodeDir + '/npm-font-open-sans/README.md',
                    ],
                    dest: assetsDir + '/fonts/open-sans',
                    flatten: true
                }]
            },
            'bootstrap': {
                files: [{
                    expand: true,
                    src: [
                        nodeDir + '/bootstrap/dist/css/bootstrap.min.*',
                        nodeDir + '/bootstrap/dist/js/bootstrap.min.*',
                        nodeDir + '/bootstrap/README.md',
                        nodeDir + '/bootstrap/LICENSE'
                    ],
                    dest: assetsDir + '/bootstrap',
                    flatten: true
                }]
            },
            'osclass-legacy': {
                files: [{
                    expand: true,
                    cwd: nodeDir + '/osclass-legacy-assets/src',
                    src: '**/*',
                    dest: assetsDir + '/osclass-legacy/',
                    flatten: false
                }]
            }
        },
        less: {
            compile: {
                options: {
                    paths: ['oc-admin/themes/modern/less'],
                    compress: true
                },
                files: {
                    'oc-admin/themes/modern/css/main.css': 'oc-admin/themes/modern/less/main.less'
                }
            }
        }
    });

    grunt.registerTask('createAssetsDir', 'Creates the necessary static assets directory', function () {
        // Create the assets dir when it doesn't exists.
        if (!grunt.file.isDir(assetsDir)) {
            grunt.file.mkdir(assetsDir);

            // Output a success message
            grunt.log.oklns(grunt.template.process(
                'Directory "<%= directory %>" was created successfully.',
                {data: {directory: assetsDir}}
            ));
        }
    });

    grunt.registerTask('default', ['clean', 'createAssetsDir', 'copy', 'less']);
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-less');
};