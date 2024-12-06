const mix = require('laravel-mix');

// Сборка JS
mix.js('resources/js/app.js', 'public/js');

// Сборка SCSS
mix.sass('resources/sass/app.scss', 'public/css');

mix.copyDirectory('resources/images', 'public/images');

mix.options({
    processCssUrls: false // Отключить обработку путей в CSS
});

// Включение версионирования (опционально для продакшена)
if (mix.inProduction()) {
    mix.version();
}
