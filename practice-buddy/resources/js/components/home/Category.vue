<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card category border-0 shadow">
                    <div class="card-header modal-header category-header">
                        <h3 class="card-title m-0 category-name font-weight-light">{{category.name}}</h3>

                        <div class="dropdown">
                            <button
                                class="btn btn-primary float-right"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Delete</button>

                            <div class="dropdown-menu dropdown-menu-right p-3">
                                <div class="mb-3">Are you sure you want to delete this category?</div>
                                <div class="text-center">
                                <button v-on:click="remove" class="btn btn-sm btn-outline-danger float-center">Delete anyways</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div v-for="(piece, index) in pieces" :key="index">
                            <piece :piece="piece" @remove="removePiece(index)" @changeSessionStatus="changeSessionStatus"></piece>
                        </div>
                        <button class="btn btn-outline-primary add-piece-btn" v-if=!isChanging v-on:click="startChange">Add piece +</button>
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
                        category: this.category.name})
                        .then((response)=>{
                            if(response.data.status == 'OK'){
                                this.pieces.push({category_id: response.data.piece.category_id,
                                    id:response.data.piece.id,
                                    name:response.data.piece.name,
                                    session: null});
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
            removePiece: function(index){
                this.pieces.splice(index, 1);
            },
            remove: function(event){
                axios.delete("/categories/"+this.category.id).then((response) =>{
                    if(response.data.result == 'ok'){
                        this.pieces = [];
                        this.$el.parentNode.removeChild(this.$el);
                    }
                });
            },
            changeSessionStatus: function(piece_id, session){
                this.pieces.find(object => object.id == piece_id).session = session;
            }
        },
    }
</script>
