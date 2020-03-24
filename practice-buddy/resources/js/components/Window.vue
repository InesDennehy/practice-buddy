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
            <Home v-show="active == 'home'" :data="data"></Home>
            <Stats v-if="active == 'stats'" :all_pieces="piece_names"></Stats>
        </main>
    </div>
</template>

<script>
    export default {
        mounted() {
            if(localStorage.data)
                this.data = JSON.parse(localStorage.data);
            else
                axios.get("/categories").then((response)=>{
                    this.data = response.data.data;
                    localStorage.data = JSON.stringify(this.data);
                });

            this.piece_names = [...new Set(this.data.map(item => item.piece_name))];
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
