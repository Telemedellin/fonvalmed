module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    //Compilador de Sass
    sass: {
        css: {
			options: {
			  style: "expanded"
			},
            files: {
                "style.css": "sass/style.scss"
            }
        }
    },
    //Watch
    watch :{
        options: {
            livereload: true,
        },
        html: {
            files: ["*.php", "*.html"],
        },
        sass: {
            files: ["sass/**/*.scss"],
            tasks: ["sass"],
            options: {
              spawn: false,
            },
        },
        css: {
            files: ["../style.css"],
        }
    }
  });

  // Load plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-sass');

  // Default task(s).
  grunt.registerTask('default', ['sass']);
  grunt.registerTask('ver', ['watch']);

};