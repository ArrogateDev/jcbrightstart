// @ts-expect-error - daisyui does not ship TypeScript declarations in this project setup
import daisyui from 'daisyui'
import plugin from 'tailwindcss/plugin'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.ts',
        './resources/css/**/*.scss',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['MYuenHK', 'serif'],
                rounded: ['ArialRoundedMT', 'serif'],
            },
            fontSize: {
                base: ['1rem', {lineHeight: '1.6'}]
            },
            colors: {
                primary: '#f29993',
                secondary: '#e6ddd2',
                accent: '#f7d197',
                surface: '#fdf8f3',
                'base-100': '#fffaf5',
                'base-200': '#efe3d9',
                'base-content': '#5a4a3f',
            },
            screens: {
                sm: '640px',
                md: '768px',
                lg: '1024px',
                xl: '1360px',
                '2xl': '1536px',
            },
        },
    },
    plugins: [
        daisyui,
        plugin(function ({addUtilities}) {
            addUtilities({
                '.writing-mode-v-rl': {
                    'writing-mode': 'vertical-rl',
                },
                '.writing-mode-s-rl': {
                    'writing-mode': 'sideways-rl',
                },
            })
        }),
    ],
}
