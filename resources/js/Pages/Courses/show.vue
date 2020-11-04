<template>
    <app-layout>
        <template #header>
            {{ course.title }}
        </template>
            <div class="py-5 mx-8">
                <div class="text-2xl"> {{ course.episodes[this.currentEpisode].title }} </div>

                <iframe class="w-full h-screen" :src="course.episodes[this.currentEpisode].video_url"
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
                </iframe>
                <div class="text-sm text-gray-500 my-2"> {{ course.episodes[this.currentEpisode].description }}</div>
                <progress-bar :episodes="course.episodes" :watched-episodes="watched" />
                <div class="mt-6">
                    <ul v-for="(episode, index) in this.course.episodes" v-bind:key="episode.id" >
                        <li class="mt-3 flex justify-between items-center">
                            <div>
                                Episode n° {{ index + 1 }} - {{ episode.title }}
                                <button class="text-gray-500 focus:text-indigo-500 focus:outline-none"
                                    @click="SwitchEpisode(index)">Voir l'épisode
                                </button>
                            </div>
                            <progress-button :episode-id="episode.id" :watched-episodes="watched" />
                        </li>
                    </ul>
                </div>
            </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import ProgressButton from './ProgressButton'
    import ProgressBar from './ProgressBar'

export default {
    components: {
        AppLayout,
        ProgressButton,
        ProgressBar,
    },
    props: ['course', 'watched'],

    data() {
        return {
            currentEpisode: 0
        }
    },
    methods: {
        SwitchEpisode(index){
            this.currentEpisode = index;

            window.scrollTo({
                top: 0,
                left:0,
                behavior: 'smooth'
            })
        },
    },

    mounted() {
    },

}
</script>
