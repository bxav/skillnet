var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var runSequence = require('run-sequence');
var del = require('del');
var Q = require('q');
var config = {
    assetsDir: 'app/Resources/assets',
    assetsDirFront: 'app/Resources/assets/front',
    assetsDirProApp: 'app/Resources/assets/pro',
    lessPattern: 'less/**/*.less',
    production: !!plugins.util.env.production,
    sourceMaps: !plugins.util.env.production,
    bowerDir: 'vendor/bower_components',
    composerDir: 'vendor',
    revManifestPath: 'app/Resources/assets/rev-manifest.json'
};
var app = {};
app.addStyle = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.plumber())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.less())
        .pipe(plugins.concat('css/'+outputFilename))
        .pipe(plugins.if(config.production, plugins.minifyCss()))
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
};
app.addScript = function(paths, outputFilename, wrap) {
    return gulp.src(paths)
        .pipe(plugins.plumber())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.if(wrap, plugins.wrap('(function(){\n"use strict";\n<%= contents %>\n})();')))
        .pipe(plugins.concat('js/'+outputFilename))
        .pipe(plugins.if(wrap && config.production, plugins.ngmin({dynamic: true})))
        .pipe(plugins.if(config.production, plugins.uglify()))
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
};
app.copy = function(srcFiles, outputDir) {
    return gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};
var Pipeline = function() {
    this.entries = [];
};
Pipeline.prototype.add = function() {
    return this.entries.push(arguments);
};
Pipeline.prototype.run = function(callable) {
    var deferred = Q.defer();
    var i = 0;
    var entries = this.entries;
    var runNextEntry = function() {
        // see if we're all done looping
        if (typeof entries[i] === 'undefined') {
            deferred.resolve();
            return;
        }
        // pass app as this, though we should avoid using "this"
        // in those functions anyways
        callable.apply(app, entries[i]).on('end', function() {
            i++;
            runNextEntry();
        });
    };
    runNextEntry();
    return deferred.promise;
};
gulp.task('styles', function() {
    var pipeline = new Pipeline();
    return pipeline.run(app.addStyle);
});
gulp.task('styles_front', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/css/bootstrap.css',
        config.bowerDir+'/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'
    ], 'vendors_front.css');
    pipeline.add([
        config.assetsDirFront+'/plugins/magnific-popup/magnific-popup.css',
        config.assetsDirFront+'/plugins/rs-plugin/css/settings.css',
        config.assetsDirFront+'/plugins/owl-carousel/owl.carousel.css',
        config.assetsDirFront+'/plugins/mowl-carousel/owl.transitions.css',
        config.assetsDirFront+'/plugins/hover/hover-min.css'
    ], 'plugins_front.css');
    pipeline.add([
        config.assetsDirFront+'/less/style.less',
        config.assetsDirFront+'/less/skins/pink.less'
    ], 'main_front.css');
    return pipeline.run(app.addStyle);
});
gulp.task('styles_app', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/css/bootstrap.css',
        config.bowerDir+'/fullcalendar/dist/fullcalendar.css'
    ], 'vendors_app_pro.css');
    pipeline.add([
        config.assetsDirProApp+'/less/main.less'
    ], 'main_app_pro.css');
    return pipeline.run(app.addStyle);
});
gulp.task('scripts', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/jquery/dist/jquery.js'
    ], 'jquery.js');
    return pipeline.run(app.addScript);
});
gulp.task('scripts_routing', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.composerDir+'/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js',
        'web/js/fos_js_routes.js'
    ], 'routing.js');
    return pipeline.run(app.addScript);
});
gulp.task('scripts_front', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/js/bootstrap.js',
        config.bowerDir+'/moment/moment.js',
        config.bowerDir+'/moment/locale/fr.js',
        config.bowerDir+'/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
    ], 'vendors_front.js');
    pipeline.add([
        config.assetsDirFront+'/plugins/modernizr.js',
        config.assetsDirFront+'/plugins/rs-plugin/js/jquery.themepunch.tools.min.js',
        config.assetsDirFront+'/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js',
        config.assetsDirFront+'/plugins/isotope/isotope.pkgd.min.js',
        config.assetsDirFront+'/plugins/magnific-popup/jquery.magnific-popup.min.js',
        config.assetsDirFront+'/plugins/waypoints/jquery.waypoints.min.js',
        config.assetsDirFront+'/plugins/jquery.countTo.js',
        config.assetsDirFront+'/plugins/jquery.parallax-1.1.3.js',
        config.assetsDirFront+'/plugins/jquery.validate.js',
        config.assetsDirFront+'/plugins/vide/jquery.vide.js',
        config.assetsDirFront+'/plugins/owl-carousel/owl.carousel.js',
        config.assetsDirFront+'/plugins/jquery.browser.js',
        config.assetsDirFront+'/plugins/SmoothScroll.js'
    ], 'plugins.js');
    pipeline.add([
        config.assetsDirFront+'/js/template.js'
    ], 'template.js');
    pipeline.add([
        config.assetsDirFront+'/js/custom.js'
    ], 'custom.js');
    return pipeline.run(app.addScript);
});
gulp.task('scripts_app', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/js/bootstrap.js',
        config.bowerDir+'/angular/angular.js',
        config.bowerDir+'/ui-router/release/angular-ui-router.js',
        config.bowerDir+'/angular-animate/angular-animate.js',
        config.bowerDir+'/lodash/lodash.js',
        config.bowerDir+'/restangular/dist/restangular.js',
        config.bowerDir+'/angular-ui-calendar/src/calendar.js',
        config.bowerDir+'/angular-bootstrap/ui-bootstrap.js',
        config.bowerDir+'/angular-bootstrap/ui-bootstrap-tpls.js',
        config.bowerDir+'/angular-base64/angular-base64.js'
    ], 'vendors_app_pro.js');
    pipeline.add([
        config.assetsDirProApp+'/js/app.js',
        config.assetsDirProApp+'/js/services/**/*.js',
        config.assetsDirProApp+'/js/directives/**/*.js',
        config.assetsDirProApp+'/js/controllers/**/*.js'
    ], 'angular_app.js', true);
    pipeline.add([
        config.bowerDir+'/moment/moment.js',
        config.bowerDir+'/fullcalendar/dist/fullcalendar.js',
        config.bowerDir+'/fullcalendar/dist/lang/fr.js'
    ], 'fullcalendar.js');
    return pipeline.run(app.addScript);
});
gulp.task('fonts', function() {
    app.copy(
        config.assetsDir+'/fonts/**/*',
        'web/fonts'
    );
    return app.copy(
        config.bowerDir+'/font-awesome/fonts/*',
        'web/fonts'
    );
});
gulp.task('images', function() {
    return app.copy(
        config.assetsDir+'/img/**',
        'web/img'
    );
});
gulp.task('views', function() {
    return app.copy(
        config.assetsDirProApp+'/views/**',
        'web/views'
    );
});
gulp.task('router', plugins.shell.task([
    'php app/console fos:js-routing:dump --target=web/js/fos_js_routes.js'
]));
gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
    del.sync('web/img/*');
    del.sync('web/views/*');
});
gulp.task('watch', function() {
    gulp.watch(config.assetsDirFront+'/'+config.lessPattern, ['styles_front']);
    gulp.watch(config.assetsDirFront+'/js/**/*.js', ['scripts_front']);
    gulp.watch('web/js/fos_js_routes.js', ['scripts_routing']);
    gulp.watch(config.assetsDirProApp+'/'+config.lessPattern, ['styles_app']);
    gulp.watch(config.assetsDirProApp+'/js/**/*.js', ['scripts_app']);
    gulp.watch(config.assetsDirProApp+'/views/**/*', ['views']);
});

gulp.task('build', function() {
    runSequence('clean', 'styles', 'styles_front', 'styles_app', 'router', 'scripts_routing', 'scripts', 'scripts_front', 'scripts_app', ['fonts', 'images', 'views']);
});

gulp.task('default', ['build', 'watch']);
