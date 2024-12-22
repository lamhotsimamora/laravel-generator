<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home - Laravel Generator Backend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.rawgit.com/jprichardson/string.js/master/dist/string.min.js"></script>

</head>

<body>
    <br><br>
    <div class="container" id="app">

        <div class="alert alert-primary" role="alert">
            A Simple Laravel Generator ( version 10 )
        </div>
          

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">File Project</span>
            <input type="text" v-model="file_project" ref="file_project" class="form-control" placeholder="C:\Your-Project" aria-label="Username"
                aria-describedby="basic-addon1">
        </div>

        <hr>

        Select Database : 
        <select @change="loadTables" v-model="database_selected" class="form-select" aria-label="Default select example">
           <option v-for="data in databases" :value="data.Database">@{{data.Database}}</option>
        </select>
        <br>
        Select Table : 
        <select class="form-select" @change="loadFields" v-model="table_selected" aria-label="Default select example">
           <option v-for="data in tables" :value="data.table">@{{data.table}}</option>
        </select>
        <br>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Model</span>
            <input type="text" class="form-control" v-model="model_name" ref="model_name" placeholder="Model Name" aria-label="Username" aria-describedby="basic-addon1">
         </div>
         <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Controller</span>
            <input type="text" class="form-control" v-model="controller_name" ref="controller_name" placeholder="Controller Name" aria-label="Username" aria-describedby="basic-addon1">
         </div>
          

        <hr>
        <button @click="generate" type="button" class="btn btn-primary">Generate</button>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const _TOKEN_ = "<?= csrf_token() ?>";
        new Vue({
            el : "#app",
            data : {
                file_project : null,
                databases : null,
                tables : null,
                database_selected : null,
                model_name : null,
                controller_name :  null,
                table_selected :  null
            },
            methods: {
                loadFields : function(){
                     this.model_name = this.table_selected;
                     const controller_ = 'Controller';
                     
                     this.controller_name = S(this.table_selected).capitalize().s+controller_;
                },
                generate: function(){
                    if (this.file_project==null){
                        this.$refs.file_project.focus()
                        return;
                    }
                },
                loadTables : function(){
                    const $this = this;
                    axios.post('/load-table', {
                            _token: _TOKEN_,
                            database : this.database_selected
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.tables = obj;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadDatabase : function(){
                    const $this = this;
                    axios.post('/load-database', {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.databases = obj;
                            
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
            mounted() {
                this.loadDatabase()
            },
        })
    </script>
</body>

</html>
