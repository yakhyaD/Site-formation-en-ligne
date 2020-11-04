<template>
    <div class="bg-gray-200 w-full rounded">
        <div class="bg-green-500 rounded-l text-white text-center transition-width duration-500" :style="'width:' + percentage + '%'">
            {{ percentage }}%
        </div>
    </div>
</template>

<script>
export default {

    props: ['episodes', 'watchedEpisodes'],

    data() {
        return {
            EpisodesView: this.watchedEpisodes
        }
    },

    computed: {
        percentage() {
            let filteredEp = this.episodes.filter(courseEp => {
                return this.EpisodesView.find(watchedEp => {
                    return watchedEp.id === courseEp.id
                })
            })
            return Math.ceil(filteredEp.length/this.episodes.length * 100);
        }
    },

    mounted() {
        eventBus.$on('toggleProgress', data => this.EpisodesView = data)
    }
}
</script>
