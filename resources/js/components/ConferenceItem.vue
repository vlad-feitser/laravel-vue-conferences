<template>
    <div>
        <div class="conference">
            <div>
                <div><strong>Title: </strong>{{conference.title}}</div>
                <div><strong>Date: </strong>{{(new Date(conference.date)).toLocaleDateString()}}</div>
            </div>
            <div class="conference_btns">
                <button v-if="this.getUser === null || this.getUser.type !== 'Admin' && !filterConference" @click="joinToConference(conference.id)" class="btn info white--text">Join</button>
                <div v-if="this.getUser && this.getUser.type !== 'Admin' && filterConference" class="fb-share-button d-inline-block" data-href="http://127.0.0.1:8000/" data-layout="button" data-size="small" ><a target="_blank" 
                    href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Ffeitser-ve.groupbwt.com&amp;src=sdkpreparse" 
                    class="fb-xfbml-parse-ignore"><i class="fa-brands fa-2x fa-facebook"></i></a>
                </div>
                <a 
                    v-if="this.getUser && this.getUser.type !== 'Admin' && filterConference"
                    href="http://twitter.com/share?&url=%0Ahttp%3A%2F%2Ffeitser-ve.groupbwt.com&text=Check out this Meetup with SoCal AngularJS!"
                    onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                    <i class="fa-brands fa-2x fa-twitter ml-3"></i>
                </a>
                <button v-if="this.getUser && this.getUser.type === 'Announcer' && filterConference" class="btn" @click="$emit('addLecture', conference.id)">Add lecture</button>
                <button v-if="this.getUser && this.getUser.type !== 'Admin' && filterConference" @click="unjoinFromConference(conference.id)" class="btn danger">Unjoin</button>
                <button class="btn primary"><router-link class="link" :to="{name: 'conferences.show', params: {id: conference.id}}">Details</router-link></button>
                <button v-if="this.getUser && this.getUser.type === 'Admin'" class="btn danger" @click="$emit('remove', conference.id)">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    props: {
        conference: {
            type: Object,
            required: true
        }
    },

    methods: {
        ...mapActions({
            join: 'user/join',
            unjoin: 'user/unjoin',
            deleteFavorite: 'user/deleteFavorite'
        }),
        joinToConference(id) {
            if(this.getUser && this.getUser.type === 'Announcer') {
                this.join(id)
            }
            else if(this.getUser) {
                this.join(id)
            } else {
                this.$router.push('/user/register')
            }
        },
        async unjoinFromConference(id) {
            await axios.get('/api/lectures/' + id + '/show')
                .then(res => {
                    if(res.data) {
                        var lectures = res.data.lectures
                        lectures.forEach(el => {
                            this.deleteFavorite(el.id)
                        });
                    } else {
                        console.log('error')
                    }
                })
            this.unjoin(id)
        }
    },
    computed: {
        ...mapGetters({
            getUser: 'user/getUser',
            getJoinedConferences: 'user/getJoinedConferences'
        }),
        filterConference() {
            let filter = this.getJoinedConferences.filter(e => e.id === this.conference.id)
            if(filter.length) {
                return true
            }
            return false
        },
    }
}
</script>

<style scoped>
.conference {
    padding: 15px;
    border: 2px solid teal;
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.btn {
    padding: 7px 15px;
    background: none;
    color: teal;
    border: 1px solid teal;
    margin-left: 15px;
}

.primary {
    background-color: rgb(68, 9, 245);
    color: white;
}

.danger {
    background-color: rgb(229, 15, 15);
    color: white;
}

.link {
    text-decoration: none;
    color: white;
}
</style>