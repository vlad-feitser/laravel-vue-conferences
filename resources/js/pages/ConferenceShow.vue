<template>
    <div v-if="!not_found">
        <h1 class="header">Details info about "{{conference.title}}" conference</h1>
        <div>
            <table class="table">
                <tr>
                    <td><h2>Title:</h2></td>
                    <td><h2>{{conference.title}}</h2></td>
                </tr>
                <tr>
                    <td><h2>Date:</h2></td>
                    <td><h3>{{(new Date(conference.date)).toLocaleDateString()}}</h3></td>
                </tr>
                <tr>
                    <td><h2>Country:</h2></td>
                    <td><h2>{{conference.country}}</h2></td>
                </tr>
                <tr v-if="conference.categories">
                    <td><h3>Category:</h3></td>
                    <td><h3>{{conference.categories.name}}</h3></td>
                </tr>
            </table>

            <GmapMap class="map"
                v-if="this.conference.latitude"
                :center="{lat: conference.latitude, lng: conference.longitude}"
                :zoom="12"
            >
            <GmapMarker
                v-if="this.conference.latitude"
                :position="{lat: conference.latitude, lng: conference.longitude}"
                :clickable=true
                :draggable=false
            />
            </GmapMap>

            <table class="table__btns">
                <tr>
                    <td v-if="this.getUser && this.getUser.type !== 'Admin' && filterConference" class="d-flex mt-1">
                        
                        <div class="fb-share-button" data-href="http://127.0.0.1:8000/" data-layout="button" data-size="small" ><a target="_blank" 
                            href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Ffeitser-ve.groupbwt.com&amp;src=sdkpreparse" 
                            class="fb-xfbml-parse-ignore"><i class="fa-brands fa-2x fa-facebook mr-3"></i></a>
                        </div>
                        <a 
                            href="http://twitter.com/share?&url=%0Ahttp%3A%2F%2Ffeitser-ve.groupbwt.com&text=Check out this Meetup with SoCal AngularJS!"
                            onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                            <i class="fa-brands fa-2x fa-twitter ml-3"></i>
                        </a>
                    </td>
                    <td v-else>
                        <v-btn v-if="this.getUser && this.getUser.type === 'Admin'" color="info" :to="{name: 'conferences.edit', params: {id: conference.id}}">Edit</v-btn>
                    </td>
                        <button v-if="this.getUser === null || this.getUser.type !== 'Admin' && !filterConference" @click="join(conference.id)" class="btn info white--text mt-3">Join</button>
                        
                    <td>
                        <v-btn v-if="this.getUser && this.getUser.type === 'Admin'" @click="deleteConf" color="error">Delete</v-btn>
                        <button v-if="this.getUser === null || this.getUser.type !== 'Admin' && filterConference" @click="unjoinConference(conference.id)" class="btn error white--text">Unjoin</button>
                    </td>
                </tr>
            </table>
            
        </div>

        <v-btn @click="$router.push('/')" class="btn__back" color="primary">Go Back</v-btn>

        <h1 v-if="this.lectures.length > 0" class="header">What reports will be at the conference</h1>

        <div>
            <div class="lecture" v-for="lecture in this.filterLecture" :key="lecture.id">
                <router-link :to="{name: 'lectures.show', params: {id: lecture.id}}"><h4>{{lecture.title}}</h4></router-link>
                <p>{{lecture.start_time | moment("H:mm")}}-{{lecture.end_time | moment("H:mm")}}</p>
                <p v-if="lecture.id === showMore.lecture_id && showMore.showFullDesc === true">{{lecture.description}}</p>
                <p v-else>{{lecture.description.substr(0, 99)}} <span v-if="lecture.description.length > 100">...<v-btn @click="showFull(lecture.id)" small class="ml-2">More</v-btn></span></p>
                <p>Total comments: {{lecture.comments.length}}</p>
                <v-icon v-if="!lecture.favorite" @click="addFavorites(lecture.id)" class="mr-4" color="grey">mdi-heart</v-icon>
                <v-icon v-if="lecture.favorite" class="mr-4" color="red" @click="deleteFavorites(lecture.id)">mdi-heart</v-icon>
                <v-btn v-if="lecture.user_id === user.id" :to="{name: 'lectures.edit', params: {id: lecture.id}}" class="info mr-3">Edit</v-btn>
                <v-btn v-if="lecture.user_id === user.id || user.type === 'Admin'" @click="cancelLecture(lecture.id)" color="error">Delete</v-btn>
            </div>
        </div>
    
    </div>

    <div v-else>
        <h1 class="red--text">Conference not found..</h1>
    </div>

</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
export default {
    data: () => ({
        user: JSON.parse(localStorage.getItem('user')),
        conference: [],
        lectures: [],
        not_found: false,
        showMore: {
            lecture_id: '',
            showFullDesc: false
        }
    }),
    methods: {
        ...mapActions({
            deleteConference: 'conference/deleteConference',
            deleteLectures: 'lecture/deleteLectures',
            join: 'user/join',
            unjoin: 'user/unjoin',
            addFavorite: 'user/addFavorite',
            deleteFavorite: 'user/deleteFavorite'
        }),
        async getConference(id) {
            await axios.get('/api/conferences/' + id)
            .then(res => {
                this.conference = res.data
                axios.get('/api/lectures/' + id + '/show')
                .then(res => {
                    if(res.data) {
                        this.lectures = res.data.lectures
                    } else {
                        console.log('error')
                    }
                })
            })
            .catch(e => {
                this.not_found = true
            })
        },
        addFavorites(id) {
            this.addFavorite(id)
        },
        deleteFavorites(id) {
            this.deleteFavorite(id)
        },
        deleteConf() {
            this.deleteConference(this.conference.id)
            this.$router.push('/')
        },
        cancelLecture(id) {
            this.deleteFavorite(id)
            this.deleteLectures(id)
            this.getConference(this.$route.params.id)
        },
        unjoinConference(id) {
            this.unjoin(id)
            this.$router.push('/')
        },
        showFull(id) {
            this.showMore.lecture_id = id
            this.showMore.showFullDesc = true
        }
    },
    mounted() {
        this.getConference(this.$route.params.id)

    },
    computed: {
        ...mapGetters({
            getUser: 'user/getUser',
            getJoinedConferences: 'user/getJoinedConferences',
            getFavoritesLectures: 'user/getFavoritesLectures'
        }),
        filterConference() {
            let filter = this.getJoinedConferences.filter(e => e.id === this.conference.id)
            if(filter.length) {
                return true
            }
            return false
        },
        filterLecture() {
            let filter = this.lectures.map(e => {
                let favorite = this.getFavoritesLectures.filter(f => f.id === e.id)
                if(favorite.length) {
                    return {
                        ...e,
                        favorite: true
                    }
                }
                return {
                    ...e,
                    favorite: false
                }
            })
            return filter
        },
    }
}
</script>

<style scoped>
.header {
    align-items: center;
}


.lecture {
    text-align: center;
    float: left;
    width: 25%;
    border: 1px solid teal;
    padding: 20px 10px;
    margin: 2% 0 2% 6%;
}

.table {
    margin: 1% auto;
    border: 2px solid teal;
    padding: 20px;
}


.table tr, td {
    padding: 10px 20px;
}

.map {
    margin: auto;
    width: 40%;
    height: 270px;
    border: 2px solid teal;
}

.table__btns {
    margin: auto;
}

.btn__back {
    position: fixed;
    float: right;
    bottom: 20px;
    right: 20px;
}
</style>