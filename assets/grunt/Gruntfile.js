module.exports = function(grunt) {

	/**
	 * add grunt watch: 'crontab -e: @reboot cd /www/apkf/app/assets/grunt/ && grunt watch &'
	 * todolater: https://github.com/cowboy/wesbos/commit/5a2980a7818957cbaeedcd7552af9ce54e05e3fb
	 */

	var jsDir  = '../javascripts/';
	var cssDir = '../stylesheets/';
	var buildsDir = '../../temp/minified/';
	
	// debug or not
	// ------------------------------------------------
	try {
		DEBUG = true;
		require('fs').statSync('./debug');
	
	} catch (err) {
		if (err.code == 'ENOENT') DEBUG = false;
	}


	// Project configuration.
	// ==================================================== 
	grunt.initConfig({

		// all: clean destination folder
		// ------------------------------------------------
		clean: {
			options: { force: true },
			js : buildsDir+'/*.js', 
			css: buildsDir+'/*.css',
		},

		// css: preprocessing, concatenation & minification
		// ------------------------------------------------
		less: { 
			options: {
				compress: !DEBUG,
				paths: [ // @import 
					cssDir+'/vendor/bootstrap', 
					cssDir+'/import'
				]
			},
			'../../temp/minified/main.css': [
				cssDir+'/unflr/bootstrap/bootstrap.less',
				cssDir+'/vendor/plugins/*.*',
				cssDir+'/yeb/*.*',
				cssDir+'/unflr/*.*',
			]
		},


		// js: concatenation & minification
		// ------------------------------------------------
		uglify: {
			options: {
				beautify: DEBUG,
				mangle  : false,
			},
			// core & plugins
			main: {
				dest: buildsDir+'/main.js',
				src: [
					jsDir+'/vendor/independent/*.js', 
					jsDir+'/vendor/jquery/*.js',
					jsDir+'/vendor/bootstrap/*.js', // bootstrap plugins
					// application
					jsDir+'/unflr/*.js',
					jsDir+'/init/routes.js', 
					jsDir+'/init/snippets.js', 
				],
			},
			// locales
			locale_en: { dest: buildsDir+'/locale_en.js', src: jsDir+'locales/en/*.js'},
		},

		// all: watch
		// ------------------------------------------------
		watch: {
			js: {
				expand: true, // recursive
				files: [ jsDir+'/**/*'], // '**' regex: isFolder
				tasks: ['clean:js', 'uglify', 'copy:js', 'hashres:js'],
			},
			css: {
				expand: true,
				files: [ cssDir+'/**/*'], 
				tasks: ['clean:css', 'less', 'copy:css', 'hashres:css'],
				options: {
					livereload: 35740,
				},
			},
		},

		// all: cache busting
		// ------------------------------------------------
		copy: {
			js: {
				src : 'unbustedJs.json',
				dest: buildsDir+'/bustedJs.json',
			},
			css: {
				src : 'unbustedCss.json',
				dest: buildsDir+'/bustedCss.json',
			},
		},

		hashres: {
			js: { 
				src : buildsDir+'/*.js',
				dest: buildsDir+'/bustedJs.json',
			},
			css: { 
				src : buildsDir+'/*.css',
				dest: buildsDir+'/bustedCss.json',
			}
		},

	});
	

	// Load required modules
	// ====================================================
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-hashres');


	// Task definitions
	// ==================================================== 
	grunt.registerTask('default', [
		'clean', 
		'less', 
		'uglify', 
		'copy', 
		'hashres'
	]);

	
};
