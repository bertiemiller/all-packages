<template>
    <div class="outside">
        <div v-if='show'>
            <div class="panel-body">
                <!--<div class="box">-->

                <div class='alert alert-warning' v-if="errors.messages !== null">
                    <strong>Whoops!</strong> Please can you fix the form errors....<br><br>

                    <ul v-for="(messages, rowIndex) in errors.messages">
                        <li v-for="(message, messageIndex) in messages">
                            <span>Row {{ rowIndex }}: </span>{{ message }}
                        </li>
                    </ul>

                </div>

                <!--<div class="box-body">-->
                <div class='alert alert-danger' v-if="errors.message !== null">
                    <strong>Whoops!</strong> Something went wrong....<br><br>

                    <p v-if="errors.message !== null">
                        Message: {{ errors.message }}<br>
                    </p>

                    <p v-if="errors.debug.line !== null">
                        Status: {{ errors.status }}<br>
                        Text: {{ errors.statusText }}<br>
                        Url: {{ errors.url }}<br>
                        Class: {{ errors.debug.class }}<br>
                        File: {{ errors.debug.file }}<br>
                        Line: {{ errors.debug.line }}
                    </p>
                </div>
            </div>

        </div>

        <div class="box box-default collapsed-box" v-if="errors.debug.trace !== null">

            <div class="box-header with-border">
                <h3 class="box-title">Debug Trace</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class='alert'>
                    <ul>
                        <li v-for='debug_message in errors.debug.trace'>
                            {{ debug_message }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import DomainMixin from '../mixins/domain.vue';

    export default{

        data: function () {
            return {
                show: false,
                errors: {
                    status: null,
                    statusText: null,
                    url: null,
                    message: null,
                    messages: null,
                    debug: {
                        class: null,
                        file: null,
                        line: null,
                        trace: null,
                    },
                },
                logoutForm: null,
            }
        },

        mixins: [DomainMixin],

        methods: {

            addHiddenInput (key, value) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                this.logoutForm.appendChild(input);
            },

            logout () {
                var url = this.siteDomain + '/logout';

                this.logoutForm = document.createElement("form");
                this.logoutForm.setAttribute('method', "post");
                this.logoutForm.setAttribute('action', url);
//                    this.addHiddenInput('_token', document.querySelector('meta[name="_csrf_token"]')['content']); // causes mismatch
                this.addHiddenInput('message', 'Your session expired. Please login again.');
                this.addHiddenInput('type', 'info');
                this.addHiddenInput('redirect', '/login');

                console.log(this.logoutForm);

                this.logoutForm.submit();
            },

            hideErrors()
            {
                this.show = false;
            },

            showErrors(response)
            {
                eventHub.$emit('hide-messages')

                this.show = false;

                console.log('Error messages:');
                console.log(response);

                var status = response.status;
                this.errors.status = response.status;
                this.errors.statusText = response.statusText;
                this.errors.url = response.url;

                if (status == 0) {
                    this.errors.message = 'Controller error, check includes and namepsaces.';
                }

                else if (status == 500) {

                    // when token expires it won't generate the header correctly so it is neccessary to
                    // add a statment about Access-Control-Allow-Origin "*" error and logout


                    this.errors.message = response.data.message;
                    this.errors.debug = response.data.debug;
                }

                // Unautorized (Token expired)
                else if (status == 401) {
                    console.log('Logging out:');
                    this.logout();
                    return;
                }

                // input failure
                else if (status == 400) {
                    console.log('Bad request - input failure:');
//                    console.log(('Bad request', response.data)
                    this.errors.messages = response.data.errors.messages;
                }

                else {
                    this.errors.message = 'ERROR CODE NOT RECONGNISED - ' + data.data.message;
                    this.errors.debug = response.data.debug;
                }

                this.show = true;
            },
        },

        created: function () {
            eventHub.$on('hide-errors', this.hideErrors)
            eventHub.$on('error-response', this.showErrors)
        },

        beforeDestroy: function () {
            eventHub.$off('hide-errors', this.hideErrors)
            eventHub.$off('error-response', this.showErrors)
        },

        events: {

//            'hide-errors': function () {
//                this.show = false;
////                this.errors = {};
//            },

//            'error-response': function (data) {
//
//                this.show = false;
//
//                console.log('Error messages:');
//                console.log(data);
//
//                var status = data.status;
//                this.errors.status = data.status;
//                this.errors.statusText = data.statusText;
//                this.errors.url = data.url;
//
//                if (status == 0) {
//                    this.errors.message = 'Controller error, check includes and namepsaces.';
//                }
//
//                else if (status == 500) {
//                    this.errors.message = data.data.message;
//                    this.errors.debug = data.data.debug;
//                }
//
//                // Unautorized (Token expired)
//                else if (status == 401) {
//                    console.log('Logging out:');
//                    this.logout();
//                    return;
//                }
//
//                // input failure
//                else if (status == 400) {
//                    console.log('Bad request - input failure:');
//                    this.errors.messages = data.data.errors.messages;
//                }
//
//                else {
//                    this.errors.message = 'ERROR CODE NOT RECONGNISED - ' + data.data.message;
//                    this.errors.debug = data.data.debug;
//                }
//
//                this.show = true;
//            }
        },

        computed: {

            debugExists() {
                if (this.errors.debug.line !== null) {
                    return true;
                }
                return false;

//                if(typeof this.errors.debug.line === "undefined") {
//                    return false;
//                }
//                return Object.keys(this.errors.debug.line).length  > 0;
            },

            messagesExist() {
                if (this.errors.messages !== null) {
                    return true;
                }
                return false;
//                if(typeof this.errors.messages !== "undefined") {
//                    return true;
//                }
//                if(this.errors.messages.length > 0) {
//                    return true;
//                }
//                return Object.keys(this.errors.messages).length  > 0;
            }
        }
    }
</script>
