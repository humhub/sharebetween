module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        cssmin: {
            target: {
                files: {
                    'resources/css/sharebetween.min.css': ['resources/css/sharebetween.css']
                }
            }
        },
        sass: {
            options: {
                implementation: require('sass')
            },
            dev: {
                files: {
                    'resources/css/sharebetween.css': 'resources/css/sharebetween.scss'
                }
            }
        },
        watch: {
            scripts: {
                files: ['resources/css/*.scss'],
                tasks: ['build'],
                options: {
                    spawn: false,
                },
            },
        },
    });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('build', ['sass', 'cssmin']);
};
