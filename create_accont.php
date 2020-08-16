<?php 
session_start();
ob_start();
if ($_SESSION['logged']) {
    header("location:cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <title>Document</title>
    <!-- <script src="js/vue.js"></script> -->
    <style>
        a:link{     
            color: black;
        }
        a:hover{
            text-decoration: underline;     
        }
        a:visited{
            color:black;
        }
        #app{
            max-height: 100%;
        }
        body{
            background-color: rgb(227, 236, 240);
        }
        #back_arrow:hover{
            
        }
    </style>
</head>
<body>
    
    <div id="app">
        
        <div class="container">
             <div class="row mt-4">
                 <div class="col-12 ">
                    
                    <a href="index.php"><i id="back_arrow" class="fas fa-long-arrow-alt-left fa-3x"></i></a>
                    
                    <div class="alert alert-danger " v-if="errorMsg">
                            {{ errorMsg }}
                    </div>
                    <div class="alert alert-success" v-if="successMsg">
                            {{ successMsg }}
                    </div>
                    <h2 class="text-center mt-4">Create account</h2>
                        
                        <!-- <div class="text-center" v-for="user in users">
                       <h4>{{ user.user_name }}</h4>
                        </div> -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <form action="#" method="post">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" v-model="newUser.name" >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="pass1" class="form-control form-control-lg" placeholder="Password" v-model="newUser.pass1">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="pass2" class="form-control form-control-lg" placeholder="Password" v-model="newUser.pass2">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" v-model="newUser.email">
                                        </div>
                                       
                                        <div class="form-group">
                                            <button class="btn btn-info btn-block btn-lg" @click="registration($event); clearMsg();">Create account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>         
    </div>
   
   
   
   
  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="main.js"></script>
    

</body>
</html>
