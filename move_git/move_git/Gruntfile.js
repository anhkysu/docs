/**
 * Created by tung.lethanh1294 on 02/03/2018.
 */
module.exports = function (grunt) {
    grunt.initConfig({
        uglify: {
            vendor: {
                src: [
                    'node_modules/jquery/dist/jquery.min.js',
                    'node_modules/bootstrap/dist/js/bootstrap.min.js',
                    'node_modules/socket.io-client/dist/socket.io.min.js'
                ],
                dest: 'public/js/vendor.min.js'
            },
            library: {
                src: [
                    'resources/js/library/http.js',
                    'resources/js/library/link.js',
                    'resources/js/library/notification.js',
                    'resources/js/library/socket.client.js'
                ],
                dest: 'public/js/library.min.js'
            },
            projectManagement:{
                src: [
                    'resources/js/projectmanagement.js',
                ],
                dest: 'public/js/projectmanagement.min.js'
            }

        },
        concat: {
            vendor: {
                src: [
                    'node_modules/jquery/dist/jquery.min.js',
                    'node_modules/bootstrap/dist/js/bootstrap.min.js',
                    'node_modules/socket.io-client/dist/socket.io.min.js'
                ],
                dest: 'public/js/vendor.min.js'
            },
            library: {
                src: [
                    'resources/js/library/http.js',
                    'resources/js/library/link.js',
                    'resources/js/library/notification.js',
                    'resources/js/library/socket.client.js'
                ],
                dest: 'public/js/library.min.js'
            },
            projectManagement:{
                src: [
                    'resources/js/projectmanagement.js',
                ],
                dest: 'public/js/projectmanagement.min.js'
            }
        },
        concat_css: {
            option: {},
            vendor: {
                src: [
                    'node_modules/bootstrap/dist/css/bootstrap.min.css',
                ],
                dest: 'public/css/vendor.css'
            },
            appsite: {
                src: [
                    'resources/css/basic.css',
                    'resources/css/translate.css',
                ],
                dest: 'public/css/appsite.css'
            }
        }
    });

    // load grunt plugins and tasks
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-concat-css');
    grunt.loadNpmTasks('grunt-contrib-concat');

    grunt.registerTask('default', ['uglify']);
};