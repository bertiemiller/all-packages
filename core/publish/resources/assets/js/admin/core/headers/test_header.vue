<template>
        <div class="row">

            <div class="col-md-12">

                <div class="form-inline form-group">

                    <div class="btn-group">
                        <a @click="selectMoreItems('Test Button')">
                            <button class="btn btn-primary">
                                Test Button
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

        methods: {
            selectMoreItems(action)
            {
                alert('button actions: ' + action)
            }

        }
    }
</script>
