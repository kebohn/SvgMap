module.exports = {
    publicPath:
      process.env.NODE_ENV === "production" ? "/production-sub-path/" : "/",
    lintOnSave: process.env.NODE_ENV !== "production",
    devServer: {
      proxy: {
        "^/api": {
          target: "http://localhost:8080/api",
          changeOrigin: true,
        },
      },
      proxy: {
        "^/uploads": {
          target: "http://localhost:8080/uploads",
          changeOrigin: true,
        },
      },
    },
  };