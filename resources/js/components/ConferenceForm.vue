<template>
    <div>
        <form @submit.prevent>
            <h3 class="header">Create Conference</h3>
            
            <div class="d-flex">
                <div>
                    <input v-model="conference.title" class="input" type="text" placeholder="Title" />
                    <select class="input" v-model="conference.country">
                        <option value="" selected disabled>Choose country</option>
                        <option value="USA">USA</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="Canada">Canada</option>
                        <option value="France">France</option>
                    </select>
                    <input v-model="conference.latitude" class="input" min="-90" max="90" type="number" placeholder="Latitude" />
                    <input v-model="conference.longitude" class="input" min="-180" max="180" type="number" placeholder="Longitude" />
                    
                    
                        <GmapMap class="map"
                            :center="{lat: 49.0139, lng: 31.2858}"
                            :zoom="7"
                            @click="onMapClick($event.latLng)"
                        >
                        <GmapMarker
                            v-if="this.conference.latitude"
                            @dragend="updateCoords($event.latLng)"
                            :position="{lat: conference.latitude, lng: conference.longitude}"
                            :clickable="true"
                            :draggable="true"
                        />
                        </GmapMap>
                </div>
                <div>
                    <p>Date of conference: </p>
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
            
            <button @click="createConference" class="btn-form">Create</button>                
        </form>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            conference: {
                id: '',
                category_id: '',
                title: '',
                date: '',
                latitude: '',
                longitude: '',
                country: ''
            },
            categories: []
        }
    },
    methods: {
        onMapClick(coords) {
            this.conference.latitude = coords.lat()
            this.conference.longitude = coords.lng()
        },
        updateCoords(coords) {
            this.conference.latitude = coords.lat()
            this.conference.longitude = coords.lng()
        },
        createConference() {
            this.$emit('create', this.conference)
            this.conference = {
                title: '',
                date: '',
                latitude: '',
                longitude: '',
                country: ''
            }
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
        this.getCategories()
    }

}
</script>

<style scoped>
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
    margin: 20px 0 0;
    width: 85%;
    height: 350px;
    border: 2px solid teal;
}

.add_category {
    padding: 2px 5px;
    margin: 10% auto 5%;
    width: 100%;
}
</style>