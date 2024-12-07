const mix = require('laravel-mix');

// Сборка JS
mix.js('resources/js/app.js', 'public/js');

// Сборка SCSS
mix.sass('resources/sass/app.scss', 'public/css');

// Копирование изображений
mix.copyDirectory('resources/images', 'public/images');

// Отключение обработки путей в CSS
mix.options({
    processCssUrls: false
});

module.exports = {
    stats: {
        warnings: false
    }
}

// Включение версионирования для продакшн-сборки
if (mix.inProduction()) {
    mix.version();
}
