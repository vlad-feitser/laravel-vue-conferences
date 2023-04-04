<template>
    <div class="navbar">
        <router-link class="text-decoration-none black--text" :to="{name: 'conferences'}">Confrerence's App</router-link>

        <div class="navbar__btns">
            <router-link 
                v-if="getFavoritesLectures && getFavoritesLectures[0]" 
                class="text-decoration-none" 
                :to="{name: 'lectures.favorites', params: {id: getUser.id}}"
            >
            <v-badge color="green" :content="getFavoritesLectures.length <= 99 ? getFavoritesLectures.length : '99+'" offset-y="15" offset-x="27">
                <v-icon 
                    large 
                    class="mr-3"
                    color="teal"
                    >
                    mdi-star
                </v-icon>
            </v-badge>
                
        
            </router-link>

            
            
            <v-menu v-if="getUser">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="grey"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        class="mb-1"
                        >
                        {{getUser.firstname}}
                    </v-btn>
                    
                </template>
                <v-list>
                    <v-list-item><router-link class="text-decoration-none" :to="{name: 'user.profile', params: {id: getUser.id}}">Profile</router-link></v-list-item>
                    <v-list-item v-if="getToken"><button @click.prevent="logout">Logout</button></v-list-item>   
                </v-list>
            </v-menu>
            <button v-if="getUser && getUser.type === 'Admin'" @click="$router.push('/categories')" class="btn">Categories</button>
            <button @click="$router.push('/')" class="btn">Conferences</button>
            <button v-if="!getToken" @click="$router.push('/user/login')" class="btn" style="margin-left:10px">Login</button>
            <button v-if="!getToken" @click="$router.push('/user/register')" class="btn" style="margin-left:10px">Registration</button>
           
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    methods: {
        async logout() {
            await this.$store.dispatch('user/logout')
            this.$router.push('/')
        }
    },
    computed: {
        ...mapGetters({
            getToken: 'user/getToken',
            getUser: 'user/getUser',
            getFavoritesLectures: 'user/getFavoritesLectures'
        })
    }
}
</script>

<style scoped>
.navbar {
    height: 50px;
    background-color: lightgray;
    box-shadow: 2px 2px 4px gray;
    display: flex;
    align-items: center;
    padding: 0 15px;
}

.navbar__btns {
    margin-left: auto;
}

.btn {
    padding: 7px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
    border-radius: 5px;
}

.btn:hover {
    border: 1px solid black;
}
</style>