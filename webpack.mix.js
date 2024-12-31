const mix = require("laravel-mix");

// Js
mix.js("frontend/js/vanilla/app.js", "public/js");
mix.js("frontend/js/vanilla/user-setting.js", "public/js");
mix.js("frontend/js/vanilla/podcast.js", "public/js");
mix.js("frontend/js/vanilla/notification.js", "public/js");

// Scss
mix.sass("frontend/sass/app.scss", "public/css");

// Plyr
mix.js("frontend/vendor/plyr/js/plyr.js", "public/js/plyr");
mix.js("frontend/vendor/plyr/js/plyr.polyfilled.js", "public/js/plyr");
mix.sass("frontend/vendor/plyr/sass/plyr.scss", "public/css/plyr");

// React
// mix.react("frontend/js/react/comment.jsx", "public/js/react");
// mix.react("frontend/js/react/tutorial.jsx", "public/js/react");
