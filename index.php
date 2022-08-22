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
                    <th>Reg. date</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="(user, index) in users">
                    <td v-text="user.id"></td>
                    <td v-text="user.name"></td>
                    <td v-text="user.email"></td>
                    <td v-text="user.reg_date"></td>
                    <td>
                        <button type="button" v-bind:data-id="user.id" v-on:click="showEditUserModal" class="btn btn-primary">Edit</button>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" tabindex="-1" aria-labelledby="User Edit" aria-hidden="true" data-bs-backdrop="static" id="editUserModal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="update.php" v-on:submit.prevent="doUpdate" id="form-edit-user" v-if="user != null">
                            <input type="hidden" name="id" v-bind:value="user.id" />
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" v-bind:value="user.name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" v-bind:value="user.email" class="form-control" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary" form="form-edit-user">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/assets/js/vue.global.js"></script>
    <script src="/public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/public/assets/js/popper.min.js"></script>
    <script src="/public/assets/bootstrap/js/bootstrap.js"></script>
    <script>
        // initialize Vue JS
        const {
            createApp
        } = Vue;
        createApp({
            // el: "#myApp",
            // data: {
            //     users: [],
            // },
            data() {
                return {
                    users: [],
                    user: null
                }
            },
            methods: {
                showEditUserModal: function() {
                    const id = event.target.getAttribute("data-id");
                    // get user from local array and save in current object
                    for (let a = 0; a < this.users.length; a++) {
                        if (this.users[a].id == id) {
                            this.user = this.users[a];
                            break;
                        }
                    }
                    $("#editUserModal").modal("show");
                },
                // get all users from database
                getData: function() {
                    const self = this;
                    const ajax = new XMLHttpRequest();
                    ajax.open("POST", "read.php", true);
                    ajax.onreadystatechange = function() {
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
                doCreate: function() {
                    const self = this;
                    const form = event.target;
                    const ajax = new XMLHttpRequest();
                    ajax.open("POST", form.getAttribute("action"), true);
                    ajax.onreadystatechange = function() {
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
            mounted: function() {
                this.getData();
            }
        }).mount("#myApp");
    </script>
</body>

</html>