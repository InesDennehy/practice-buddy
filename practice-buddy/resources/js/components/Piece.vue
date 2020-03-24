<template>
    <div @mouseover="hover = true" @mouseleave="hover = false" v-bind:class="{ active: hover }" class="piece">
        <input type="checkbox" :id="'checkbox'+piece_id" class="done-checkbox" v-on:click="done" v-model="checked"/>
        <label class="piece-name lead" :for="'checkbox'+piece_id" v-bind:class="{crossedout: checked}">{{name}}</label>
        <button v-on:click="remove" class="float-right x-btn">x</button>
    </div>
</template>

<script>
    export default {
        watch:{
            session: function(newVal, oldVal){
                this.checked = newVal != null;
            }
        },
        props: {
            name: {
                type: String,
                required: true,
            },
            piece_id: {
                required: true,
            },
            session: {
                required:true,
            }
        },
        data(){
            return{
                hover : false,
                checked: this.session != null,
            }
        },
        methods: {
            remove: function(event){
                axios.delete("/pieces/"+this.piece_id).then((response) =>{
                    if(response.data.result == 'ok'){
                        this.$emit('remove');
                    }
                });
            },
            done: function(event){
                if(this.checked){
                    axios.delete("/sessions/"+this.session).then((response) =>{
                        if(response.data.result == 'OK'){
                            this.$emit('changeSessionStatus', this.piece_id, null);
                        }
                    });
                }else{
                    axios.post("/sessions", {piece: this.piece_id}).then((response)=>{
                        if(response.data.result == 'OK'){
                            this.$emit('changeSessionStatus', this.piece_id, response.data.session);
                        }
                    });
                };
            },
        }
    }
</script>
