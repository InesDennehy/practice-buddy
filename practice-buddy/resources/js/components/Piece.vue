<template>
    <div @mouseover="hover = true" @mouseleave="hover = false">
        <span>{{piece.name}}</span>
        <span v-if=hover v-on:click="remove" class="float-right align-middle">x</span>
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
