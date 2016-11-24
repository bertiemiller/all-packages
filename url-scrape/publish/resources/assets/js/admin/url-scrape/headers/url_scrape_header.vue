<template>
    <div class="row">
        <div class="col-md-12">
            <div class="form-inline form-group">

                <div class="btn-group">
                    <a @click="selectMoreItems('Scrape All Urls')">
                        <button class="btn btn-primary">
                            Scrape All Urls
                        </button>
                    </a>
                </div>

                <div class="btn-group">
                    <a @click="selectMoreItems('Scrape Selected Urls')">
                        <button class="btn btn-primary">
                            Scrape Selected Urls
                        </button>
                    </a>
                </div>


                <div class="btn-group">
                    <a @click="selectMoreItems('Select more urls from bank')">
                        <button class="btn btn-primary">
                            Select more urls from bank
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
            return {
                msg: 'hello user vue'
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
