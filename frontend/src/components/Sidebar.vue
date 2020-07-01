<template>
    <section>
        <b-sidebar
                type="is-light"
                :fullheight=true
                :open.sync="open"
        >
            <div class="p-1">

                <b-menu>
                    <b-menu-list label="Files">
                        <b-menu-item label="Info"></b-menu-item>
                        <b-menu-item>
                            <template slot="label">
                                Administrator

                            </template>
                            <b-menu-item label="Users"></b-menu-item>
                            <b-menu-item>
                                <template slot="label">
                                    Devices
                                    <b-dropdown aria-role="list" class="is-pulled-right" position="is-bottom-left">

                                        <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                                        <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                                        <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                                    </b-dropdown>
                                </template>
                            </b-menu-item>
                            <b-menu-item label="Payments" disabled></b-menu-item>
                        </b-menu-item>
                        <b-menu-item label="My Account">
                            <b-menu-item label="Account data"></b-menu-item>
                            <b-menu-item label="Addresses"></b-menu-item>
                        </b-menu-item>
                    </b-menu-list>
                    <b-menu-list>
                        <b-menu-item label="Expo" tag="router-link" target="_blank" to="/expo"></b-menu-item>
                    </b-menu-list>
                    <b-menu-list label="Actions">
                        <b-menu-item label="Logout"></b-menu-item>
                    </b-menu-list>
                </b-menu>
            </div>
        </b-sidebar>
        <b-button @click="open = true">Edit Files</b-button>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                open: false,
                fullheight: true,
            };
        }
    };
</script>

<style>
    .p-1 {
        padding: 1em;
    }
</style>