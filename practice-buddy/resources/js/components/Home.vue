<template>
    <div>
        <div v-for="(category,index) in categories" :key="index">
            <category :name="category" v-bind:pieces="pieces(category)"
                @remove="removeCategory(index)"
                @changeSessionStatus="changeSessionStatus"
                @addPiece="addPiece"></category>
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
        watch: {
            data: function(newVal, oldVal) { // watch it
                this.categories = [...new Set(this.data.map(item => item.category_name))];
            }
        },
        props:{
            data: {
                type: Array,
                required: true,
            }
        },
        data(){
            return{
                isChanging: false,
                newName: "",
                categories: [],
            }
        },
        methods: {
            pieces: function(name){
                return this.data.filter(function(piece) {
                        return piece.category_name == name;
                    });
            },
            addSubmit: function(event){
                if(this.newName != ""){
                    axios.post("/categories", {category_name: this.newName}).then((response)=>{
                        if(response.data.status == 'OK'){
                            this.categories.push(this.newName);
                            this.$emit('addPiece', {category_name: this.newName,
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
            changeSessionStatus: function(pieceid, session){
                this.$emit('changeSessionStatus', pieceid, session);
            },
            addPiece: function(piece){
                this.$emit('addPiece', piece);
            }
        }
    }
</script>
