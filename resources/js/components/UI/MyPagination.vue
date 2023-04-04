<!-- <template>
    <v-pagination 
        v-model="currentPage" 
        :length="lastPage"
        :total-visible="8"
    ></v-pagination>
</template>

<script>
import { mapGetters,mapMutations } from 'vuex';
export default {
    props: ['store', 'collection'],
    name: 'my-pagination',
    computed: {
        ...mapGetters({
            getConferences: 'conference/getConferences',
        }),
        currentPage: {
            get() {
                return this.$store.state[this.store][this.collection].currentPage;
            },
            set(value) {
                this.$store.commit(this.store + '/setCurrentPage', value)
            }
        },
        lastPage: {
            get() {
                return this.$store.state[this.store][this.collection].last_page;
            }
        }
    },
    methods: {
    ...mapMutations({
        setConferences: 'conference/setConferences',
        setCurrentPage: 'conference/setCurrentPage'
    }),
    }
}
</script>

<style scoped>

</style> -->