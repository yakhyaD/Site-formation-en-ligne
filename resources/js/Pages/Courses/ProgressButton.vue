<template>
    <div>
        <button class="bg-green-500 p-2 rounded text-white focus:outline-none" @click="toggleProgress()">
            {{ this.isWatched ? 'Terminé !' : 'Non terminé ?' }}
        </button>
    </div>
</template>

<script>
export default {

    props: ['episodeId','watchedEpisodes'],

    data() {
        return {
            watchedEp: this.watchedEpisodes,
            isWatched: null
        }
    },

    methods: {
        toggleProgress() {
            axios.post('/toggleProgress',{
                episodeId: this.episodeId
            })
            .then(response => {
                if(response.status === 200){
                    this.isWatched = !this.isWatched;
                    eventBus.$emit('toggleProgress', response.data)
                }
            })
            .catch(error => console.log(error))
        },

        EpisodeWatched(){
            return this.watchedEp.find(episode => episode.id === this.episodeId) ? true : false;
        }
    },

    mounted() {
        this.isWatched = this.EpisodeWatched();
    }
}
</script>
