<template>
    <div class="profile">
        <v-main>
         <v-container fluid fill-height>
            <v-layout align-center>
               <v-flex>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Edit Profile</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text class=" d-flex">
                        <div><table>
                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="user.firstname"
                                        placeholder="Firstname"
                                        name="firstname"
                                        type="text"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                        v-model="user.lastname"
                                        placeholder="Lastname"
                                        class="ml-15"
                                        name="lastname"
                                        type="text"
                                    ></v-text-field>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="user.email"
                                        placeholder="Email"
                                        name="email"
                                        type="email"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                        v-model="user.phone"
                                        placeholder="Phone"
                                        class="ml-15"
                                        name="phone"
                                        type="text"
                                    ></v-text-field>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="user.country"
                                        placeholder="Country"
                                        name="country"
                                        type="text"
                                    ></v-text-field>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="new_password"
                                        placeholder="New Password"
                                        name="new_password"
                                        type="password"
                                        :rules="[rules.min]"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                    v-model="confirm_new_password"
                                        placeholder="Confirm New Password"
                                        class="ml-15"
                                        name="password_confirmation"
                                        type="password"
                                        :rules="[new_password === confirm_new_password || 'No confirm password']"
                                    ></v-text-field>
                                </td>
                            </tr>
                        </table></div>
                        <div class="ml-15">
        <v-date-picker v-model="user.birthdate"></v-date-picker></div>
                           
                     </v-card-text>
                     <v-card-actions>
                        <v-spacer></v-spacer>
                           <v-btn type="submit" @click.prevent="updateUser" class="mr-5 mb-3" color="primary">Update</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-main>
    </div>    
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    data: () => ({
        user: [],
        new_password: '',
        confirm_new_password: '',
        rules: {
          min: v => v.length >= 8 || 'Min 8 characters',
        },
    }),
    methods: {
        ...mapMutations({
            setUser: 'user/setUser'
        }),
        async getUser(id) {
            await axios.get('/api/users/' + id)
            .then(res => {
                this.user = res.data
            })
        },
        async updateUser() {
            if(!this.new_password) {
                await axios.put('/api/users/' + this.user.id, this.user)
                .then(res => {
                    if(res.status === 200) {
                        this.setUser(res.data)
                        localStorage.setItem("user", JSON.stringify(res.data))
                        this.$router.push('/')
                    }
                })
            } else if(this.new_password && this.new_password === this.confirm_new_password) {
                this.user.password = this.new_password
                await axios.put('/api/users/' + this.user.id, this.user)
                .then(res => {
                    if(res.status === 200) {
                        this.setUser(res.data)
                        localStorage.setItem("user", JSON.stringify(res.data))
                        this.$router.push('/')
                    }
                })
            }
        }
    },
    mounted() {
        this.getUser(this.$route.params.id)
    },
    computed: {

    },
}
</script>

<style scoped>
.profile {
    width: 60%;
    margin: 3% auto 0;
}

</style>