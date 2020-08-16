<?php 
session_start();

if ($_SESSION['logged']) { 
    header("location:cart.php");
    exit();
} 
else $_SESSION['logged'] = false;

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
            color: black; 
        }
        a:visited{
            color: black;
        }
        #app{
            max-height: 100%;
        }
        body{
            background-color: rgb(227, 236, 240);
        }
    </style>
</head>
<body>
   <div id="app">
    <!-- <hello-user></hello-user> -->
        <div class="container-fluid bg-light" style="max-height: 100%;">
            <div class="row mt-3 ">
                <div class="col-lg-12 text-center">
                
                    <i class="fas fa-dumbbell fa-7x text-info mt-4"></i>
                    <h1 class=" text-center mt-4">Welcome in fit app</h1>
                    <h5 class="mt-4 mb-4 ">Simplest app to track your calories and macro. Start now !</h5>
                </div>

            
            </div>
            <div class="row mt-4">
                
                    <div class="col mt-4 p-4"> 
                        <h3 class="text-center">
                            <a href="login.php">You already have account? 
                                <p><i class="far fa-user fa-3x text-info mt-2"></p></i>
                            </a>
                        
                        </h3>
                        
                    </div>
                    <div class="col mt-4 p-4"> 
                        <h3 class="text-center">
                            <a href="create_accont.php"> You want create account?
                                <p><i class="far fa-plus-square fa-3x text-info mt-2"></i></p>
                            </a>
                                </h3>
                    </div>
                
            </div>  
        </div>
    
    </div>
    
   
   
   
  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="main.js"></script>
    

</body>
</html>
