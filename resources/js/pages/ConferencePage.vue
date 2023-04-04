<template>
    <div>
        <h1 class="header">Page with Conferences</h1>
        <div class="app_btns">
            <button v-if="this.getUser && this.getUser.type === 'Admin'" @click="showDialog" class="btn btn_create">Create conference</button>
        </div>
        <my-dialog :show.sync="dialogVisible">
            <conference-form @create="createConference"></conference-form>
        </my-dialog>

        <my-dialog :show.sync="lectureVisible">
            <lecture-form @create="createLecture"></lecture-form>
        </my-dialog>
        
        <conference-list 
            :conferences="getConferences.data"
            @remove="deleteConference"
            @addLecture="showLectureForm"
            v-if="!isConferencesLoading"
        ></conference-list>

        <div v-if="getConferences.total > 1">
            <Pagination class="pagination" :data="getConferences" @pagination-change-page="fetchConferences">
                <template #prev-nav>
                    <span>&lt; Previous</span>
                </template>
                <template #next-nav>
                    <span>Next &gt;</span>
                </template>
            </Pagination>
        </div>
    </div>
</template>

<script>
import ConferenceForm from "../components/ConferenceForm.vue"
import ConferenceList from "../components/ConferenceList.vue"
import LectureForm from "../components/LectureForm.vue"
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex'
import MyDialog from "../components/UI/MyDialog.vue"
import LaravelVuePaginator from 'laravel-vue-pagination'
export default {
    components: {
    ConferenceForm,
    ConferenceList,
    LectureForm,
    MyDialog,
    'Pagination': LaravelVuePaginator
},
    data: () => ({
        dialogVisible: false,
        lectureVisible: false,
        conferenceId: ''
    }),
    methods: {
        ...mapMutations({
            setConferences: 'conference/setConferences',
            setLoading: 'conference/setLoading'
        }),
        ...mapActions({
            fetchConferences: 'conference/fetchConferences',
            deleteConference: 'conference/deleteConference',
            fetchLectures: 'lecture/fetchLectures',      
        }),
        createConference(conference) {
            axios.post('/api/conferences', conference, {
                headers: {
                    "Content-type": "application/json"
                }
            })
            .then(res => {
                if(res.status === 201) {
                    this.fetchConferences()
                    this.dialogVisible = false
                }
            })
        },
        async createLecture(lecture) {
            const config = {'content-type': 'multipart/form-data'}
            await axios.post('/api/lectures/' + this.conferenceId, lecture, config)
            .then(res => {
                if(res.status === 201) {
                    this.lectureVisible = false
                }
            })
        },
        showDialog() {
            this.dialogVisible = true
        },
        showLectureForm(confId) {
            this.lectureVisible = true
            this.conferenceId = confId
        }
        
    },
    mounted() {
        this.fetchConferences()
        this.conferenceId = ''
        
    },
    computed: {
        ...mapState({
            conferences: state => state.conference.conferences,
            isConferencesLoading: state => state.conference.isConferencesLoading,
        }),
        ...mapGetters({
            getConferences: 'conference/getConferences',
            getUser: 'user/getUser',
        })
    }
    
}
</script>

<style>
.header {
    text-align: center;
}

.btn {
    padding: 7px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
}

.app_btns {
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
}

.page__wrapper {
    display: flex;
    margin-top: 15px;
}

.pagination li {
    margin-top: 15px;
    float: left;
    padding: 4px 12px;
    list-style: none;
    text-decoration: none;
    border: 1px solid #ddd;
    color: white;
    background-color: white;
    font-size: 1em;
  }
  .pagination li.pagination-active {
    background-color: green;
  }
  
.pagination  li:hover:not(.active) {background-color: lightgreen;}
</style>