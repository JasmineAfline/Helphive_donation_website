import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php', // scan all Blade templates
    './resources/js/**/*.js',            // scan JS files for classes
  ],
  theme: {
    extend: {},
  },
  plugins: [
     require('@tailwindcss/forms'),
  ],
};
