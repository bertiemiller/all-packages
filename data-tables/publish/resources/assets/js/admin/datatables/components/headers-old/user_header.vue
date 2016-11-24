<template>
        <div class="row">

            <div class="col-md-12">

                <div class="form-inline form-group">

                    <div class="btn-group">
                        <a @click="selectMoreItems('Test button')">
                            <button class="btn btn-primary">
                                Test button
                            </button>
                        </a>
                    </div>

                    <div class="btn-group">
                        <a @click="selectMoreItems('Select more items from bank')">
                            <button class="btn btn-primary">
                                Select more items from bank
                            </button>
                        </a>
                    </div>

                </div>

                <hr>
            </div>

        </div>

</template>

<script>
    export default{

        data(){
            return{
                msg:'hello user vue'
            }
        },

        methods: {
            selectMoreItems(action)
            {
                alert('button actions: ' + action)
            }

        }
    }
</script>
