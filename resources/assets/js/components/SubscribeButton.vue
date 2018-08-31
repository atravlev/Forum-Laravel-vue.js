<template>
    <button :class="classes" @click="subscribe" v-text="buttonText"></button> 
</template>

<script>    
    export default {
        props: ['active'],

        data() {
            return {
                buttonText: 'Subscribe'
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },

        },

        methods: {
            subscribe() {
                let requestType = this.active ? 'delete' : 'post';

                axios[requestType](location.pathname + '/subscriptions');

                this.active = ! this.active;

                this.buttonText = this.active ? 'Unsubscribed' : 'Subscribe';
            }
        }
    }

</script>