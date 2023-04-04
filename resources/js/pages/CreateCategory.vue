<template>
    <div>

        <h1 class="text-center">Create / Edit Category Page</h1>


        <div>
            <div class="el">
                <h3 class="ml-5 mt-2 px-3 text-decoration-underline d-inline-block">All Categories</h3>
                <h4 class="ml-8 d-inline">Amount: {{categories.length}}</h4>

                <div class="category_item" v-for="item in categories" :key=item.id>
                    <p>{{item.name}}</p>
                    <v-btn @click="deleteCategory(item.id)" small color="error">Delete</v-btn>
                </div>
            </div>

            <div class="el">
                <h3 class="ml-5 mt-2 px-3 text-decoration-underline d-inline-block">All subcategories</h3>
                <h4 class="ml-8 d-inline">Amount: {{subcategories.length}}</h4>

                <div class="category_item" v-for="item in subcategories" :key=item.id>
                    <p>{{item.name}}</p>
                    <v-btn @click="deleteCategory(item.id)" small color="error">Delete</v-btn>
                </div>
            </div>

            <div class="el">
                <h3 class="text-center mt-2 text-decoration-underline">Add categories</h3>
                <v-text-field
                    class="add_category"
                    type="text"
                    name="name"
                    placeholder="Category name"
                    :rules="[rules.required, rules.min, rules.max]"
                    v-model="category.name"
                ></v-text-field>

                <v-select
                    class="add_category"
                    v-model="category.parent_category_id"
                    :items="categories"
                    item-text="name"
                    item-value="id"
                    placeholder="Select category for subcategory"
                ></v-select>

                <div class="reset">
                    <v-btn v-if="category.parent_category_id" color="primary" small @click="resetCategory">Reset Category</v-btn>
                </div>
                
                <button @click="addCategory" class="btn_add">Add</button>
            </div>
        </div>

        <v-btn @click="$router.push('/categories')" class="btn__back" color="primary">Go Back</v-btn>
    </div>    
</template>

<script>

export default {
    data: () => ({
        category: {
            name: '',
            parent_category_id: ''
        },
        categories: [],
        subcategories: [],
        rules: {
            min: v => v.length >= 2 || 'Min 2 characters',
            max: v => v.length <= 255 || 'Max 255 characters',
            required: v => !!v || 'This field is required for Add',
        }
    }),
    methods: {
        async getCategories() {
            await axios.get('/api/categories/edit')
            .then(response => {
                this.categories = response.data.categories
                this.subcategories = response.data.subcategories
            })
        },
        async addCategory() {
            await axios.post('/api/categories', this.category)
            .then(response => {
                if(response.status === 201) {
                    this.getCategories()
                    this.category.name = ''
                    this.category.parent_category_id = ''
                }
            })
        },
        async deleteCategory(id) {
            await axios.delete('/api/categories/' + id)
            this.getCategories()
        },
        resetCategory() {
            this.category.parent_category_id = ''
        }
    },
    mounted() {
        this.getCategories()
    }
}
</script>

<style scoped>
.add_category {
    padding: 2px 5px;
    margin: 10% auto 5%;
    width: 80%;
}

.category_item {
    margin: 2% 3%;
    padding: 10px;
    border: 1px solid teal;
    word-wrap: break-word;
}

.btn_add {
    color: black;
    border: 2px solid teal;
    padding: 4px 25px;
    border-radius: 25px;
    display: flex;
    margin: 10% auto;
}

.btn_add:hover {
    background: teal;
    border: 1px solid teal;
    color: white;
}

.el {
    margin-top: 2%;
    float: left;
    height: 400px;
    width: 25%;
    margin-left: 6.5%;
    border: 1px solid teal;
    overflow-y: auto;
}

.btn__back {
    position: fixed;
    float: right;
    bottom: 20px;
    right: 20px;
}

.reset {
    text-align: center;
}
</style>