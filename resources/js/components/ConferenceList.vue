<template>
    <div>
        <div v-if="conferences">
            <h3>Conferences List</h3>
            <conference-item 
            v-for="conference in conferences" 
            :key="conference.id" 
            :conference="conference" 
            @remove="$emit('remove', conference.id)"
            @addLecture="$emit('addLecture', conference.id)"
            />
            
        </div>

        <h2 v-else style="color: red;">List of conferences is empty</h2>
    </div>

    
</template>

<script>
import ConferenceItem from "./ConferenceItem.vue"
export default {
    components: {
        ConferenceItem
    },
    props: {
        conferences: []
    }
}
</script>

<style scoped>

</style>