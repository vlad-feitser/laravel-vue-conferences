<template>
    <div class="lecture">
        <form @submit.prevent>
            <h3 class="header">Create Lecture</h3>
            
            <div class="d-flex">
                <div>
                    <input v-model="lecture.title" min="2" max="255" class="input" type="text" placeholder="Topic" required/>
                    
                    <input v-model="lecture.start_time" type="datetime-local" class="input" required>
                    <input v-model="lecture.end_time" type="datetime-local" class="input" required>
                    
                    <input @change="onPresentetionChange" type="file" class="input" placeholder="Presentation" required>
                    
                    <div>
                        <v-select
                            class="add_category"
                            v-model="lecture.category_id"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            placeholder="Select category"
                        ></v-select>
                        <v-btn v-if="lecture.category_id" color="primary" small @click="resetCategory">Reset Category</v-btn>
                    </div>

                    <textarea v-model="lecture.description" class="input" cols="30" rows="9" placeholder="Description" required></textarea>
                </div>
            </div>
                      
            <button @click="createLecture" class="btn-form">Create</button>                
        </form>
    </div>
    
</template>

<script>
export default {
    data: () => ({
        lecture: {
            title: '',
            category_id: '',
            start_time: '',
            end_time: '',
            description: '',
            presentation: '',
        },
        categories: []
    }),
    methods: {
        createLecture() {
            const formData = new FormData()
            formData.append('title', this.lecture.title)
            formData.append('category_id', this.lecture.category_id)
            formData.append('start_time', this.lecture.start_time)
            formData.append('end_time', this.lecture.end_time)
            formData.append('description', this.lecture.description)
            formData.append('presentation', this.lecture.presentation)
            this.$emit('create', formData)
            this.lecture = {
                title: '',
                start_time: '',
                end_time: '',
                description: '',
                presentation: '',
            }
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
            this.lecture.category_id = ''
        }
    },
    mounted() {
        this.getCategories()
    }
}
</script>

<style scoped>

.lecture {
    text-align: center;
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
    padding: 8px 10px;
    margin-top: 8px;
    margin-bottom: 1.2%;
    width: 85%;
}

.add_category {
    padding: 2px 5px;
    width: 85%;
    margin: auto;
}
</style>