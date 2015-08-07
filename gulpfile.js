var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var del = require('del');
var Q = require('q');
var config = {
    assetsDir: 'app/Resources/assets',
    assetsDirProApp: 'app/Resources/assets/pro',
    lessPattern: 'less/**/*.less',
    production: !!plugins.util.env.production,
    sourceMaps: !plugins.util.env.production,
    bowerDir: 'vendor/bower_components',
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
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/css/bootstrap.css',
        config.bowerDir+'/fullcalendar/dist/fullcalendar.css',
        config.assetsDir+'/css/icomoon-social.css',
        config.assetsDir+'/css/leaflet.css'
    ], 'vendors.css');
    pipeline.add([
        config.assetsDirProApp+'/less/main.less'
    ], 'main.css');
    return pipeline.run(app.addStyle);
});
gulp.task('scripts', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.bowerDir+'/jquery/dist/jquery.js'
    ], 'jquery.js');
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
    ], 'vendors.js');
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
    pipeline.add([
        config.assetsDir+'/js/main.js'
    ], 'site.js');
    return pipeline.run(app.addScript);
});
gulp.task('fonts', function() {
    app.copy(
        config.assetsDir+'/fonts/*',
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
gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
    del.sync('web/img/*');
    del.sync('web/views/*');
});
gulp.task('watch', function() {
    gulp.watch(config.assetsDirProApp+'/'+config.lessPattern, ['styles']);
    gulp.watch(config.assetsDirProApp+'/js/**/*.js', ['scripts']);
    gulp.watch(config.assetsDirProApp+'/views/**/*', ['views']);
});
gulp.task('default', ['clean', 'styles', 'scripts', 'fonts', 'images', 'views', 'watch']);