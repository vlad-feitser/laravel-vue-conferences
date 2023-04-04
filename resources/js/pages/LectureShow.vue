<template>
    <div v-if="!not_found">
        <h1 class="header">Details info about "{{lecture.title}}" lecture</h1>
        <div>
            <div class="lecture">
                <h2>{{lecture.title}}</h2>
                <h3>Time: {{lecture.start_time | moment("H:mm")}}-{{lecture.end_time | moment("H:mm")}}</h3>
                <h4 v-if="lecture.categories">Category: {{lecture.categories.name}}</h4>
                <h4>Description: {{lecture.description}}</h4>
                <p><button @click.prevent="downloadPresentation" class="blue--text text-decoration-underline">Download</button> presentation</p>
            </div>
            
            <table class="table__btns">
                <tr>
                    <td><v-btn v-if="lecture.user_id === user.id" :to="{name: 'lectures.edit', params: {id: lecture.id}}" class="info mr-3">Edit</v-btn></td>
                    <td><v-btn v-if="lecture.user_id === user.id" @click="cancelLecture(lecture.id)" color="error">Delete</v-btn></td>
                </tr>
            </table>

            <h1 class="header mt-3 mb-2">Comments</h1>
                
            <div class="comments">
                <div class="comment" v-for="com in this.comments" :key="com.id">
                    <div class="comment__window">
                        <div><span class="text-decoration-underline">{{com.user.firstname}} {{com.user.lastname}}</span>: <p v-html="com.content" class="comment_text"></p></div>
                        <p>{{com.updated_at | moment("D.MM.Y H:mm") }}</p>
                    </div>

                    <v-btn
                        v-if="com.user_id === user.id
                        && new Date().toLocaleDateString() === new Date(com.updated_at).toLocaleDateString()
                        && ((new Date().getMinutes() - new Date(com.updated_at).getMinutes() <= 10
                            && new Date().getHours() === new Date(com.updated_at).getHours())
                        || (new Date(com.updated_at).getMinutes() - new Date().getMinutes() >= 50
                            && new Date().getHours() - new Date(com.updated_at).getHours() === 1))" 
                        @click="editCom(com)" color="info" class="mb-3">Edit
                    </v-btn>
                </div>
            </div>

            <div class="addComment">

                <h3 class="my-1 ml-3">Add your comment:</h3>
                <div>
                    <VueEditor v-model="comment.content" class="editor" placeholder="Content..." />
                </div>
                <v-btn @click="addComment(lecture.id)" color="teal" class="mt-12 float-right mr-3 white--text">Send</v-btn>
                
            </div>

        </div>

        <v-btn @click="$router.push('/conferences/' + lecture.conference_id)" class="btn__back" color="primary">Go Back</v-btn>
    
    </div>

    <div v-else>
        <h1 class="red--text">Lecture not found..</h1>
    </div>

</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    data: () => ({
        user: JSON.parse(localStorage.getItem('user')),
        lecture: [],
        comments: [],
        not_found: false,
        comment: {
            content: '',
            lecture_id: '',
            toUpdate: false
        }
    }),
    methods: {
        ...mapActions({
            deleteLectures: 'lecture/deleteLectures',
            join: 'user/join',
            unjoin: 'user/unjoin',
        }),
        async getLecture(id) {
            await axios.get('/api/lectures/' + id)
            .then(res => {
                this.lecture = res.data
            })
            .catch(e => {
                this.not_found = true
            })
        },
        cancelLecture(id) {
            this.deleteLectures(id)
            this.$router.push('/conferences/' + this.lecture.conference_id)
        },
        downloadPresentation() {
            axios.get('/api/lectures/' + this.lecture.id + '/downloadPresentation', {responseType: 'blob'})
            .then(res => {
                const fileURL = window.URL.createObjectURL(new Blob([res.data]))
                var filelink = document.createElement('a')
                filelink.href = fileURL
                filelink.setAttribute('download', this.lecture.presentation)
                document.body.appendChild(filelink)
                filelink.click()
            })
        },
        getComments(id) {
            axios.get('/api/comments/' + id)
            .then(res => {
                this.comments = res.data
            })
        },
        addComment(id) {
            this.comment.lecture_id = id
            if(this.comment.toUpdate === false) {
                axios.post('/api/comments', this.comment, {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                .then(res => {
                    this.getComments(id)
                    this.comment.content = ''
                    this.comment.lecture_id = ''
                })
                .catch(e => {
                    console.log(e)
                })
            } else {
                axios.put('/api/comments/' + this.comment.id, this.comment, {
                    headers: {
                        "Content-type": "application/json"
                    }
                })
                .then(res => {
                    this.getComments(id)
                    this.comment.id = ''
                    this.comment.content = ''
                    this.comment.lecture_id = ''
                    this.comment.toUpdate = false
                })
            }
        },
        editCom(comment) {
            this.comment.id = comment.id
            this.comment.content = comment.content
            this.comment.lecture_id = comment.lecture_id
            this.comment.toUpdate = true
        }
    },
    mounted() {
        this.getLecture(this.$route.params.id)
        this.getComments(this.$route.params.id)
    },
    computed: {
        ...mapGetters({
            getUser: 'user/getUser',
            getJoinedConferences: 'user/getJoinedConferences'
        }),
        filterConference() {
            let filter = this.getJoinedConferences.filter(e => e.id === this.conference.id)
            if(filter.length) {
                return true
            }
            return false
        },
        
    }
}
</script>

<style scoped>
.header {
    align-items: center;
}

.comment_text {
    word-wrap: break-word;
}

.comments {
    padding: 10px;
    margin: 0 auto;
    width: 60%;
    height: 400px;
    border: 2px solid teal;
    overflow-y: scroll;
}

.comment {
    border: 2px solid teal;
    padding: 10px 10px 0;
    margin-top: 8px;
}

.addComment {
    margin: 1% auto;
    width: 60%;
    height: 280px;
    border: 1px solid teal;
}

.editor {
    height: 150px;
    padding: 10px;
}

.lecture {
    text-align: center;
    line-height: 40px;
    margin: 1% auto 0;
    width: 40%;
    border: 1px solid teal;
    padding: 10px;
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
    height: 300px;
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