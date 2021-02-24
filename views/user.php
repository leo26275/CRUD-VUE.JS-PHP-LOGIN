<?php 
    session_start();
?>

<?php
    if (!isset($_SESSION['user'])) {
        ?>
        <script>
            (function () {
                window.location = '../index.php';
            })();
        </script>
<?php
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link  rel="icon"   href="../public/images/leo.jpg" type="image/jpg" />
    <title>Home Work</title>
</head>
<style>
a {
    color: #FCF8F7;
}
</style>
   <style type="text/css">
        #overlay{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgb(0, 0, 0,0.6);
        }
    </style>
<body>
    <div class="container-fluid">
        <div id="app">
            <div class="row bg-dark">
                <div class="col-lg-6">
                    <p class="text-light display-4 pt-2" style="font-size: 25px;">Welcome to Leo's homework</p>
                </div>
                <div class="col-lg-6 text-right">
                    <p class="text-light display-4 pt-2" style="font-size: 20px;"> <a href="close.php"> Log Out </a>
                    </p>
                </div>
            </div>

            <div class="container">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <h3 class="div text-info">User list</h3>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-info float-right" @click="showAddModal=true; clearMsg();">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;Add new User
                        </button>
                    </div>
                </div>
                <hr>
                    <div class="alert alert-danger" role="alert" v-if="errorMsg">
                    {{errorMsg}}
                    </div>
                    <div class="alert alert-success" role="alert" v-if="successMsg">
                    {{successMsg}}
                    </div>
                <div class="row">

                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center bg-info text-light">
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Estatus</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td class="text-center">{{user.user}}</td>
                                    <td class="text-center">{{user.email}}</td>
                                    <td v-if="user.state == 1" class="text-center"><span class="badge badge-info">Active</span></td>
                                    <td v-else class="text-center"><span class="badge badge-danger">Inactive</span></td>
                                    <td style="text-align: center;">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-dark" title="Editar"  @click="showEditModal=true; selectUser(user);  clearMsg();"><i class="fa fa-pen"></i></i></button>
                                            &nbsp;


                                            <button v-if="user.state == 0" class="btn btn-info" title="Activate" @click="showinactivateModal=true; selectUser(user);  clearMsg();"><i
                                                    class="fa fa-check"></i></button>

                                            <button v-else class="btn btn-danger" title="Deactivate" @click="showActivateModal=true; selectUser(user);  clearMsg();"><i
                                                    class="fa fa-times"></i></button>                                                    
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <footer>
                       <div class="pull-right">
                           Home Work - Universidad de El Salvador
                       </div>
                       <div class="clearfix"></div>
                    </footer>
                </div>
            </div>
             <!-- Add New User Model-->
            <div id="overlay" v-if="showAddModal"> 
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New User</h5>
                            <button type="button" class="close" @click="showAddModal=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="#" method="post">
                                <div class="form-group">
                                  <small style="color: red">User must be unique</small>
                                  <input type="text" name="user" class="form-control form-control-lg" placeholder="User" aria-describedby="helpId" v-model="newUser.user"> 
                                  <small style="color: red" v-if="userRequired">Required field</small>
                                </div>
                                <div class="form-group">
                                  <input type="password" name="password" class="form-control form-control-lg" placeholder="password" aria-describedby="helpId" v-model="newUser.password">
                                  <small style="color: red"  v-if="passwordRequired">Required field</small>
                                </div>
                                <div class="form-group">
                                  <small style="color: red">Email must be unique</small>
                                  <input type="email" name="email" class="form-control form-control-lg" placeholder="E-mail" aria-describedby="helpId" v-model="newUser.email">
                                  <small style="color: red"  v-if="emailRequired">Required field</small>
                                  <small style="color: red"  v-if="invaleImail">Enter a valid email</small>
                                </div>   
                            </form>
                             <div class="form-group">
                                  <button class="btn btn-info btn-block btn-lg" @click="validateAdd();">Add new User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit  User Model-->
        <div id="overlay" v-if="showEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" @click="showEditModal=false">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="post">
                            <div class="form-group">
                              <input type="text" name="user" class="form-control form-control-lg" placeholder="Name" 
                              aria-describedby="helpId" v-model="correntUser.user">
                            </div>
                            <div class="form-group">
                              <input type="password" name="email" class="form-control form-control-lg" placeholder="E-mail" 
                              aria-describedby="helpId" v-model="correntUser.password">
                            </div>
                            <div class="form-group">
                              <input type="email" name="phone" class="form-control form-control-lg" placeholder="Phone" 
                              aria-describedby="helpId" v-model="correntUser.email">
                            </div>
                        </form>
                        <div class="form-group">
                              <button class="btn btn-info btn-block btn-lg" @click="showEditModal=false; updateUser();">Edit User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
     <!-- Delete  User Model-->
         <div id="overlay" v-if="showinactivateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Activate user</h5>
                        <button type="button" class="close" @click="showinactivateModal=false">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <h4 class="text-danger">Are you sure you want to activate this user?</h4>
                        <h5>You are activating: {{correntUser.user}}</h5>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-danger btn-lg float-rigth" @click="showinactivateModal=false;  inactivateUser();">Yes</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-success btn-lg float-rigth" @click="showinactivateModal=false">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Delete  User Model-->
         <div id="overlay" v-if="showActivateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Deactivate  User</h5>
                        <button type="button" class="close" @click="showActivateModal=false">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <h4 class="text-danger">re you sure you want to deactivate this user?</h4>
                        <h5>You are deactivating: {{correntUser.user}}</h5>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-danger btn-lg float-rigth" @click="showActivateModal=false;  activateUser();">Yes</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-success btn-lg float-rigth" @click="showActivateModal=false">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insert  User Model-->
         <div id="overlay" v-if="showInsertModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Welcome</h5>
                        <button type="button" class="close" @click="showInsertModal=false">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <?php
                            $user = $_SESSION['user'];
                        ?>
                        <h4 class="text-info">Welcome <?php echo $user[1] ?>!</h4>

                        <img src="../public/images/bienvenido.png">
                        <h5>to Leo's homework</h5>
                        <hr>
                        <div>
                            <button class="btn btn-info btn-lg float-rigth" @click="showInsertModal=false;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
</body> 
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<script>

    var url = "../models/UserModel.php?action=";

    var app = new Vue({
        el: '#app',
        data: {
            errorMsg: "",
            successMsg: "",
            users: [],
            showAddModal: false,
            showEditModal: false,
            showinactivateModal: false,
            showActivateModal: false,
            showInsertModal: true,
            userRequired: false,
            passwordRequired: false,
            emailRequired: false,
            invaleImail: false,
            newUser: {user: "", password: "", email: ""},
            correntUser: {},
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
        },
        mounted: function() {
            this.getAllUsers();
        },
        methods: {
            getAllUsers() {
                axios.get(url.concat("read")).then(function(response) {
                    if (response.data.error) {
                        app.errorMsg = response.data.message;
                    } else {
                        app.users = response.data.users;
                    }
                });
            },
            addUser(){
                var formData = app.toFormData(app.newUser);
                axios.post(url.concat("create"), formData).then(function(response){
                    
                    app.newUser = {user: "", password: "", email: ""};

                    if(response.data.error){
                        app.errorMsg = response.data.message;
                    }else{
                        app.successMsg = response.data.message;
                        app.getAllUsers();
                    }
                });
            },
            updateUser(){
                var formData = app.toFormData(app.correntUser);
                axios.post(url.concat("update"), formData).then(function(response){
                    
                    app.correntUser = {};

                    if(response.data.error){
                        app.errorMsg = response.data.message;
                    }else{
                        app.successMsg = response.data.message;
                        app.getAllUsers();
                    }
                });
            },
            activateUser(){
                var formData = app.toFormData(app.correntUser);
                axios.post(url.concat("activate"), formData).then(function(response){
                    
                    app.correntUser = {};

                    if(response.data.error){
                        app.errorMsg = response.data.message;
                    }else{
                        app.successMsg = response.data.message;
                        app.getAllUsers();
                    }
                });
            },
            inactivateUser(){
                var formData = app.toFormData(app.correntUser);
                axios.post(url.concat("inactivate"), formData).then(function(response){
                    
                    app.correntUser = {};

                    if(response.data.error){
                        app.errorMsg = response.data.message;
                    }else{
                        app.successMsg = response.data.message;
                        app.getAllUsers();
                    }
                });
            },
            validateAdd(){
                if (app.newUser.user.length == 0) {
                    app.userRequired = true;
                    app.passwordRequired = false;
                    app.emailRequired = false;
                    app.invaleImail = false;
                }else if (app.newUser.password.length == 0) {
                    app.passwordRequired = true;
                    app.userRequired = false;
                    app.emailRequired = false;
                    app.invaleImail = false;
                }else if (app.newUser.email.length == 0) {
                    app.emailRequired = true;
                    app.userRequired = false;
                    app.passwordRequired = false;
                    app.invaleImail = false;
                }else if (!app.reg.test(app.newUser.email)){
                    app.invaleImail = true;
                    app.emailRequired = false;
                    app.userRequired = false;
                    app.passwordRequired = false;
                }else {
                    app.addUser();
                    app.showAddModal=false;
                }
            },
            toFormData(obj){
                var fd = new FormData();
                for (var i in obj){
                    fd.append(i,obj[i]);
                }
                return fd;
            },
            selectUser(user){
                app.correntUser = user;
            },
            clearMsg(){
                app.errorMsg = "";
                app.successMsg = "";
            }
        }
    });
</script>
 
</html>