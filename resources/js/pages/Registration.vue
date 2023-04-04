<template>
   <div class="register">
        <v-main>
         <v-container fluid fill-height>
            <v-layout align-center>
               <v-flex>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Registration form</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text class=" d-flex">
                        <div>
                            <table>
                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="user.firstname"
                                        placeholder="Firstname"
                                        name="firstname"
                                        :rules="[rules.required, rules.min]"
                                        type="text"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                        v-model="user.lastname"
                                        :rules="[rules.required, rules.min]"
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
                                        :rules="[rules.required, rules.email]"
                                        name="email"
                                        type="email"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-select 
                                        v-model="user.type"
                                        placeholder="Choose a role"
                                        class="ml-15" name="type"
                                        :items="['Listener', 'Announcer']"
                                        :rules="[rules.required]"
                                    ></v-select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <v-text-field
                                        v-model="user.password"
                                        placeholder="Password"
                                        name="password"
                                        type="password"
                                        :rules="[rules.required, rules.password]"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                    v-model="user.password_confirmation"
                                        placeholder="Confirm password"
                                        class="ml-15"
                                        name="password_confirmation"
                                        type="password"
                                        :rules="[rules.required, user.password === user.password_confirmation || 'No confirm password']"
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
                                        :rules="[rules.required]"
                                    ></v-text-field>
                                </td>
                                <td>
                                    <v-text-field
                                        v-model="user.phone"
                                        placeholder="Phone"
                                        class="ml-15"
                                        name="phone"
                                        type="text"
                                        :rules="[rules.required, rules.phoneNumber]"
                                    ></v-text-field>
                                </td>
                            </tr>
                        </table>
                            <p v-if="formErrors" class="float-left mt-5 red--text">No correct data. All fields are required!</p>
                            <p class="float-right mt-5 red--text" v-if="dateError">Birthdate is required<v-icon>mdi-arrow-right-bold</v-icon></p>
                        </div>
                        <div class="ml-15">
                            <label>Date of Birth: </label>
                            <v-date-picker
                                class="mt-1"
                                v-model="user.birthdate"
                                :rules="[rules.required]"
                            ></v-date-picker>
                        
                        </div>
                           
                     </v-card-text>
                     <v-card-actions>
                        <router-link class="ml-5 mb-3" :to="{name: 'login'}">Already have account?</router-link>
                        <v-spacer></v-spacer>
                           <v-btn type="submit" @click.prevent="register" class="mr-5 mb-3" color="primary">Registration</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-main>
   </div>
</template>

<script>
export default {
    data: () => ({
        user: {
            firstname: '',
            lastname: '',
            email: '',
            password: '',
            password_confirmation: '',
            type: '',
            birthdate: '',
            country: '',
            phone: ''
        },
        rules: {
            min: v => v.length >= 2 || 'Min 2 characters',
            required: v => !!v || 'This field is required',
            email: v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'No correct Email',
            password: v => v.length >= 8 || 'Min 8 characters',
            phoneNumber: v => (!isNaN(parseFloat(v)) && v >= 0 && v <= 9999999999999) || 'No correct phone'
        },
        formErrors: false,
        dateError: false
    }),
    methods: {
      async register() {
        try {
            await this.$store.dispatch('user/registerUser', this.user)
            this.$router.push('/')
        } catch(e) {
            this.formErrors = true
            if(!this.user.birthdate) {
                this.dateError = true
            }
        }
      }
   }
}
</script>

<style scoped>
.register {
    width: 60%;
    margin: 3% auto 0;
}
</style>