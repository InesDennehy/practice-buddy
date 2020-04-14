<template>
    <div>
        <div v-for="(category,index) in categories" :key="index">
            <category :category="category" @remove="removeCategory(index)" @addPieces="addPieces"></category>
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
                                    v-model="newName"/>
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
        mounted(){/*
            axios.get("/categories").then((response) => {
                this.categories = response.data.categories;
            });*/
        },
        data(){
            return{
                isChanging: false,
                newName: "",
                categories: [],
            }
        },
        methods: {
            addSubmit: function(event){
                if(this.newName != ""){
                    axios.post("/categories", {category_name: this.newName}).then((response)=>{
                        if(response.data.status == 'OK'){
                            this.categories.push(this.newName);
                            this.$emit('addCategory', {category_name: this.newName,
                                piece_id: null,
                                piece_name: null,
                                session_id: null});
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
            },
            addPieces: function(pieces){
                this.$emit('addPieces', pieces);
            }
        }
    }
</script>
