<template>
   <div class="login">
      <v-main>
         <v-container fluid fill-height>
            <v-layout align-center justify-center>
               <v-flex xs12 sm8 md4>
                  <v-card class="elevation-12">
                     <v-toolbar dark color="primary">
                        <v-toolbar-title>Login form</v-toolbar-title>
                     </v-toolbar>
                     <v-card-text>
                        <v-form>
                           <p v-if="formErrors" class="red--text">No correct data..</p>
                           <v-text-field
                              v-model="user.email"
                              :rules="emailRules"
                              placeholder="Email"
                              name="email"
                              type="email"
                              required
                           ></v-text-field>
                           <v-text-field
                              v-model="user.password"
                              placeholder="Password"
                              name="password"
                              type="password"
                              :rules="[rules.required, rules.min]"
                              required
                           ></v-text-field>
                        </v-form>
                     </v-card-text>
                     <v-card-actions>
                        <router-link class="ml-5 mb-3" :to="{name: 'register'}">Don't have account?</router-link>
                        <v-spacer></v-spacer>
                           <v-btn @click.prevent="login" class="mr-5 mb-3" type="submit" color="primary">Login</v-btn>
                     </v-card-actions>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-main>
   </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
   data: () => ({
      user: {
         email: '',
         password: ''
      },
      rules: {
         min: v => v.length >= 8 || 'Min 8 characters',
         required: v => !!v || 'This field is required'
      },
      emailRules: [
         v => !!v || 'This field is required',
         v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'No correct Email',
      ],
      formErrors: false
   }),
   methods: {
      ...mapActions ({
         loginUser: 'user/loginUser'
      }),
      async login() {
         try {
            await this.loginUser(this.user)
            this.$router.push('/')
         } catch(e) {
            this.formErrors = true
         }
      }
   }
}
</script>

<style scoped>
.login {
  margin-top: 5%;
}
</style>