<template>
    <div class="outside">
        <div class="messageCont">
            <div class="messageBox" transition="slideUp" v-if="show">
                <div v-bind:class="alertClasses">

                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true"
                    >&times;</button>

                    Message:

                    <!--<p class="alertp">{{ message }}</p>-->
                    {{ message }}

                </div>
            </div>
        </div>
    </div>
</template>

<style>

    .messageCont {
        position: relative;
        /*margin-left:15px;*/
        /*margin-right:15px;*/
        /*border: 1px solid green;*/

    }

    .messageBox {
        height: 100px;
        width: 100%;
        position: absolute;
        /*top: -80px;*/
        /*border: 1px solid red;*/
        z-index: 100;
    }

    /*.slideUp-transition {*/
        /*transition: all 0.5s ease;*/
        /*!*height: 100%;*!*/
        /*!*line-height:100%;*!*/
        /*overflow: hidden;*/
        /*top: 0px;*/
        /*opacity: 1;*/
    /*}*/

    /*.slideUp-enter, .slideUp-leave {*/
        /*!*height: 0;*!*/
        /*!*padding-top: 0;*!*/
        /*!*padding-bottom: 0;*!*/
        /*opacity: 0;*/
        /*!*margin: 0;*!*/
        /*!*line-height:0;*!*/
        /*top: -80px;*/
    /*}*/

    /*.alert.horizTranslate {*/
    /*-webkit-transition: 1s;*/
    /*-moz-transition: 1s;*/
    /*-ms-transition: 1s;*/
    /*-o-transition: 1s;*/
    /*transition: 1s;*/
    /*height: 0;*/
    /*border: 0;*/
    /*opacity: 0;*/
    /*}*/

</style>

<script>

    export default{

//        props: {
//            response: Object,
//        },

        data: function () {
            return {
                message: null,
                type: null,
                important: true,
                show: false,
                alertClasses: {
                    'alert': true,
                    'alert-info': false,
                    'alert-success': false,
                    'alert-warning': false,
                    'alert-danger': false,
                    'alert-important': false,
                },
            }
        },

        methods: {

            showMessages(data) {
                eventHub.$emit('hide-errors')

                console.log('Message recieved:', JSON.parse(data.body));

                var response =  JSON.parse(data.body);


                this.show = false;

                if (response.hasOwnProperty('message')) {
                    this.message = response.message;
                    console.log('Message:');
                    console.log(this.message);
                } else {
                    // throw exception
                }
                console.log('Showing1:')

                if (response.hasOwnProperty('type') && this.alertClasses.hasOwnProperty('alert-' + response.type)) {
                    this.alertClasses['alert-' + response.type] = true;
                } else {
                    this.alertClasses['alert-info'] = true;
                }
                console.log('Showing2:')

                if (response.hasOwnProperty('important')) {
                    this.alertClasses['alert-important'] = true;
                }

                console.log('Showing:')
                this.show = true;

                var that = this;
                setTimeout(function () {
                    that.show = false;
                }, 3000, that);

            },

            hideMessages()
            {
                this.show = false;
            }

        },

        created: function () {
            eventHub.$on('flash-message-response', this.showMessages)
            eventHub.$on('hide-messages', this.hideMessages)
        },

        beforeDestroy: function () {
            eventHub.$off('flash-message-response', this.showMessages)
            eventHub.$off('hide-messages', this.hideMessages)
        },

//        events: {
//            'flash-message-response': function (data) {
//
//                console.log('Message recieved:');
//
//                this.show = true;
//
//                if (data.data.hasOwnProperty('message')) {
//                    this.message = data.data.message;
//                    console.log('Message:');
//                    console.log(this.message);
//                } else {
//                    // throw exception
//                }
//
//                if (data.data.hasOwnProperty('type') && this.alertClasses.hasOwnProperty('alert-' + data.data.type)) {
//                    this.alertClasses['alert-' + data.data.type] = true;
//                } else {
//                    this.alertClasses['alert-info'] = true;
//                }
//
//                if (data.data.hasOwnProperty('important')) {
//                    this.alertClasses['alert-important'] = true;
//                }
//
//                var that = this;
//                setTimeout(function () {
//                    that.show = false;
//                }, 3000, that);
//
//            }
//        }

    }
</script>
