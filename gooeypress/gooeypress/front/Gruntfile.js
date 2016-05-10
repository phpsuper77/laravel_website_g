var fs = require('fs'),
	path = require('path'),
	_ = require('underscore');

// Generate a list of top-level templates (make-shift menu)
var menuItems =
	_.chain(fs.readdirSync(path.resolve(__dirname, 'builds')))
	.filter(function(f) {
		// Only get html files, excluding index and base
		return ~f.indexOf('.html') && (f !== "index.html" && f !== "base.html");
	})
	.map(function(f) {
		// Format strings
		capitalized = f[0].toUpperCase() + f.slice(1);
		return {
			path: '/dist/builds/' + f,
			title: capitalized.replace(/-/g, ' ').replace('.html', '')
		};
	})
	.reduce(function(out, f) {
		// Turn into markup
		return out + '<li><a class="feature" href="' + f.path + '">' + f.title + '</a></li>\n';
	}, '')
	.value().replace(/\n$/, '');

module.exports = function (grunt) {
	var globalConfig = {
		path: {
			builds: {
				root: 'builds',
				includes: 'builds/includes',
				dist: {
					root: 'dist',
					builds: 'dist/builds'
				}
			},
			// Add additional src dirs for the "developed" templates
			cachebust: [
				'<%= globalConfig.path.builds.includes %>/*.html',
				'<%= globalConfig.path.builds.dist.builds %>/*.html'
			],
			css: {
				root: 'css',
				site: 'css/site',
				src: 'css/src'
			},
			js: {
				root: 'js',
				src: 'js/src',
				site: 'js/site',
				build: 'js/build'
			},
			images: {
				content: 'images/content',
				site: 'images/site'
			}
		}
	};
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		globalConfig: globalConfig,
		
		sass: {
			dev: {
				options: {
					require: './sass/functions/base64-encode.rb',
                    'load-path': './css/src/',
					style: 'expanded'
				},
				files: {
					'<%= globalConfig.path.css.site %>/all.css': '<%= globalConfig.path.css.src %>/all.scss',
					'<%= globalConfig.path.css.site %>/ltie9.css': '<%= globalConfig.path.css.src %>/ltie9.scss'
				}
			},
			dist: {
				options: {
					require: './sass/functions/base64-encode.rb',
                    'load-path': './css/src/',
					style: 'compressed'
				},
				files: {
					'<%= globalConfig.path.css.site %>/all.css': '<%= globalConfig.path.css.src %>/all.scss',
					'<%= globalConfig.path.css.site %>/ltie9.css': '<%= globalConfig.path.css.src %>/ltie9.scss'
				}
			}
		},
		
		concat: {
			base: {
				src: [
					'<%= globalConfig.path.js.root %>/cssua.min.js',
					'<%= globalConfig.path.js.root %>/modernizr.min.js',
					'<%= globalConfig.path.js.root %>/supports.touch.min.js',
					'<%= globalConfig.path.js.root %>/izilla.gup.min.js',
					'<%= globalConfig.path.js.root %>/layout.engine.min.js',
					'<%= globalConfig.path.js.root %>/mq.genie.min.js'
				],
				dest: '<%= globalConfig.path.js.build %>/base.js'
			},
			all: {
				// Customise as appropriate
				src: [
					'<%= globalConfig.path.js.root %>/matchMedia.min.js',
					'<%= globalConfig.path.js.root %>/matchMedia.addListener.min.js',
					'<%= globalConfig.path.js.root %>/enquire.min.js',
					'<%= globalConfig.path.js.root %>/rwd.images.min.js',
					'<%= globalConfig.path.js.root %>/class.query.min.js',
					'<%= globalConfig.path.js.root %>/swipe.min.js',
					'<%= globalConfig.path.js.root %>/firefox.hwa.min.js',
					'<%= globalConfig.path.js.root %>/fastclick.min.js',
					'<%= globalConfig.path.js.root %>/jquery.transit.min.js',
					'<%= globalConfig.path.js.site %>/all.js'
				],
				dest: '<%= globalConfig.path.js.build %>/all.js'
			}
		},
		
		uglify: {
			base: {
				src: '<%= globalConfig.path.js.build %>/base.js',
				dest: '<%= globalConfig.path.js.build %>/base.js'
			},
			all: {
				src: '<%= globalConfig.path.js.build %>/all.js',
				dest: '<%= globalConfig.path.js.build %>/all.js'
			}
		},
		
		includereplacemore: {
			options: {
				includesDir: '<%= globalConfig.path.builds.includes %>',
				globals: {
					currentYear: grunt.template.today('yyyy'),
					menuItems: menuItems,
					cssRootPath: '/<%= globalConfig.path.css.root %>/',
					cssDistPath: '/<%= globalConfig.path.css.site %>/',
					jsRootPath: '/<%= globalConfig.path.js.root %>/',
					jsDistPath: '/<%= globalConfig.path.js.build %>/',
					imgPath: '/<%= globalConfig.path.images.site %>/',
					imgContentPath: '/<%= globalConfig.path.images.content %>/',
					
					// Customise as appropriate
					siteTitle: 'Gooeypress'
				}
			},
			templates: {
				src: '<%= globalConfig.path.builds.root %>/*.html',
				dest: '<%= globalConfig.path.builds.dist.root %>/'
			}
		},
		
		'regex-replace': {
			version: {
				src: [
					'README.md',
					'<%= globalConfig.path.css.src %>/all.scss'
				],
				actions: [
					{
						search: /v\d+\.\d+\.\d+\ \(\d{4}-\d{2}-\d{2}\)/g,
						replace: 'v<%= pkg.version %> (' + grunt.template.today('yyyy-mm-dd') + ')'
					}
				]
			},
			cachebustcss: {
				src: globalConfig.path.cachebust,
				actions: [
					{
						search: /(.css\?v=)\d+?(")/g,
						replace: '$1' + grunt.template.today('yymmddHHMMss') + '$2'
					}
				]
			},
			cachebustjs: {
				src: globalConfig.path.cachebust,
				actions: [
					{
						search: /(.js\?v=)\d+?(")/g,
						replace: '$1' + grunt.template.today('yymmddHHMMss') + '$2'
					}
				]
			},
			currentpaths: {
				src: '<%= globalConfig.path.builds.dist.builds %>/*.html',
				actions: [
					{
						search: / {(.*?\.html|#)}(.*(?:"|'))((.*?\.html|#))/gi,
						replace: function(str, p1, p2, p3) {
							return p1 == p3 ? ' class="current"' + p2 + p3 : p2 + p3;
						}
					},
					{
						search: /(<li.*?)\s?{.*?}(.*?>)/gi,
						replace: '$1$2'
					}
				]
			},
			cssimages: {
				src: '<%= globalConfig.path.css.site %>/*.css',
				actions: [
					{
						search: /{{ imgPath }}/g,
						replace: '/<%= globalConfig.path.images.site %>/'
					}
				]
			}
		},
		
		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: '<%= globalConfig.path.images.site %>',
					src: ['**/*.{png,jpg,gif}'],
					dest: '<%= globalConfig.path.images.site %>'
				}]
			}
		},
		
		watch: {
			css: {
				files: ['<%= globalConfig.path.css.root %>/**/*.scss'],
				tasks: ['sass:dist', 'regex-replace:cachebustcss', 'regex-replace:cssimages'],
				options: {
					spawn: false,
				}
			},
			scripts: {
				files: ['<%= globalConfig.path.js.root %>/**/*.js'],
				tasks: ['concat', 'uglify', 'regex-replace:cachebustjs'],
				options: {
					spawn: false
				}
			},
			images: {
				files: ['<%= globalConfig.path.images.site %>/*.{png,jpg,gif}'],
				tasks: ['imagemin'],
				options: {
					spawn: false
				}
			},
			html: {
				files: ['<%= globalConfig.path.builds.root %>/**/*.html', '<%= globalConfig.path.builds.dist.builds %>/*.html'],
				tasks: ['includereplacemore', 'regex-replace:currentpaths'],
				options: {
					spawn: false
				}
			}
		},
		
		watchdev: {
			css: {
				files: ['<%= globalConfig.path.css.root %>/**/*.scss'],
				tasks: ['sass:dev', 'regex-replace:cachebustcss', 'regex-replace:cssimages'],
				options: {
					spawn: false,
				}
			},
			scripts: {
				files: ['<%= globalConfig.path.js.root %>/**/*.js'],
				tasks: ['concat', 'regex-replace:cachebustjs'],
				options: {
					spawn: false
				}
			},
			images: {
				files: ['<%= globalConfig.path.images.site %>/*.{png,jpg,gif}'],
				tasks: ['imagemin'],
				options: {
					spawn: false
				}
			},
			html: {
				files: ['<%= globalConfig.path.builds.root %>/**/*.html', '<%= globalConfig.path.builds.dist.builds %>/*.html'],
				tasks: ['includereplacemore', 'regex-replace:currentpaths'],
				options: {
					spawn: false
				}
			}
		}
	
	});
	
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-include-replace-more');
	grunt.loadNpmTasks('grunt-regex-replace');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.renameTask('watch', 'watchdev');
	grunt.loadNpmTasks('grunt-contrib-watch');
	
	grunt.registerTask('default', ['sass:dist', 'concat', 'uglify', 'includereplacemore', 'regex-replace:currentpaths', 'regex-replace:cssimages', 'imagemin', 'watch']);
	grunt.registerTask('dev', ['sass:dev', 'concat', 'includereplacemore', 'regex-replace:currentpaths', 'regex-replace:cssimages', 'imagemin', 'watchdev']);
	grunt.registerTask('bust', ['regex-replace:cachebustcss', 'regex-replace:cachebustjs']);
	grunt.registerTask('version', ['regex-replace:version']);

	grunt.registerTask('deploy', ['sass:dist', 'concat', 'uglify', 'includereplacemore', 'regex-replace:currentpaths', 'regex-replace:cssimages', 'imagemin']);
};
