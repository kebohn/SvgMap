<template>
    <div id="page-container">
        <b-navbar class="is-fixed-top" shadow="shadow">
            <template slot="brand">
                <b-navbar-item tag="router-link" :to="{ path: '/' }" class="m-r-xl">
                    <img width="100"
                         :src="publicPath + 'favicon.svg'" alt=""
                    />
                </b-navbar-item>
            </template>
            <template slot="start">
                <b-navbar-item>
                    <router-link to="/">
                        Project List
                    </router-link>
                </b-navbar-item>
                <b-navbar-item>
                    <router-link to="/upload">
                        New Project
                    </router-link>
                </b-navbar-item>
                <b-navbar-item tag=div class="title is-size-3 m-l-xxl" :active="false">
                    {{this.title}}
                </b-navbar-item>
            </template>
        </b-navbar>
        <main ref="main" class="p-t-xxl m-b-xxl p-r-lg p-l-lg">
            <slot></slot>
        </main>
        <footer id="footer">
            <b-navbar class="is-fixed-bottom" shadow="shadow">
                <template slot="start">
                    <b-navbar-item class="m-l-xxl">
                        <router-link to="/impressum">
                            Impressum
                        </router-link>
                    </b-navbar-item>
                    <b-navbar-item>
                        <router-link to="/datenschutz">
                            Datenschutz
                        </router-link>
                    </b-navbar-item>
                </template>
            </b-navbar>
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                publicPath: process.env.BASE_URL,
                title: ''
            }
        },
        created() {
            this.$eventBus.$on('titleUpdated', this.titleUpdated);
        },
        methods: {
            titleUpdated(val) {
              this.title = val;
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
</style>
