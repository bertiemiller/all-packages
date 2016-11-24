<template>
    <div class="panel-body" id="createFormContainer">
        <div class="box box-default">
            <form class="form-horizontal" id="createForm" v-on:submit.prevent>
                <div class="box-header with-border">
                    <!--<br>-->

                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                        <div class="col-md-2 pull-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control" id="addRowsNum">
                                        <option v-for="(n, index) in addNumberTotal" :n="n">
                                            {{ n }}
                                        </option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" id="addRow"
                                                @click="addRow">Add Rows</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="clearfix" />-->

                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <i v-if="show == false" class="fa fa-spinner fa-spin"></i>
                                <table class="table table-striped table-bordered table-hover" v-if="show">
                                <tr class="formGroupMultiple" v-for="(inputs, rowIndex) in inputRows">
                                    <td>
                                        <div>
                                            <div class="form-group" v-for="(input, inputIndex) in inputs">
                                                <label class="col-md-2 control-label">
                                                    {{ inputName(input.name, rowIndex) }}
                                                </label>
                                                <div class="col-md-10 form-horizontal">
                                                    <input v-if="inputTypeMatch(input, 'text')"
                                                           v-model="inputvalues[inputName(rowIndex, input.name)]"
                                                           :name="inputName(rowIndex, input.name)"
                                                           type="text"
                                                           class="form-control" :disabled="input.disable">

                                                    <!-- extend to textarea -->
                                                    <!-- extend to select options -->

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-10 col-md-offset-2">

                                                <span @click="storeInputs" class="btn btn-primary">Add</span>
                                                <span @click="storeInputsAndReturn"
                                                      class="btn btn-primary">Add & Return</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<style>
    form#createForm table td {
        padding: 15px  15px  0  15px;
        border-bottom: 1px solid #efefef;
    }
</style>

<script>

    import DomainMixin from './mixins/domain.vue';
    import Relation from './mixins/relation.vue'

    export default{

        mixins: [DomainMixin, Relation],

        data(){
            return {
//                rowIndex: [],
//                input: {},
                // if errors aren't working maybe convert back to objects
                inputvalues: {}, // if not working convert back to {}
//                inputValue: String,
                inputRows: [], // if not working convert back to {}
                initialInputRow: [], // if not working convert back to {}
                show: false,
                numRows: 0,
                addNumberTotal: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 20],
                redirect: Boolean,
//                rowIndex: Number,
            }
        },

        created: function () {
            this.show = false;
            this.fetchInputs();
            this.refreshForm();
        },

        beforeDestroy: function () {
        },

        watch: {
            'inputvalues': function (val, oldVal) {
                console.log('inputvalues', val, oldVal)
//                this.$nextTick(function() {
//                    this.$refs.vuetable.refresh()
//                })
            }
        },

        computed: {
            indexUrl() {

                var full_url = window.location.href;
                var url = full_url.split("/create")[0];

                return url;
            }
        },

        methods: {

            inputName(rowIndex, name) {
                return rowIndex + '.' + name
            },

//            inputValue(name, rowIndex) {
//                return this.inputvalues[rowIndex][name]
//            },

            setRowinputvalues(row) {
                console.log('setRowinputvalues:');
                var copyInputs = {};
                for (var rowInputs in this.initialInputRow) {
                    copyInputs[this.initialInputRow[rowInputs].name] = this.initialInputRow[rowInputs].value;
                }
                var key = 'inputvalues[' + row + ']';
//                Vue.set(key, copyInputs);
                key = copyInputs;
            },

            fetchInputs() {

                console.log('fetchInputs:');
                var url = this.apiDomain + '/api/data/create';
                var request_options = {
                    params: {}
                };

                this.$http.get(url, request_options)

                        .then((response) => {

                            console.log('Response Data:');
                            console.log(response.data);
                            this.inputRows[this.numRows] = response.data.inputs;
                            this.initialInputRow = response.data.inputs;
//                            this.setRowinputvalues(0);
                            this.refreshForm();

                        }, (response) => {

                            console.log('Error Response Data:');
                            console.log(response);
                            eventHub.$emit('error-response', response)

                        });
            },

            sendStoreRequest(doRedirect) {
                console.log('storeInputs:');
                var url = this.apiDomain + '/api/data';

                console.log('this.inputvalues', this.inputvalues)
//                return

                this.params = new Array()

                var that = this

//                console.log('this.inputvalues.length', this.inputvalues.length)

                var keys = Object.keys(this.inputvalues)
                console.log('keys', keys)



                keys.forEach(function (inputKey) {

                    console.log('that.inputvalues[inputKey]', that.inputvalues[inputKey] )

                    if(that.inputvalues[inputKey] !== null) {

                        var rowNameInputs = inputKey.split(".");
    //                    console.log('rowNameInputs', rowNameInputs)
                        var rowIndex = rowNameInputs[0]
                        var inputName = rowNameInputs[1]
    //                    console.log('rowIndex', rowIndex, 'inputName', inputName)

                        if(typeof that.params[rowIndex] === 'undefined') {
                            that.params[rowIndex] = {}
                        }

                        that.params[rowIndex][inputName] = that.inputvalues[inputKey]

                    }

                }, that)

                // remove default empty row
//                this.params.splice(0, 1);

//                console.log('this.params', this.params)

//                // map inputs object to array
//                this.params.forEach(function (row) {
//                    console.log('row', row)
//                    console.log('rowkeys', Object.keys(row))
//
//                    var inputsarray = Object.keys(row).map(function (key) {
//
//                        console.log('key', key, 'row[key]', row[key])
//                        return row[key];
//                    });
//
//                    console.log('array', array)
//
//                    httpparams[row] = inputsarray
//                }, that)
//
//                // map row object to array
//                var httpparams = Object.keys(that.params).map(function (key) {
//                    return that.params[key];
//                }, that);


//                var httpparams = array

                console.log('this.params', this.params)

                var redirect = this.$http.post(url, this.params)

                        .then((response) => {

                            console.log('Success - updating');
                            console.log(response.body);
                            eventHub.$emit('hide-errors', response)
                            eventHub.$emit('flash-message-response', response)

//                            this.$nextTick(function () {
//                                this.redirect = true
//                            })

                            var that = this;
                            console.log('redirect:')
                            console.log(doRedirect)



                            if (doRedirect && !response.data.hasOwnProperty("errors")) {
                                console.log('true:')
                                setTimeout(function () {
                                    window.location.href = that.indexUrl;
                                }, 1000, that);
                            } else {
                                this.hideForm();
                                this.$nextTick(function () {
                                    this.resetForm();
                                    this.refreshForm();
                                })
                            }

                        }, (response) => {

                            console.log('Error');
                            console.log(response);
                            eventHub.$emit('error-response', response)

//                            this.$nextTick(function () {
//                                this.redirect = false
//                            })
                        });

            },

            storeInputs() {
                var doRedirect = false
                this.sendStoreRequest(doRedirect);
            },

            storeInputsAndReturn() {
                var doRedirect = true
                this.sendStoreRequest(doRedirect);
//                var that = this;
//                this.$nextTick(function () {
//                    console.log('redirect:')
//                    console.log(that.redirect)
//                    if(that.redirect === true) {
//                        console.log('true:')
//                        setTimeout(function () {
//                            window.location.href = that.indexUrl;
//                        }, 3000, that);
//                    }
//                })
            },

            addRow() {

                console.log('addRow:');
                var e = document.getElementById('addRowsNum');
                var addRows = e.options[e.selectedIndex].value;
                var start = this.numRows + 1;
                var end = this.numRows + Number(addRows);

                var i;
                for (i = start; end >= i; i++) {
                    this.numRows++;
                    this.setInputRow(i);
//                    this.setRowinputvalues(i);
                }



                this.refreshForm();
            },

            resetForm() {
                console.log('resetForm:');
                this.numRows = 0;
//                for (var member in this.inputRows) delete this.inputRows[member];
                this.inputRows = [];
                this.inputRows[this.numRows] = this.initialInputRow;
//                for (var member in this.inputvalues) delete this.inputvalues[member];
                this.inputvalues = [];
//                this.setRowinputvalues(1);
                console.log(this.inputRows);
                console.log(this.inputvalues);
            },

            setInputRow(row) {
                console.log('setInputRow:');
                console.log('Row:');
                console.log(row);
//                var copy = this.initialInputRow.constructor();
                var copy = {};
                for (var attr in this.initialInputRow) {
                    copy[attr] = this.initialInputRow[attr];
                }
                this.inputRows[row] = copy;
            },

            refreshForm() {
                console.log('refreshForm:');
//                    var that = this;
//                    setTimeout(function () {
//                        that.showForm();
//                    }, 500, that);
                this.hideForm();
                this.$nextTick(function () {
                    this.showForm();
                })
            },

            hideForm() {
                console.log('hideForm:');
                this.show = false;
            },

            showForm() {
                this.show = true;
            },

            inputTypeMatch(input, type) {
                if (input.type == type) {
                    return true;
                }
                else if (input.options != null) {
                    return true;
                }
                return false;
            }

        }

    }
</script>
