const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
   .js("resources/js/states.js", "public/js") // Add states.js here
   .sass("resources/sass/app.scss", "public/css")
   .copyDirectory("resources/images", "public/images")
   .version();

