
const gulp = require('gulp');
const webpack = require('webpack-stream');
const sass = require('gulp-sass');
const minify = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const bulkSass = require('gulp-sass-bulk-import');
const livereload = require('gulp-livereload');


function swallowError (error) {
    console.error(error.toString());
    this.emit('end');
}


gulp.task('js', function(done) {
    return gulp.src('resources/js/**/*.js')
        .pipe(webpack(require('./webpack.config'))).on('error', swallowError)
        .pipe(gulp.dest('public/js')).on('error', swallowError)
        .pipe(livereload({start: true}));
});

gulp.task('scss', function(done){
    return gulp.src('resources/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(bulkSass()).on('error', swallowError)
        .pipe(sass({includePaths: ['resources/scss']})).on('error', swallowError)
        .pipe(autoprefixer()).on('error', swallowError)
        .pipe(minify()).on('error', swallowError)
        .pipe(sourcemaps.write('maps')).on('error', swallowError)
        .pipe(gulp.dest('public/css')).on('error', swallowError)
        .pipe(livereload());
});

gulp.task('reload', function(done){
    livereload.reload();
    done();
});

gulp.task('watch', function(){
    livereload.listen();
    gulp.watch('resources/scss/**/*.scss', {usePolling: true}, gulp.series('scss'));
    gulp.watch('resources/js/**/*.js', {usePolling: true}, gulp.series('js'));
    gulp.watch(['resources/views/**/*.php'], {usePolling: true}, gulp.series('reload'));
});


