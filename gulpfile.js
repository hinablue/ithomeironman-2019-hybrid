/**
 * @author      Hina Chen
 */
'use strict'

const gulp = require('gulp')
const del = require('del')
const $ = require('gulp-load-plugins')()
const postfix = new Date().getTime().toString()

/**
 * Compile Style & Script
 */
function handleCompileError (event) {
  $.util.log($.util.colors.red(event.message), 'error.')
}

/**
 * Copy Files & Folders
 */
const copyStatic = () => {
  return gulp.src('src/static/**/*').pipe(gulp.dest('src/public'))
}

/**
 * Watching Files
 */
const watch = () => {
  gulp
    .watch([
      'src/app/**/*',
      '!src/app/vendor/**/*',
      'src/public/**/*',
      '!src/public/vue/**/*.{js,css}'
    ])
    .on('change', $.livereload.changed)

  // Start LiveReload
  $.livereload.listen()
}

/**
 * Release
 */
const releaseCopyPublic = () => {
  return gulp.src('src/public/**/*').pipe(gulp.dest('dist/public'))
}

const releaseCopyApp = () => {
  return gulp.src(['src/app/**/*']).pipe(gulp.dest('dist/app'))
}

const releaseReplaceConfig = () => {
  return gulp
    .src('dist/app/configs/config.php')
    .pipe(
      $.replace("(int) (array_sum(explode(' ', microtime())) * 1000)", postfix)
    )
    .pipe(gulp.dest('dist/app/configs'))
}

/**
 * Clean Temp Folders
 */
const cleanPublic = () => {
  return del(
    [
      'src/public/vue',
      'src/public/*hot-update.js',
      'src/public/*hot-update.json'
    ]
  )
}

const cleanDist = () => {
  return del('dist')
}

/**
 * Bundled Tasks
 */
gulp.task('prepare', gulp.series(cleanPublic, copyStatic))

gulp.task(
  'release',
  gulp.series(
    cleanDist,
    'prepare',
    gulp.parallel(releaseCopyPublic, releaseCopyApp),
    releaseReplaceConfig
  )
)

gulp.task('default', gulp.series('prepare', watch))
