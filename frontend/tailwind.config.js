module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  corePlugins: {
    container: false
  },
  theme: {
    extend: {
      fontFamily: {
        sans: ["Poppins", "sans-serif"]
      },
      transitionProperty: {
        width: "width",
        height: "height"
      },
      colors: {
        primary: {
          "50": "#fabbbd",
          "100": "#f78e91",
          "200": "#f36165",
          "300": "#f14a4f",
          "400": "#f03439",
          "500": "#ee1d23",
          "600": "#d61a20",
          "700": "#be171c",
          "800": "#a71419",
          "900": "#8f1115"
        },
        secondary: {
          "50": "#a4cea2",
          "100": "#91c48f",
          "200": "#7fba7d",
          "300": "#6db06a",
          "400": "#5aa658",
          "500": "#489c45",
          "600": "#418c3e",
          "700": "#3a7d37",
          "800": "#326d30",
          "900": "#2b5e29"
        }
      }
    }
  },
  variants: {
    extend: {}
  },
  plugins: []
};
