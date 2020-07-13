module.exports = {
    outputDir: '../backend/public/static',
    publicPath: process.env.NODE_ENV === "production" ? "" : "/",
    lintOnSave: process.env.NODE_ENV !== "production",
    devServer: {
        proxy: {
            "^/api": {
                target: "http://localhost:8888",
                changeOrigin: true,
            },
            "^/uploads": {
                target: "http://localhost:8888",
                changeOrigin: true,
            }
        }
    }
}