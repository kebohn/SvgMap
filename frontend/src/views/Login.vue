<template>
    <section>
        <b-modal :active.sync="isComponentModalActive"
                 has-modal-card
                 trap-focus
                 :destroy-on-hide="false"
                 aria-role="dialog"
                 aria-modal>
            <login-modal v-bind="formProps"></login-modal>
        </b-modal>
    </section>
</template>

<script>
    import LoginModal from "@/components/LoginModal";

    export default {
        components: {LoginModal},
        data() {
            return {
                isComponentModalActive: true,
                formProps: {
                    email: 'kev@kev.com',
                    password: 'testing'
                }
            }
        }
    }
</script>