var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var del = require('del');
var Q = require('q');
var config = {
    assetsDir: 'app/Resources/assets',
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
app.addScript = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.plumber())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
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
    gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};
var Pipeline = function() {
    this.entries = [];
};
Pipeline.prototype.add = function() {
    this.entries.push(arguments);
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
        config.assetsDir+'/css/icomoon-social.css',
        config.assetsDir+'/css/leaflet.css'
    ], 'vendors.css');
    pipeline.add([
        config.assetsDir+'/css/leaflet.ie.css'
    ], 'leaflet.ie.css');
    pipeline.add([
        config.assetsDir+'/less/main.less'
    ], 'main.css');
    pipeline.run(app.addStyle);
});
gulp.task('scripts', function() {
    var pipeline = new Pipeline();
    pipeline.add([
        config.assetsDir+'/js/modernizr-2.6.2-respond-1.1.0.min.js'
    ], 'modernizr.js');
    pipeline.add([
        config.bowerDir+'/jquery/jquery.js'
    ], 'jquery.js');
    pipeline.add([
        config.bowerDir+'/bootstrap/dist/js/bootstrap.js',
        config.assetsDir+'/js/jquery.fitvids.js',
        config.assetsDir+'/js/jquery.sequence.js',
        config.assetsDir+'/js/jquery.bxslider.js'
    ], 'vendors.js');
    pipeline.add([
        config.assetsDir+'/js/main-menu.js',
        config.assetsDir+'/js/template.js'
    ], 'site.js');
    pipeline.run(app.addScript);
});
gulp.task('fonts', function() {
    app.copy(
        config.bowerDir+'/font-awesome/fonts/*',
        'web/fonts'
    );
});
gulp.task('images', function() {
    app.copy(
        config.assetsDir+'/img/**',
        'web/img'
    );
});
gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
    del.sync('web/img/*');
});
gulp.task('watch', function() {
    gulp.watch(config.assetsDir+'/'+config.lessPattern, ['styles']);
    gulp.watch(config.assetsDir+'/js/**/*.js', ['scripts']);
});
gulp.task('default', ['clean', 'styles', 'scripts', 'fonts', 'images', 'watch']);