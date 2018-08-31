<template>
    <button :class="classes" @click="subscribe" v-text="buttonText"></button> 
</template>

<script>    
    export default {
        props: ['active'],

        data() {
            return {
                hasSubscription: this.active
            }
        },

        computed: {
            classes() {
                return ['btn', this.hasSubscription ? 'btn-primary' : 'btn-default'];
            },

            buttonText() {
                return this.hasSubscription ? 'Unsubscribed' : 'Subscribe'
            }
        },

        methods: {
            subscribe() {
                let requestType = this.hasSubscription ? 'delete' : 'post';

                axios[requestType](location.pathname + '/subscriptions');

                this.hasSubscription = ! this.hasSubscription;
            }
        }
    }

</script>