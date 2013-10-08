module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*! <%= pkg.name %>\n <%= grunt.template.today("yyyy-mm-dd") %>\n Author:<%= pkg.author %>\n License: <%= pkg.license %>\n*/\n',
		uglify: {
			'options': {
			},
			'minify-custom-scripts': {
				files: {
					'assets/js/autoloads.min.js': ['assets/js/main.js', 'assets/js/autoload/**/*.js']
				}
			}
		},
		sass: {
			dist: {
				files: {
				'assets/css/[PROJECT_NAME].css': ['assets/scss/[PROJECT_NAME].scss']
				}
			}
		},
		cssmin: {
			combine: {
			files: {
				'assets/css/[PROJECT_NAME].min.css': ['assets/css/[PROJECT_NAME].css']
			}
			}
		},
		watch: {
			css: {
				files: 'assets/scss/**/*.scss',
				tasks: ['sass', 'cssmin']
			},
			js: {
				files: ['assets/js/autoload/**/*.js'],
				tasks : ['uglify']
			},
			options: {
				livereload: false
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['uglify', 'sass', 'cssmin', 'watch']);
};