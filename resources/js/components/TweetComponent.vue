<template>
    <div class="mx-0 row px-2 py-4 border-top">
        <div class="col-1 px-0">
            <img :src="profile.profile_image" alt="profile image" style="width:49px;height:49px" class="rounded-circle">
        </div>
        <div class="col ps-0">
            <div class="row">
                <div class="h5 me-2 font-weight-bold mb-0">{{ profile.name }}</div>
                <div class="text-muted">
                    <span>@</span>{{ profile.username }} . {{ formattedDate }}
                </div>
            </div>
            <div class="row mx-3">{{ tweet.body }}</div>
            <div class="mx-3">
                <a
                    :href="baseUrl + '/tweet-tags/' + tag.id"
                    v-for="(tag, index) in tweet.tags"
                    :key="index"
                    class="text-decoration-none">
                    <!-- <span v-if="index != 0">,&nbsp;</span> -->
                    <span>#</span>{{ tag.tag }}&nbsp;&nbsp;
                </a>
            </div>
            <!-- <nav class="nav nav-pills nav-fill mt-2">
                <button class="nav-item btn border-info text-left">
                    Replies <span>{{ tweet.replies }}</span>
                </button>
                <button class="nav-item btn border-info text-left">
                    Retweets <span>{{ tweet.retweets }}</span>
                </button>
                <button class="nav-item btn border-info text-left">
                    Likes <span>{{ tweet.likes }}</span>
                </button>
            </nav> -->
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: [ 'tweet', 'profile'],

        data: function () {
            return {

            }
        },

        mounted: function () {
            // console.log(this.user);
        },

        computed: {
            formattedDate() {
                return moment(String(this.tweet.updated_at)).fromNow();
            },
            baseUrl() {
                return window.location.origin ;
            }
        },

        methods: {

        }
    }
</script>
