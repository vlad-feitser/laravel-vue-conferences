<template>
<div>
        <h1 class="text-center">Favorites Lectures</h1>
    <div>
        <div class="lecture" v-for="lecture in this.lectures" :key="lecture.id">
            <router-link :to="{name: 'lectures.show', params: {id: lecture.id}}"><h4>{{lecture.title}}</h4></router-link>
            <p>{{lecture.start_time | moment("H:mm")}}-{{lecture.end_time | moment("H:mm")}}</p>
            <p v-if="lecture.id === showMore.lecture_id && showMore.showFullDesc === true">{{lecture.description}}</p>
            <p v-else>{{lecture.description.substr(0, 99)}} <span v-if="lecture.description.length > 100">...<v-btn @click="showFull(lecture.id)" small class="ml-2">More</v-btn></span></p>
            <v-icon class="mr-4" color="red" @click="deleteFavorites(lecture.id)">mdi-heart</v-icon>
            <v-btn v-if="lecture.user_id === user.id" :to="{name: 'lectures.edit', params: {id: lecture.id}}" class="info mr-3">Edit</v-btn>
            <v-btn v-if="lecture.user_id === user.id" @click="cancelLecture(lecture.id)" color="error">Delete</v-btn>
        </div>
    </div>
</div>
    
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    data: () => ({
        user: JSON.parse(localStorage.getItem('user')),
        lectures: [],
        showMore: {
            lecture_id: '',
            showFullDesc: false
        }
    }),
    methods: {
        ...mapActions({
            deleteFavorite: 'user/deleteFavorite',
            deleteLectures: 'lecture/deleteLectures'
        }),
        async getFavoriteLectures(id) {
            await axios.get('/api/lectures/' + id + '/favorites')
            .then(res => {
                this.lectures = res.data
            })
        },
        showFull(id) {
            this.showMore.lecture_id = id
            this.showMore.showFullDesc = true
        },
        deleteFavorites(id) {
            this.deleteFavorite(id)
            this.lectures = this.lectures.filter(l => l.id !== id)
        },
        cancelLecture(id) {
            this.deleteFavorite(id)
            this.deleteLectures(id)
            this.lectures = this.lectures.filter(l => l.id !== id)
        }
    },
    mounted() {
        this.getFavoriteLectures(this.$route.params.id)
    },
    computed: {
        ...mapGetters({
            getFavoritesLectures: 'user/getFavoritesLectures'
        })
    }
}
</script>

<style scoped>
.lecture {
    text-align: center;
    display: inline-block;
    width: 25%;
    border: 1px solid teal;
    padding: 20px 10px;
    margin: 2% 0 0 6%;
}
</style>