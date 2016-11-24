<template>

    <div class="panel-body">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-body">
                            <form class="form-horizontal" id="editForm">
                                <i v-if="show == false" class="fa fa-spinner fa-spin"></i>
                                <div class="form-group" v-for="(input, inputIndex) in inputs" v-if="show">
                                    <label class="col-md-2 control-label">{{ input.name }}</label>
                                    <div class="col-md-10">
                                        <input v-if="inputTypeMatch(input, 'text')"
                                               v-model="inputvalues[input.name]"
                                               :name="input.name"
                                               type="text"
                                               class="form-control" :disabled="input.disable">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-10 col-md-offset-2">
                                        <span @click="updateForm" class="btn btn-primary">Save</span>
                                        <span @click="updateAndReturnForm"
                                              class="btn btn-primary">Save & Return</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import DomainMixin from './mixins/domain.vue';
    //
    //    import InputType from './edit/input.vue';

    export default{

        mixins: [DomainMixin],

        data(){
            return {
                isLoading: true,
                item: {},
                inputs: {},
                inputvalues: {},
                show: false
            }
        },

        created: function () {
            console.log('Ready to go!');
            this.fetchInputs();
//            this.$nextTick(function () {
//                console.log('Ready to go!');
//                this.fetchInputs();
//            });
        },

        beforeDestroy: function () {
        },

//        components: {
//
//            'input-type': InputType,
//        },

        computed: {

            indexUrl() {
//                var full_url = window.location.href;
//                var url = full_url.split("/edit")[0];


                var matchString = '(^[a-zA-Z\/\.0-9-_]+)\/([0-9]+)\/edit';
                var path = window.location.pathname;
                var matches = path.match(matchString);

                console.log('Matches :');
                console.log(matches);
                var url = matches[1];

                return url;

//                return document.querySelector('meta[name="_index_url"]')['content'];
            }

        },

        methods: {

//            inputName(rowIndex, name) {
//                return rowIndex + '.' + name
//            },

            inputTypeMatch(input, type) {

//                if(input.indexOf('type') > -1) {
//                    return false;
//                }

                if (input.type == type) {
                    return true;
                }
                else if (input.options != null) {
                    return true;
                }

                return false;
            },

            fetchInputs() {

                this.show = false;
                var matchString = '^[a-zA-Z\/\.0-9-_]+\/([0-9]+)\/edit';
                var path = window.location.pathname;
                var matches = path.match(matchString);

                console.log('Matches :');
                console.log(matches);
                this.item.id = matches[1];

                var request_options = {
                    params: {
//                        id: this.item.id,
                    }
                }
                var url = this.apiDomain + '/api/data/:id/edit';
                url = url.replace(':id', this.item.id);

                this.$http.get(url, request_options)
                        .then((response) => {

                            this.isLoading = false;

                            console.log('Response Data:');
                            console.log(response.data);

                            this.item = response.data.item;
                            console.log('Item:');
                            console.log(this.item);

                            // success callback
                            this.inputs = response.data.inputs;

                            var that = this
                            this.inputs.forEach(function (input) {
                                that.inputvalues[input.name] = input.value
                            }, that)

                            console.log('Inputs:');
                            console.log(this.inputs);

                            this.show = true;

                        }, (response) => {

                            // error callback
                            console.log('Error Response Data:');
                            console.log(response);
                            eventHub.$emit('error-response', response)

                        });

            },

            updateAndReturnForm() {

                this.updateForm();

                var that = this;
                setTimeout(function () {
                    window.location.href = that.indexUrl;
                }, 3000, that)
            },

            updateForm() {

                var url = this.apiDomain + '/api/data/:id';
                url = url.replace(':id', this.item.id);

//                var formData = new FormData(document.getElementById("editForm"));

//                console.log('formData', formData)
                var formContents = this.inputvalues;

                // this is causing an error
//                for (var pair of formData.entries()) {
//                    formContents[pair[0]] = pair[1];
//                }

                formContents._method = 'PUT';
                console.log('Form Contents:');
                console.log(formContents);

                this.$http.post(url, formContents).then((response) => {

                    // success callback
                    console.log(response);

                    // get status
                    response.status;

                    // get status text
                    response.statusText;

                    // get all headers
                    response.headers;

                    // get 'Expires' header
                    response.headers['Expires'];

                    // if response is good then delete row
                    console.log('Success - updating');

                    eventHub.$emit('flash-message-response', response)

                    // messages
                    // set data on vm
                    //                this.$set('someData', response.json());
                    console.log('Response Body:');
                    console.log(response.body);

                }, (response) => {

                    // error callback
                    console.log('Error');
                    console.log(response);
                    eventHub.$emit('error-response', response)

                });

            }

        }

    }
</script>
