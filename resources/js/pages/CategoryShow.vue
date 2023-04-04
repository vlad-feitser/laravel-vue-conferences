<template>
    <div>
        <div class="d-flex">
            <h1 class="mx-auto">Category Page</h1>
            <v-btn class="primary float-right" @click="$router.push('/categories/create')">Create / Edit Category</v-btn>
        </div>

            <div class="categories">
                <div class="category" v-for="category in categories" :key="category.id">
                   <p class="mb-5">Category: <strong>{{category.name}}</strong></p>
                    <div v-for="conference in conferences" :key="conference.id">
                        <p v-if="category.id === conference.category_id">Conference: <span class="text-decoration-underline">{{conference.title}}</span></p>
                    </div>
                    <div v-for="lecture in lectures" :key="lecture.id">
                        <p v-if="category.id === lecture.category_id">Lecture: <span class="text-decoration-underline">{{lecture.title}}</span></p>
                    </div>
                </div>
            </div> 

        
    </div>
</template>

<script>
export default {
    data: () => ({
        categories: [],
        conferences: [],
        lectures: []
    }),
    methods: {
        async getCategories() {
            await axios.get('/api/categories')
            .then(response => {
                this.categories = response.data
            })
        },
        async getConferences() {
            await axios.get('/api/conferences')
            .then(response => {
                this.conferences = response.data.data
            })
        },
        async getLectures() {
            await axios.get('/api/lectures')
            .then(response => {
                this.lectures = response.data
            })
        },
        resetForm() {
            this.form.conference_id = ''
            this.form.category_id = ''
        },
        sendForm() {
            console.log(this.form)
            axios.put('/api/conferences/category/' + this.form.conference_id, this.form.category_id)
            .then(res => {
                console.log(res)
            })
        }
    },
    mounted() {
        this.getCategories()
        this.getConferences()
        this.getLectures()
    }
}
</script>

<style scoped>

.btn_reset {
    color: teal;
    border: 2px solid black;
    padding: 4px 25px;
    border-radius: 25px;
    display: flex;
    margin: 15% auto 0;
}

.btn_add {
    color: black;
    border: 2px solid teal;
    padding: 4px 25px;
    border-radius: 25px;
    display: flex;
    margin: 8% auto 0;
}

.add_to_categories {
    width: 20%;
    height: 400px;
    border: 2px solid teal;
    margin-right: 5%;
    margin-top: 1%;
}
.category {
    text-align: center;
    float:left;
    width: 25%;
    border: 1px solid teal;
    padding: 20px 10px;
    margin: 2% 0 2% 6%;
}
</style>