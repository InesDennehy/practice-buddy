<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{category_name}}</div>
                    <div class="card-body">
                        <div>Here goes some pieces</div>
                        <div v-for="piece in initial_pieces" :key="piece">
                            {{piece}}
                        </div>
                        <button v-if=!isChanging v-on:click="addNew">Add piece +</button>
                        <input  v-if=isChanging autofocus
                            v-on:keyup.enter="addSubmit"
                            v-on:keyup.esc="stopChange"
                            v-model="newName"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
            console.log('component mounted');
        },
        props: {
            category_name: {
                type:String,
                required:true,
            },
            initial_pieces: {
                type: Array,
                required: true,
            }
        },
        data(){
            return{
                isChanging: false,
                newName: "",
            }
        },
        methods:{
            addNew: function(event){
                this.isChanging = true;
            },
            addSubmit: function(event){
                this.initial_pieces.push(this.newName);
                this.newName = "";
            },
            stopChange: function(event){
                this.isChanging = false;
            },
        }
    }
</script>
