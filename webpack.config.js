var path = require("path");
var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");

module.exports = {
    context: path.join(__dirname, "resources/assets"),

    entry: {
        common: "./js/common.js",
        login: "./js/login.js",
        user: "./js/user.js",
        post: "./js/post.js"
    },
    output: {
        path: path.join(__dirname, "public/js"),
        filename: "[name].js"
    },
    plugins: [
        new CommonsChunkPlugin({
            filename: "common.js",
            name: "common"
        })
    ]
};
