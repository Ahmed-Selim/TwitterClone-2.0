<template>
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill" id="navId">
            <li class="nav-item border border-primary rounded">
                <a data-bs-target="#tab1" class="nav-link active" data-bs-toggle="tab">Tweets</a>
            </li>
            <li class="nav-item">
                <a data-bs-target="#tab2" class="nav-link disabled" data-bs-toggle="tab">Tweets &amp; replies</a>
            </li>
            <li class="nav-item">
                <a data-bs-target="#tab3" class="nav-link disabled" data-bs-toggle="tab">Media</a>
            </li>
            <li class="nav-item">
                <a data-bs-target="#tab4" class="nav-link disabled" data-bs-toggle="tab">Likes</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content px-2 pt-1">
            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                <div v-for="(tweet, index) in user.profile.tweets" v-bind:key="index" >
                    <tweet :tweet="tweet" :profile="user.profile"></tweet>
                </div>
            </div>
            <div class="tab-pane fade" id="tab2" role="tabpanel">B</div>
            <div class="tab-pane fade" id="tab3" role="tabpanel">C</div>
            <div class="tab-pane fade" id="tab4" role="tabpanel">D</div>
        </div>
    </div>

</template>

<script>
    export default {
        props: [ 'user' ],

        mounted () {
            $('#navId a').click(e => {
                e.preventDefault();
                $(e.target).tab('show');
            });
        },

        data: function () {
            return {

            }
        },

        computed: {

        },

        methods: {

        }
    }
</script>
