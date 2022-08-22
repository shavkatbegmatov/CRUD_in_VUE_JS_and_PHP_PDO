<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link rel="stylesheet" type="text/css" href="/public/assets/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="/public/assets/css/style.css" />
    </head>
    <body>
        <div id="myApp">
            <div class="container">
                <h1 class="text-center">Create</h1>
                <div class="row">
                    <div class="offset-md-3 col-md-6">
                        <form method="POST" action="create.php" v-on:submit.prevent="doCreate">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" />
                            </div>
                            <input type="submit" value="Create User" class="btn btn-primary my" />
                        </form>
                    </div>
                </div>
                <h1 class="text-center">Read</h1>
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                    <tr v-for="(user, index) in users">
                        <td v-text="user.id"></td>
                        <td v-text="user.name"></td>
                        <td v-text="user.email"></td>
                    </tr>
                </table>
            </div>
        </div>
        <script src="/public/assets/vue.global.js"></script>
        <script src="/public/assets/jquery-3.6.0.min.js"></script>
        <script src="/public/assets/bootstrap/js/bootstrap.js"></script>
        <script>
            // initialize Vue JS
            const { createApp } = Vue;
            createApp({
                // el: "#myApp",
                // data: {
                //     users: [],
                // },
                data() {
                    return {
                        users: []
                    }
                },
                methods: {
                    // get all users from database
                    getData: function () {
                        const self = this;
                        const ajax = new XMLHttpRequest();
                        ajax.open("POST", "read.php", true);
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4) {
                                if (this.status == 200) {
                                    const users = JSON.parse(this.responseText);
                                    self.users = users;
                                }
                            }
                        };
                        const formData = new FormData();
                        ajax.send(formData);
                    },                    
                    doCreate: function () {
                        const self = this;
                        const form = event.target;
                        const ajax = new XMLHttpRequest();
                        ajax.open("POST", form.getAttribute("action"), true);
                        ajax.onreadystatechange = function () {
                            if (this.readyState == 4) {
                                if (this.status == 200) {
                                    // console.log(this.responseText);
                                    const user = JSON.parse(this.responseText);
                                    // prepend in local array
                                    self.users.unshift(user);
                                }
                            }
                        };
                        const formData = new FormData(form);
                        ajax.send(formData);
                    }
                },
                // call an AJAX to fetch data when Vue JS is mounted
                mounted: function () {
                    this.getData();
                }
            }).mount("#myApp");
        </script>
    </body>
</html>