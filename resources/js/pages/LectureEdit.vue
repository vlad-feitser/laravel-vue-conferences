<template>
    <div v-if="!not_found">
        <h2 class="header">Edit "{{lecture.title}}" lecture</h2>
        <div class="lection">
            <div>
                <input v-model="lecture.title" class="input" type="text" placeholder="Topic" required />
                
                <input v-model="lecture.start_time" type="datetime-local" class="input" required>
                <input v-model="lecture.end_time" type="datetime-local" class="input" required>
                
                <div class="presentation" v-if="lecture.presentation">Current presentation: <span class="text-decoration-underline">{{lecture.presentation}}</span></div><input @change="onPresentetionChange" type="file" class="input">

                <v-select
                    class="add_category"
                    v-model="lecture.category_id"
                    :items="categories"
                    item-text="name"
                    item-value="id"
                    placeholder="Select category"
                ></v-select>

                <textarea v-model="lecture.description" class="input" cols="30" rows="8" placeholder="Description" required></textarea>
            </div>

            <div class="text-center">
                <v-btn color="primary" class="mr-5" @click="updateLecture(lecture.id)">Update</v-btn>
                <v-btn @click="deleteLecture" class="ml-5" color="error">Delete</v-btn>
            </div>
        
        </div>

        <v-btn @click="$router.push('/conferences/' + lecture.conference_id)" class="btn__back" color="primary">Go Back</v-btn>
    </div>

    <div v-else>
        <h1 class="red--text">Not found conference for edit</h1>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    data: () => ({
        lecture: {
            title: '',
            category_id: '',
            start_time: '',
            end_time: '',
            description: '',
            presentation: ''
        },
        old_presentation: '',
        not_found: false,
        errors: false,
        categories: []
    }),
    methods: {
        ...mapActions({
            deleteConference: 'conference/deleteConference',
            deleteLectures: 'lecture/deleteLectures'
        }),
        async editLecture(id) {
            await axios.get('/api/lectures/' + id + '/edit')
            .then(res => {
                this.lecture = res.data
                this.old_presentation = res.data.presentation
            })
            .catch(e => {
                this.not_found = true
            })
        },
        updateLecture(id) {
            const formData = new FormData()
            formData.append('title', this.lecture.title)
            formData.append('category_id', this.lecture.category_id)
            formData.append('start_time', this.lecture.start_time)
            formData.append('end_time', this.lecture.end_time)
            formData.append('description', this.lecture.description)
            if(this.old_presentation !== this.lecture.presentation) {
                formData.append('presentation', this.lecture.presentation)
            }
            formData.append('_method', 'PUT')
            const config = {'content-type': 'multipart/form-data'}
            axios.post('/api/lectures/' + id, formData, config)
            .then(res => {
                console.log(res)
                if(res.status === 200) {
                    this.$router.push('/lectures/' + this.lecture.id)
                } else {
                    this.errors = true
                }
            })
        },
        deleteLecture() {
            this.deleteLectures(this.lecture.id)
            this.$router.push('/')
        },
        onPresentetionChange(e) {
            this.lecture.presentation = e.target.files[0]
        },
        getCategories() {
            axios.get('/api/categories')
            .then(res => {
                this.categories = res.data
            })
            
        },
        resetCategory() {
            this.conference.category_id = ''
        }
    },
    mounted() {
        this.editLecture(this.$route.params.id)
        this.getCategories()
    }
}
</script>

<style scoped>

.lection {
    text-align: center;
}

.table {
    margin: 1% auto 7px;
    border: 2px solid teal;
    padding: 10px;
}

.input {
    border: 1px solid teal;
    padding: 10px 15px;
    margin-top: 8px;
    margin-bottom: 1%;
}

.presentation {
    margin-left: 16%;
    text-align: start;
}

.add_category {
    padding: 2px 5px;
    width: 70%;
    margin: auto;
}

.btn__back {
    position: fixed;
    float: right;
    bottom: 20px;
    right: 20px;
}

.header {
    text-align: center;
}

.btn-form {
    align-self: flex-end;
    padding: 7px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
    float: right;
}

.input {
    border: 1px solid teal;
    padding: 10px 15px;
    margin-top: 6px;
    width: 70%;
}
</style>