<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card category">
                    <div class="card-header modal-header category-header">
                        <h4 class="card-title m-0 category-name">{{cat.name}}</h4>
                        <button v-on:click="remove" class="btn btn-outline-danger float-right">Delete</button>
                    </div>
                    <div class="card-body">
                        <div v-for="(piece, index) in pieces" :key="piece.id">
                            <piece :piece="piece" @remove="removePiece(index)"></piece>
                        </div>
                        <button class="btn btn-outline-secondary" v-if=!isChanging v-on:click="startChange">Add piece +</button>
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
            this.getPieces();
        },
        props: {
            cat: {
                type:Object,
                required:true,
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
                        category: this.cat,})
                        .then((response)=>{
                            var piece = response.data.piece;
                            this.pieces.push(piece);
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
            getPieces: function(){
                axios.get("/pieces/"+this.cat.id).then((response)=>{
                    this.pieces = response.data.pieces;
                });
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
            }
        },
    }
</script>
