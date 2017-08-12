<template lang="html">

    <ul class="media-list">
        <p> {{comments.length}} comment(s) </p>

        <div class="video-comments clearfix" if="$root.user.authenticated">
            <textarea placeholder="Comment" class="form-control video-comment__input" v-model="body"></textarea>
            <div class="pull-right">
                <button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
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

                <ul class="list-inline">
                    <li v-if="$root.user.authenticated">
                        <a href="#" @click.prevent="toggleReplyForm(comment.id)" > {{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }} </a>
                    </li>
                </ul>

                <div class="video-comment clear" v-if="replyFormVisible === comment.id">
                    <textarea placeholder="Reply" class="form-control video-comment__input" v-model="replyBody"></textarea>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-defalt" @click.prevent="createReply(comment.id)" name="button">Reply</button>

                    </div>
                </div>

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
            createReply(commentId){

            },
            createComment(){
                this.$http.post('/videos/'+this.videoUid+'/comments',{
                    body : this.body
                })
                    .then((response)=>{
                        this.comments.unshift(response.body.data);
                        this.body=null;
                    });
            },
            toggleReplyForm(commentId){
                this.replyBody = null;
                if(this.replyFormVisible === commentId){
                    this.replyFormVisible = null;
                    return;
                }

                this.replyFormVisible = commentId;
            }
        },
        props : {
            videoUid : null
        },
        data (){
            return {
                comments : [],
                body : null,
                replyBody : null,
                replyFormVisible : null

            }
        },
        mounted(){
            this.getComments();
        }
    }
</script>

<style lang="css">
</style>
