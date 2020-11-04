<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editer la formation
            </h2>
        </template>

        <div class="py-12">
            <div class="py-5 text-green-500 bg-green-200 p-3 mx-4 mb-2" v-if="$page.flash.success">
                {{ $page.flash.success }}
            </div>
            <div class="w-full mx-8">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Titre de la formation
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text"
                        v-model="courseData.title" >
                        <div class="text-red-500 text-xs my-1" v-if="$page.errors">
                            {{ $page.errors.title}}
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Description de la formation
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text"
                        v-model="courseData.description"></textarea>
                        <div class="text-red-500 text-xs my-1" v-if="$page.errors">
                            {{ $page.errors.description}}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h2 class="text-2xl">Episode de la formation</h2>
                        <div v-for="(episode, index) in courseData.episodes" v-bind:key="index" class="mt-3">
                            Episode n°{{ index + 1}}
                             <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Titre de l'épisode n°{{ index + 1}}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text"
                                v-model="courseData.episodes[index].title">
                                <div class="text-red-500 text-xs my-1" v-if="$page.errors['episodes.' + index + '.title']">
                                    {{ $page.errors['episodes.' + index  + '.title'] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                    Description de l'épisode n°{{ (index) + 1 }}
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text"
                                v-model="courseData.episodes[index].description"></textarea>

                                <div class="text-red-500 text-xs my-1" v-if="$page.errors['episodes.' + index + '.description']">
                                   {{ $page.errors['episodes.' + index + '.description'] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="video_url">
                                    URL de l'épisode n°{{ index + 1 }}
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="video_url" type="text"
                                v-model="courseData.episodes[index].video_url">

                                <div class="text-red-500 text-xs my-1" v-if="$page.errors['episodes.' + index + '.video_url']">
                                    {{ $page.errors['episodes.' + index + '.video_url'] }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="flex">
                        <div v-if="courseData.episodes.length < 15"  class="mr-1">
                            <button class="block rounded bg-green-500 py-2 px-4 text-white mb-1 focus:outline-none" @click.prevent="addEpisode">+</button>
                        </div>
                        <div v-if="courseData.episodes.length > 1 " class="mr-1">
                            <button class="block rounded bg-red-500 py-2 px-4 text-white mb-1 focus:outline-none" @click.prevent="removeEpisode">🗑️</button>
                        </div>
                    </div>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Modifier la formation
                    </button>
                </form>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'

    export default {

        props: ['course'],

        components: {
            AppLayout,
        },

        data() {
            return {
                courseData: this.course,
            }
        },
        methods: {
            submit() {
                this.$inertia.patch('/courses/edit/' + this.courseData.id, this.courseData);
            },
            addEpisode() {
                this.courseData.episodes.push({title: null, description: null, video_url: null});
            },
            removeEpisode(){
                this.courseData.episodes.pop()
            }
        },
        mounted() {

        }
    }
</script>
