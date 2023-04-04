<template>
    
    <div v-if="!not_found">
        <h2 class="header">Edit "{{conference.title}}" conference</h2>
        
        <div>
        <div class="d-flex justify-space-between col-10">
            <div>
                <input v-model="conference.title" class="input" type="text" placeholder="Title" />
                <select class="input" v-model="conference.country">
                    <option value="" selected disabled>Choose country</option>
                    <option value="USA">USA</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="Canada">Canada</option>
                    <option value="France">France</option>
                </select>
                <input v-model="conference.latitude" class="input" type="number" placeholder="Latitude" />
                <input v-model="conference.longitude" class="input" type="number" placeholder="Longitude" />
                
                <GmapMap class="map"
                v-if="this.conference.latitude"
                :center="{lat: conference.latitude, lng: conference.longitude}"
                :zoom="7"
                >
                <GmapMarker
                    @dragend="updateCoords($event.latLng)"
                    v-if="this.conference.latitude"
                    :position="{lat: conference.latitude, lng: conference.longitude}"
                    :clickable=true
                    :draggable=true
                />
                </GmapMap>
            </div>
            <div class="mr-5">
                <v-date-picker v-model="conference.date"></v-date-picker>

                <v-select
                    class="add_category"
                    v-model="conference.category_id"
                    :items="categories"
                    item-text="name"
                    item-value="id"
                    placeholder="Select category"
                ></v-select>

                <v-btn v-if="conference.category_id" color="primary" small @click="resetCategory">Reset</v-btn>
            </div>
        </div>
        </div>

        <div class="text-center">
            <v-btn color="primary" class="mr-5" @click="updateConference(conference.id)">Update</v-btn>
            <v-btn @click="deleteConf" class="ml-5" color="error">Delete</v-btn>
        </div>
        
        
        <v-btn @click="$router.push('/conferences/' + conference.id)" class="btn__back" color="primary">Go Back</v-btn>
    </div>

    <div v-else>
        <h1 class="red--text">Not found conference for edit</h1>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    data: () => ({
        conference: {
            title: '',
            category_id: '',
            date: '',
            latitude: '',
            longitude: '',
            country: ''
        },
        not_found: false,
        errors: false,
        categories: []
    }),
    methods: {
        ...mapActions({
            deleteConference: 'conference/deleteConference'
        }),
        editConference(id) {
            axios.get('/api/conferences/' + id + '/edit')
            .then(res => {
                this.conference = res.data
            })
            .catch(e => {
                this.not_found = true
            })
        },
        updateConference(id) {
            axios.put('/api/conferences/' + id, this.conference, {
                headers: {
                    "Content-type": "application/json"
                }
            })
            .then(res => {
                if(res.status === 200) {
                    this.$router.push('/')
                } else {
                    this.errors = true
                }
            })
        },
        updateCoords(coords) {
            this.conference.latitude = coords.lat()
            this.conference.longitude = coords.lng()
        },
        deleteConf() {
            this.deleteConference(this.conference.id)
            this.$router.push('/')
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
        this.editConference(this.$route.params.id)
        this.getCategories()
    }
}
</script>

<style scoped>
.table {
    margin: 1% auto 7px;
    border: 2px solid teal;
    padding: 10px;
}

.table tr, td {
    padding: 10px 20px;
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
    margin-top: 8px;
    width: 85%;
}

.map {
    margin: 20px 0;
    width: 85%;
    height: 300px;
    border: 2px solid teal;
}
</style>