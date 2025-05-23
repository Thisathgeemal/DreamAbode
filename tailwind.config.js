/** @type {import('tailwindcss').Config} */

module.exports = {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx,php}"],
  theme: {
    extend: {},
  },
  plugins: [require("tailwind-scrollbar")],
};
