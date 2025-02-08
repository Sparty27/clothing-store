/** @type {import('tailwindcss').Config} */

export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./vendor/wire-elements/modal/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
  ],
  safelist: [
    {
      pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
      variants: ['sm', 'md', 'lg', 'xl', '2xl']
    },
    'text-pastelGreen',
    'text-pastelRed',
    'bg-pastelGreen',
    'bg-pastelBlue',
    'bg-pastelRed',
    'bg-pastelOrange',
  ],
  theme: {
    extend: {
      colors: {
        pastelGreen: '#A8D5BA', // Зелений
        pastelRed: '#F4B8B8',   // Червоний
        pastelBlue: '#B7DFF5',  // Синій
        pastelOrange: '#FFD9B3', // Оранжевий
        pastelGreenLight: '#C5E7CF', // Світло-зелений
        pastelRedLight: '#F9D2D2',
        primary: '#5A72A0'
      },
    },
  },
  plugins: [
    require('daisyui'),
  ],
  daisyui: {
    themes: [
      {
        light: {
          ...require("daisyui/src/theming/themes")["light"],
          "primary": "#5A72A0", // Вкажіть колір primary для теми light
        },
      },
    ],
  },
}

