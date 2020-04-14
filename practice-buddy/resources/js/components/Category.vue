<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card category border-0 shadow">
                    <div class="card-header modal-header category-header">
                        <h3 class="card-title m-0 category-name font-weight-light">{{category.name}}</h3>
                        <button v-on:click="remove" class="btn btn-outline-danger float-right">Delete</button>
                    </div>
                    <div class="card-body">
                        <div v-for="(piece, index) in pieces" :key="index">
                            <piece :piece="piece" @remove="removePiece(index)" @changeSessionStatus="changeSessionStatus"></piece>
                        </div>
                        <button class="btn btn-outline-secondary add-piece-btn" v-if=!isChanging v-on:click="startChange">Add piece +</button>
                        <input  maxlength="255" v-if=isChanging autofocus
                            v-on:keyup.enter="addSubmit"
                            v-on:keyup.esc="stopChange"
                            @blur="stopChange"
                            v-model="newName"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        mounted(){
            axios.get("pieces/"+this.category.id).then((response) => {
                if(response.data.result = 'OK')
                    this.pieces = response.data.pieces;
                    this.$emit('addPieces', this.pieces.map(piece => piece.name));
            });
        },
        props: {
            category:{
                type: Object,
                required: true,
            }
        },
        data(){
            return{
                isChanging: false,
                newName: "",
                pieces: [],
            }
        },
        methods:{
            addSubmit: function(event){
                if(this.newName != ""){
                    axios.post("/pieces", {
                        piece_name: this.newName,
                        category: this.name})
                        .then((response)=>{
                            this.$emit('addPieces', [newName]);
                        });
                    this.newName = "";
                }
            },
            startChange: function(event){
                this.isChanging = true;
            },
            stopChange: function(event){
                this.isChanging = false;
            },
            removePiece: function(index){
                this.pieces.splice(index, 1);
            },
            remove: function(event){
                axios.delete("/categories/"+this.cat.id).then((response) =>{
                    if(response.data.result == 'ok'){
                        this.$emit('remove');
                    }
                });
            },
            changeSessionStatus: function(piece_id, session){
                this.pieces.find(object => object.id == piece_id).session = session;
            }
        },
    }
</script>
