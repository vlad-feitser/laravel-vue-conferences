import Vue from 'vue'
import Vuex from "vuex"
import {conferenceModule} from './conferenceModule'
import {userModule} from './userModule'
import {lectureModule} from './lectureModel'

Vue.use(Vuex)


export default new Vuex.Store({
    modules: {
        conference: conferenceModule,
        user: userModule,
        lecture: lectureModule
    }
})