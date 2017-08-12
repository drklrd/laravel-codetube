<template>

    <div class="video__voting">
        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'up'}">
            <span class="glyphicon glyphicon-thumbs-up"></span>
        </a> {{ up }} &nbsp;

        <a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'down'}">
            <span class="glyphicon glyphicon-thumbs-down"></span>
        </a> {{ down }} &nbsp;

    </div>

</template>

<script>
    export default {
        data (){
            return {
                up : null,
                down : null,
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
            }
        },
        props : {
            videoUid : null
        },

        mounted(){
            this.getVotes();
        }
    }
</script>
