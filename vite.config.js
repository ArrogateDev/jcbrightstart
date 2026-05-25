import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/css/user.scss',
                'resources/css/course.scss',
                'resources/css/course-unit.scss',
                'resources/css/font-awesome/all.min.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['legacy-js-api', 'color-functions', 'global-builtin', 'if-function', 'import', 'abs-percent', 'slash-div'],
            },
        },
    }
});
