var path = require("path");
var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");

module.exports = {
    context: path.join(__dirname, "resources/assets"),

    entry: {
        common: "./js/common.js",
        home: "./js/home.js",
        login: "./js/login.js",
        user: "./js/user.js",
        post: "./js/post.js",
        postedit: "./js/postedit.js",
        apply: "./js/apply.js",
        reviewteams: "./js/reviewteams.js",
        contest: "./js/contest.js"
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
    ],
    resolve: {
        alias: {
            'jquery-ui': 'jquery-ui-dist/jquery-ui.js'
        }
    },
};
