<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="public/login.css">
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link  rel="icon"   href="public/images/leo.jpg" type="image/jpg" />
    <title>Home Work</title>
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <img src="public/images/leo.jpg" id="icon" alt="User Icon" />
            </div>
            <div id="app">
                <form>
                    <div class="alert alert-danger" role="alert" v-if="errorMsg">
                        {{errorMsg}}
                    </div>
                    <input v-model="newLogin.user" type="text" id="login" class="fadeIn second" name="user" placeholder="User">
                    <input v-model="newLogin.password" type="Password" id="password" class="fadeIn third" name="pass"
                        placeholder="Password">
                    <input type="button" class="fadeIn fourth" value="Log In" @click="login">
                </form>
            </div>
            <div id="formFooter">
                Only active users can login
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    var url = "models/UserModel.php?action=";

    const app = new Vue({
    el:'#app',
    data:{
      errorMsg: "",
      successMsg: "",
      errors:[],
      users: [],
      newLogin: {user: "", password: ""}
    },
    methods:{
       login(){
            var formData = app.toFormData(app.newLogin);
             axios.post(url.concat("login"), formData).then(function(response){

                if(response.data.error){
                        app.errorMsg = response.data.message;
                }else{
                    app.users = response.data.login;
                    app.successMsg = response.data.message;

                    if (app.users[4] == 0) {
                        app.errorMsg = "Inactive user";
                    }else{
                         window.location = 'views/user.php';
                    }
                }
            });
       },
       toFormData(obj){
            var fd = new FormData();
            for (var i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
       },
    }
  })
</script>

</html>