<template lang="html">

    <ul class="media-list">
        <p> {{comments.length}} comment(s) </p>
        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a >
                    <img v-bind:src="comment.channel.data.image" alt="Channel image" class="media-object">
                </a>
            </div>
            <div class="media-body">
                <a > {{ comment.channel.data.name}} </a> {{comment.created_at_human}}
                <p>
                    {{comment.body}}
                </p>

                <div class="media" v-for="reply in comment.replies.data">
                    <div class="media-left">
                        <a >
                            <img v-bind:src="reply.channel.data.image" alt="Channel image" class="media-object">
                        </a>
                    </div>

                    <div class="media-body">
                        <a> {{ reply.channel.data.name}} </a> {{reply.created_at_human}}
                        <p>
                            {{reply.body}}
                        </p>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        methods : {
            getComments(){
                this.$http.get('/videos/'+this.videoUid+'/comments')
                    .then((response)=>{
                        this.comments = response.body.data;
                    })
            }
        },
        props : {
            videoUid : null
        },
        data (){
            return {
                comments : []
            }
        },
        mounted(){
            this.getComments();
        }
    }
</script>

<style lang="css">
</style>
