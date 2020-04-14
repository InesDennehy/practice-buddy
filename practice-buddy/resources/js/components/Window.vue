<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel sticky-top">
            <div class="container">
                <a class="navbar-brand" href="/home">
                    PracticeBuddy
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="#" v-on:click="activateHome">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" v-on:click="activateStats">Stats</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{username}}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" :href="logout_route"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <Home v-show="active == 'home'" v-bind:data="data"
                @changeSessionStatus="changeSessionStatus"
                @addPiece="addPiece"></Home>
            <Stats v-if="active == 'stats'" :all_pieces="piece_names"></Stats>
        </main>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get("/categories").then((response)=>{
                this.data = response.data.data;
            });
        },
        watch: {
            data: function(newVal, oldVal) { // watch it
                var filtered = this.data.filter(item => item.piece_name != null);
                this.piece_names = [...new Set(filtered.map(item => item.piece_name))];
            }
        },
        props:{
            username: {
                type: String,
                required: true,
            },
            logout_route: {
                type: String,
                required: true,
            }
        },

        data(){
            return{
                active: "home",
                data: [],
                piece_names: [],
            }
        },
        methods: {
            changeSessionStatus: function(pieceid, session){
                this.data.find(object => object.piece_id == pieceid).session_id = session;
            },
            addPiece: function(piece){
                this.data.push(piece);
            },
            activateHome: function(event){
                event.preventDefault();
                this.active = "home";
                return;
            },
            activateStats: function(event){
                event.preventDefault();
                this.active = "stats";
                return;
            }
        }
    }
</script>
