<template>
    <div @mouseover="hover = true" @mouseleave="hover = false" v-bind:class="{ active: hover }" class="piece">
        <input type="checkbox" :id="'checkbox'+piece.id" class="done-checkbox" v-on:click="done" v-model="checked"/>
        <label class="piece-name lead" :for="'checkbox'+piece.id" v-bind:class="{crossedout: checked}">{{piece.name}}</label>
        <button v-on:click="remove" class="float-right x-btn">x</button>
    </div>
</template>

<script>
    export default {
        mounted() {
        },

        props: {
            piece: {
                type: Object,
                required: true,
            },
            initial_session: {
                required:true,
            }
        },
        data(){
            return{
                hover : false,
                checked: this.initial_session != null ,
                session: this.initial_session,
            }
        },
        methods: {
            remove: function(event){
                axios.delete("/pieces/"+this.piece.id).then((response) =>{
                    if(response.data.result == 'ok'){
                        this.$emit('remove');
                    }
                });
            },
            done: function(event){
                if(this.checked){
                    axios.delete("/sessions/"+this.session).then((response) =>{
                        if(response.data.result == 'OK'){
                            this.checked = false;
                        }
                    });
                }else{
                    axios.post("/sessions", {piece: this.piece.id}).then((response)=>{
                        if(response.data.result == 'OK'){
                            this.checked = true;
                            this.session = response.data.session;
                        }
                    });
                };
            },
        }
    }
</script>
