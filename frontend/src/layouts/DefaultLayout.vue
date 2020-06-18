<template>
  <div id="page-container">
    <b-navbar>
      <template slot="brand">
        <b-navbar-item tag="router-link" :to="{ path: '/' }">
          <img
            src="`${publicPath}2020_RWF_iusmaps.online_Logo.svg`" alt=""
          />
        </b-navbar-item>
      </template>
      <template slot="start">
        <b-navbar-item>
          <router-link to = "/">
            Home
          </router-link>
        </b-navbar-item>
        <b-navbar-item>
          <router-link to = "/upload">
            Upload
          </router-link>
        </b-navbar-item>
        <b-navbar-dropdown label="Info">
          <b-navbar-item href>
            About
          </b-navbar-item>
          <b-navbar-item>
            Contact
          </b-navbar-item>
        </b-navbar-dropdown>
      </template>
    </b-navbar>
    <main class="section">
      <slot />
    </main>
    <footer id="footer">
      <div class="content has-text-centered">
        <p>
          This is the footer
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      publicPath: process.env.BASE_URL
    }
  }
};
</script>

<style scoped>
#page-container {
  position: relative;
  min-height: 100vh;
  height: 100vh;
}

#footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 2.5rem; /* Footer height */
}
</style>
