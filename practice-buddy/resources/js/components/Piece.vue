<template>
    <div @mouseover="hover = true" @mouseleave="hover = false" v-bind:class="{ active: hover }" class="piece">
        <span class="piece-name">{{piece.name}}</span>
        <button v-on:click="remove" class="float-right x-btn">x</button>
    </div>
</template>

<script>
    export default {
        mounted() {},
        props: {
            piece: {
                type: Object,
                required: true,
            }
        },
        data(){
            return{
                hover : false,
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
        }
    }
</script>
