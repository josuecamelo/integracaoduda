const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        customForms: theme => ({
            sm: {
                'input, textarea, multiselect, select': {
                    fontSize: theme('fontSize.sm'),
                    padding: `${theme('spacing.1')} ${theme('spacing.2')}`,
                    border: theme('border.gray.800'),
                    backgroundColor: theme('colors.white')
                },
                select: {
                    paddingRight: `${theme('spacing.4')}`,
                },
                'checkbox, radio': {
                    width: theme('spacing.3'),
                    height: theme('spacing.3'),
                },
            }
        }),
        // rules: [
        //     {
        //         test: /\.css$/,
        //         exclude: /node_modules/,
        //         use: [
        //         {
        //             loader: 'style-loader',
        //         },
        //         {
        //             loader: 'css-loader',
        //             options: {
        //             importLoaders: 1,
        //             }
        //         },
        //         {
        //             loader: 'postcss-loader'
        //         }
        //         ]
        //     }
        // ]
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/custom-forms'),
    ],
};

