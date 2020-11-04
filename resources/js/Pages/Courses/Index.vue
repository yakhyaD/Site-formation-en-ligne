<template>
    <app-layout>
        <template #header>
            liste des formations
        </template>
            <div class="py-4 text-green-500 bg-green-200 mx-4 mt-4" v-if="$page.flash.success">
                {{ $page.flash.success }}
            </div>
            <div class="container mx-auto">
                <div class="py-5" v-for="course in this.coursesList.data" v-bind:key="course.id">
                    <div class="mx-8 bg-white rounded shadow p-4">
                        <div class="text-sm text-gray-500">Mise en ligne par {{ course.user.name }} - <span
                        class="text-gray-500 text-sm"> {{ course.participants }}
                        participant<span v-if="parseInt(course.participants) > 1">s</span>
                        </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="">
                                <h1 class="text-2xl mb-2">{{ course.title }}</h1>
                                <span class="font-bold text-sm bg-gray-500 rounded p-2 text-white">{{ convertDuration(course.total_duration)  }}</span>
                            </div>
                            <div class="text-sm text-gray-400">
                                {{ course.episodes_count }} épisodes
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 mt-4"> {{ course.description }} </div>
                        <div class="flex justify-between">
                            <div>
                                <a :href="'/course/' + course.id" class="bg-indigo-500 text-white px-2 py-1 mt-2 text-sm rounded hover:bg-indigo-400 inline-block">Voir la formation</a>
                            </div>
                            <div v-if="course.update">
                                <a :href="'/courses/edit/' + course.id" v-if="course.update" class="bg-gray-800 text-white px-2 py-1 mt-2 text-sm rounded hover:bg-gray-500 inline-block">Modifier la formation</a>
                                <a :href="'/courses/delete/' + course.id" v-if="course.update" class="bg-red-600 text-white px-2 py-1 mt-2 text-sm rounded hover:bg-red-400 inline-block" >Supprimer la formation</a>
                            </div>
                        </div>
                    </div>
                </div>
                <inertia-link v-for="link in coursesList.links" v-bind:key="link.label" :href="link.url" class="text-indigo-700 border-gray-500 p-5">
                    <span v-bind:class="{'text-red-500': link.active}">{{ link.label }}</span>
                </inertia-link>
            </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    props: ['courses'],

    data() {
        return {
            coursesList: this.courses
        }
    },

    methods: {

        convertDuration(timestamp) {

           let hours = Math.floor(timestamp / 3600);
           let minutes = Math.floor((timestamp / 60) - (hours * 60));
           let seconds = timestamp % 60;

           return hours.toString().padStart(2,0) + ':' + minutes.toString().padStart(2,0) + ':' + seconds.toString().padStart(2,0);
       }
    },

    mounted() {
        console.log(this.coursesList)
    },

}
</script>
