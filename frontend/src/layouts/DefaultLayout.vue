<template>
    <div id="page-container">
        <b-navbar class="is-fixed-top" shadow="shadow">
            <template slot="brand">
                <b-navbar-item tag="router-link" :to="{ path: '/' }">
                    <img width="100"
                         :src="publicPath + '2020_RWF_iusmaps.online_Logo.svg'" alt=""
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
            </template>
            <template slot="end">
                <b-navbar-item tag="div" class="has-text-weight-bold is-capitalized is-size-3">
                    {{this.title}}
                </b-navbar-item>
            </template>
        </b-navbar>
        <main ref="main" class="section m-t-xl">
            <slot></slot>
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
        data() {
            return {
                publicPath: process.env.BASE_URL,
                title: ''
            }
        },
        mounted() {
            this.$eventBus.$on('titleUpdated', this.titleUpdated)
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
