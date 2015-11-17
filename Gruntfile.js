module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        basepatch: 'web',
        imagespath: '<%=basepath%>/images/',
        jspath: '<%=basepath%>/js/',
        csspath: '<%=basepath%>/css/',
        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'web/css',
                    src: ['*.css', '!*.min.css'],
                    dest: 'web/css/',
                    ext: '.min.css'
                }]
            }
        },
        concat: {
            dist: {
                src: ['web/js/main.js'],
                dest: 'web/js/dist/build.js',
            }
        },
        uglify: {
            dist: {
                files: {
                    'web/js/dist/build.min.js': ['web/js/dist/build.js']
                }
            }
        },
        imagemin: {
            options: {
                cache: false
            },

            dist: {
                files: [{
                    expand: true,
                    cwd: 'web/images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'dist/'
                }]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');

    grunt.registerTask('default', ['cssmin', 'concat', 'uglify', 'imagemin']);
};
