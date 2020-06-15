module.exports = {
    publicPath: process.env.NODE_ENV === "production" ? "/production-sub-path/" : "/",
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