babel --out-file mobal.js --presets babel-preset-react modal.jsx
java -jar yuicompressor.jar mobal.js -o mobal.min.js
