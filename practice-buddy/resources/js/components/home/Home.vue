<template>
    <div>
        <div v-for="(category,index) in categories" :key="index">
            <category :category="category" @remove="removeCategory(index)"></category>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-secondary" v-if="!isChanging" v-on:click="startChange">Add new Category +</button>
            <div v-if="isChanging" class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <input maxlength="255" v-if=isChanging autofocus
                                    v-on:keyup.enter="addSubmit"
                                    v-on:keyup.esc="stopChange"
                                    @blur="stopChange"
                                    v-model="newName"
                                    v-bind:class="{input_error: exists_error}"/>
                                <div v-if="exists_error" style="color: #d9534f">
                                    Can't create another category with same name</div>
                            </div>
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
            axios.get("/categories").then((response) => {
                this.categories = response.data.categories;
            });
        },
        data(){
            return{
                isChanging: false,
                newName: "",
                categories: [],
                exists_error: false,
            }
        },
        methods: {
            addSubmit: function(event){
                this.exists_error = this.categories.map(item => item.name).includes(this.newName);
                console.log(this.exists_error);
                if(this.newName != "" && !this.exists_error){
                    axios.post("/categories", {category_name: this.newName}).then((response)=>{
                        if(response.data.status == 'OK'){
                            this.categories.push({id: response.data.category.id, name: response.data.category.name});
                        }
                        this.newName = "";
                    });
                }
            },
            startChange: function(event){
                this.isChanging = true;
            },
            stopChange: function(event){
                this.isChanging = false;
            },
            removeCategory: function(index){
                this.categories.splice(index, 1);
            }
        }
    }
</script>
