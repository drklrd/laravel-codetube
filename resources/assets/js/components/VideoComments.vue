<template lang="html">

    <ul class="media-list">
        <p> {{comments.length}} comment(s) </p>

        <div class="video-comments clearfix" if="$root.user.authenticated">
            <textarea placeholder="Comment" class="form-control video-comment__input" v-model="body"></textarea>
            <div class="pull-right">
                <button type="submit" class="btn btn-default" @click="createComment">Post</button>
            </div>
        </div>

        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a >
                    <img width="20" v-bind:src="comment.channel.data.image" alt="Channel image" class="media-object">
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
            },
            createComment(){
                this.$http.post('/videos/'+this.videoUid+'/comments',{
                    body : this.body
                })
                    .then((response)=>{
                        this.comments.unshift(response.body.data);
                        this.body=null;
                    });
            }
        },
        props : {
            videoUid : null
        },
        data (){
            return {
                comments : [],
                body : null
            }
        },
        mounted(){
            this.getComments();
        }
    }
</script>

<style lang="css">
</style>
