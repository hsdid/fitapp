<?php 
session_start();
ob_start();
if (!$_SESSION['logged']) {
    header('location:index.php');
}
?>

   
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
        <title>cart</title>
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
            #overlay{
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6); 
            }
            .total_macro{
                background-color: #5AAC56;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-10">
                                <div class="alert alert-success" v-if="successMsg">
                                    {{ successMsg }}
                                </div>
                                <?php echo $_SESSION['id'];?>
                        <table class="table table-bordered table-striped text-center">
                            
                            <thead>
                                <tr>
                                    <td  colspan=8> 
                                        <button class="btn btn-info block" @click="showModelDb($event);">add product to database</button>
                                        <button class="btn btn-info block" @click="showModel($event);">add product to cart</button>
                                        
                                        <a href="http://localhost/fitapplication/classes/proces.php?action=logout" class="btn btn-danger block" style="color:white;">logout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>product name</td>
                                    <td>product weight</td>
                                    <td>kcal</td>
                                    <td>protein</td>
                                    <td>fat</td>
                                    <td>carb</td>
                                    <td>edit</td>
                                    <th>Delete</th>
                                </tr>

                            </thead>
                            <!-- v-for="product in products" -->
                            <tbody >
                                <tr v-for="product in cart">
                                    <td>{{product.product_name}}</td>
                                    <td>{{product.product_weight}}g</td>
                                    <td>{{product.product_kcal}} kcal</td>
                                    <td>{{product.product_protein}}g</td>
                                    <td>{{product.product_fat}}g</td>
                                    <td>{{product.product_carb}}g</td>
                                    <td>
                                        <a href="" @click="selectProduct(product); showEditM($event);" class="lead text-info"><i class="fas fa-pencil-alt"></i></a>
                                    </td>
                                    <td>
                                        <a href="" @click="selectProduct(product); deleteProduct();" class="lead text-danger"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr class="total_macro">
                                    <th colspan=2>Your total macro</th>
                                    <td>{{totalKcal}} kcal</td>
                                    <td>{{totalProtein}} g</td>
                                    <td>{{totalFat}} g</td>
                                    <td>{{totalCarb}} g</td>
                                    <td colspan=2></td>
                                </tr>
                                    
                            </tbody>
                        </table>
                        <!-- add product to database -->
                        <div id="overlay" v-if="showAddModalDb">
                            
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="alert alert-danger " v-if="errorMsg">
                                    {{ errorMsg }}
                                </div>
                            
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add new product to database</h5>
                                        <!-- <button type="button" class="close" @click="showModelDb($event);">
                                            <span aria-hidden="true">&times;</span>
                                        </button> -->
                                        <button class="btn block" @click="showModelDb($event); clearMsg();">back</button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <input type="text" name="pname" class="form-control form-control-lg" placeholder="Product name" v-model="newProduct.pname">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="pkcal" class="form-control form-control-lg" placeholder="kcal per 100g" v-model="newProduct.kcal_100">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="pprotein" class="form-control form-control-lg" placeholder="Product protein" v-model="newProduct.protein_100">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="pfat" class="form-control form-control-lg" placeholder="Product fat"v-model="newProduct.fat_100">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="pcarb" class="form-control form-control-lg" placeholder="Product carb" v-model="newProduct.carb_100">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-info btn-block btn-lg" id="addSubmit" @click="addProductDB($event); clearMsg();">Add Product</button>
                                            </div>                                                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add product to curent cart -->
                        <div id="overlay" v-if="showAddModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add product to cart</h5>
                                        <!-- <button type="button" class="close" @click="showModel($event);">
                                            <span aria-hidden="true">&times;</span>
                                        </button> -->
                                        <button class="btn block" @click="showModel($event); clearMsg();">back</button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <input type="text" name="pname" class="form-control form-control-lg" placeholder="Product name" v-model="addProduct.pname">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="pweight" class="form-control form-control-lg" placeholder="Product weight" v-model="addProduct.pweight">
                                            </div>                                                                                                             
                                            
                                            <div class="form-group">
                                                <button class="btn btn-info btn-block btn-lg" id="addSubmit" @click="addProductCart($event)">Add Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- edit product in cart -->
                        <div id="overlay" v-if="showEditModal">
                            
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="alert alert-danger " v-if="errorMsg">
                                    {{ errorMsg }}
                                </div>
                            
                                    <div class="modal-header">
                                        <h5 class="modal-title">update product</h5>
                                        <!-- <button type="button" class="close" @click="showModelDb($event);">
                                            <span aria-hidden="true">&times;</span>
                                        </button> -->
                                        <button class="btn block" @click="showEditM($event); clearMsg();">back</button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <input type="text" name="pweight" class="form-control form-control-lg" placeholder="currentProduct.product_weight" v-model="currentProduct.product_weight">
                                            </div>                  
                                            <div class="form-group">
                                                <button class="btn btn-info btn-block btn-lg" id="addSubmit" @click="updateProduct($event); clearMsg();">Add Product</button>
                                            </div>                                                                           
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col"> 

                    </div> -->
                </div>
            </div>         
        </div>
    
    
    
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script type="text/javascript" src="main.js"></script>
        

    </body>
    </html>
    