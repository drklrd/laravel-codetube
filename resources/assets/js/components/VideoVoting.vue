<template>

    <div class="video__voting">
        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'up'}" @click.prevent="vote('up')">
            <span class="glyphicon glyphicon-thumbs-up"></span>
        </a> {{ up }} &nbsp;

        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'down'}" @click.prevent="vote('down')">
            <span class="glyphicon glyphicon-thumbs-down"></span>
        </a> {{ down }} &nbsp;

    </div>

</template>

<script>
    export default {
        data (){
            return {
                up : 0,
                down : 0,
                userVote : null,
                canVote : false
            }
        },

        methods : {
            getVotes(){
                var url = '/videos/'+ this.videoUid.trim() + '/votes';
                console.log(url)
                this.$http.get(url).then((response)=>{
                    // console.log('###',response);
                    this.up = response.body.data.up;
                });
            },

            vote(type){
                if(this.userVote == type){
                    this[type]--;
                    this.userVote = null;
                    this.deleteVote(type);
                    return;
                }

                if(this.userVote){
                    this[type == 'up' ? 'down' : 'up']--;
                }

                this[type]++;

                this.userVote = type;
                this.createVote(type);

            },

            deleteVote(type){
                this.$http.delete(`/videos/${this.videoUid.trim()}/votes`,{
                    type
                });
            },
            createVote(type){
                this.$http.post(`/videos/${this.videoUid.trim()}/votes`,{
                    type
                });
            }
        },
        props : {
            videoUid : null
        },

        mounted(){
            Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

            this.getVotes();
        }
    }
</script>
