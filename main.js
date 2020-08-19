var app = new Vue({
    el: '#app',
    data:{
        errorMsg: "",
        successMsg: "",
        loginUser: {name: "", password: ""},
        newUser: {name:"", pass1:"", pass2:"", email:""},
        newProduct: {pname:"", kcal_100:"", protein_100:"", fat_100:"", carb_100:""},
        addProduct: {user_id:0, pname:"", pweight:0, kcal:0 , protein: 0, fat:0, carb:0},
        editProduct: { kcal:0 , protein: 0, fat:0, carb:0},
        cart: [],
        currentProduct: {},
        totalKcal: 0.0,
        totalProtein: 0.0,
        totalFat: 0.0,
        totalCarb: 0.0,
        addtoDb: true,
        showAddModal: false,
        showAddModalDb: false,
        showEditModal: false

    },
    mounted() {
       
        this.getProducts();
    },
    methods: {
        login(e) {
            e.preventDefault();
            
            var formData = app.toFormData(app.loginUser);
            
            axios.post("http://localhost/fitapplication/classes/proces.php?action=login", formData).then(function(response){
                
            app.loginUser = {name: "", password: ""};    
                if (response.data.error){
                        app.errorMsg = response.data.message;  
                    } 
                else {
                    app.successMsg = response.data.message;
                    
                    location.replace("http://localhost/fitapplication/cart.php");
                }
            });
           // app.successMsg = app.loginUser;
        },
        registration(e) {
            e.preventDefault();
            var formData = app.toFormData(app.newUser);
            axios.post("http://localhost/fitapplication/classes/proces.php?action=create_account",formData).then(function(response){
                
                app.newUser = {name:"", pass1:"", pass2:"", email:""};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                } else {
                    app.successMsg = response.data.message;
                    location.replace("http://localhost/fitapplication/login.php");
                }
            });

        },
        ///product witch will be show in cart
        getProducts() {
                axios.get("http://localhost/fitapplication/classes/proces.php?action=readproducts").then(function(response) {
                
                    app.totalKcal = 0;
                    app.totalProtein = 0;
                    app.totalFat = 0;
                    app.totalCarb = 0;
                
                if(response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.cart = response.data.products;
                    
                    for(product in app.cart){
                        
                        app.totalKcal += parseFloat(app.cart[product].product_kcal);
                        app.totalProtein += parseFloat(app.cart[product].product_protein);
                        app.totalFat += parseFloat(app.cart[product].product_fat);
                        app.totalCarb += parseFloat(app.cart[product].product_carb);
                    }   
                    
                    app.totalKcal = app.totalKcal.toFixed(1);
                    app.totalProtein = app.totalProtein.toFixed(1);
                    app.totalFat = app.totalFat.toFixed(1);
                    app.totalCarb = app.totalCarb.toFixed(1);
                   
                    app.successMsg = response.data.message;
                    //console.log(app.cart);
                    app.clearMsg();
                }
            });
        },

        showModelDb(e) {
            e.preventDefault();
            app.showAddModalDb = !app.showAddModalDb;
        },
        showModel(e) {
            e.preventDefault();
            app.showAddModal = !app.showAddModal;
        },
        showEditM(e,) {
            e.preventDefault();
           app.showEditModal = !app.showEditModal;
        },

        addProductDB(e) {
            e.preventDefault();
           
            var x = Object.values(app.newProduct);
            
            /// checks for an empty field
            for (i in x){
               
                if (x[i].length == 0){
                   
                    app.errorMsg = "field cant be empty";
                    app.addtoDb = false;
                    
                } 
             }
            // if every field is fill
            if(app.addtoDb){
               
                var formData = app.toFormData(app.newProduct);
            
                axios.post('http://localhost/fitapplication/classes/proces.php?action=AddProductDb',formData).then(function(response){
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.successMsg = response.data.message;
                }
            });
            app.showAddModalDb = !app.showAddModalDb;
            }            
        },
        addProductCart(e) {
            e.preventDefault();
            //checking empty field
            if ((app.addProduct.pname.length == 0) || (app.addProduct.pweight.length == 0)) {
                app.errorMsg = "empty field";
            } else {
               
                var data = {name :app.addProduct.pname} ;
                var formData = app.toFormData(data);
                
                axios.post('http://localhost/fitapplication/classes/proces.php?action=pname',formData).then(function(response){
                    if(response.data.error) {
                        app.errorMsg = response.data.message;
                    } else {
                        //console.log(response);  
                    }
                });

                axios.get('http://localhost/fitapplication/classes/proces.php?action=readProduct').then(function(response){
                    if(response.data.error) {
                        app.errorMsg = response.data.message;
                    } else {
                       
                        var x = Object.values(response.data.product);
                        var data = x[0];
                        var id = Object.values(response.data.userId);

                        app.addProduct.user_id = parseInt(id);
                        app.addProduct.pweight = parseFloat(app.addProduct.pweight);
                        app.addProduct.kcal = parseFloat(data.product_cal_100 );
                        app.addProduct.protein = parseFloat(data.product_protein_100);
                        app.addProduct.fat = parseFloat(data.product_fat_100);
                        app.addProduct.carb = parseFloat(data.product_carb_100);
                    
                        var values = Object.values(app.addProduct);
                        var key = Object.keys(app.addProduct);
                        
                        // update values 
                        for(var i = 3; i < 7; i++) {
                               
                            values[i] = ((app.addProduct.pweight)/100) * values[i];
                            app.addProduct[key[i]] = values[i].toFixed(1);

                        }
                        
                        //console.log(app.addProduct);
                        var productToCart = app.toFormData(app.addProduct);
    
                        axios.post('http://localhost/fitapplication/classes/proces.php?action=addToCart',productToCart).then(function(response){
                            if(response.data.error) {
                                app.errorMsg = response.data.message;
                                console.log('nie udalo sie');
                            } else {
                                console.log('udalo sie ');
                                app.successMsg = response.data.message;
                               
                                app.getProducts();
                            }
                        });
                    }
                });

                app.showAddModal = !app.showAddModal;
            }

           

        },
        updateProduct(e) {
            e.preventDefault();
            app.showEditModal = !app.showEditModal;

            //console.log(app.currentProduct.id_cart);

            var formData = app.toFormData(app.currentProduct);
            // post name of product we will update adn take value per 100
            axios.post('http://localhost/fitapplication/classes/proces.php?action=readUpdate',formData).then(function(response){
               
               if (response.data.error) {
                    app.errorMsg = response.data.message;
               } else {
               
                var x = Object.values(response.data.product[0]);
               
                
                app.editProduct.kcal = parseFloat(x[2]);
                app.editProduct.protein = parseFloat(x[3]);
                app.editProduct.fat = parseFloat(x[4]);
                app.editProduct.carb = parseFloat(x[5]);

                for(i in app.editProduct){
                   
                    app.editProduct[i] = ((parseFloat(app.currentProduct.product_weight))/100) * app.editProduct[i];
                }
                var weight = parseFloat(app.currentProduct.product_weight);
                var id = parseFloat(app.currentProduct.id_cart);
                

                Object.assign(app.editProduct, {pweight: weight}, {cart_id:id});
               
                console.log(app.editProduct);
                
                /// send updated values to db
                var updatedData = app.toFormData(app.editProduct);
               
                axios.post('http://localhost/fitapplication/classes/proces.php?action=postUpdated',updatedData).then(function(response){
                    if (response.data.error) {
                        app.errorMsg = response.data.message;
                        console.log(response.data.message);
                    } else {
                        app.successMsg = response.data.message;
                        console.log(response.data.message);
                        app.getProducts();
                        
                    }
                   
                });

                // app.successMsg = response.data.message;
                // app.getProducts();
                 app.currentProduct = {};
               }
            });

        },
        deleteProduct() {
           
            var formData = app.toFormData(app.currentProduct);
            console.log(app.currentProduct);
            axios.post("http://localhost/fitapplication/classes/proces.php?action=delete", formData).then(function(response){
                app.currentProduct = {};    
                if (response.data.error){
                        app.errorMsg = response.data.message;
                    } 
                else {
                    app.successMsg = response.data.message;
                    app.getProducts();
                }
            });
        },
        selectProduct(product) {
            app.currentProduct = product;

        },
        toFormData(obj) {
            var fd = new FormData();
            for(var i in obj) {
                fd.append(i,obj[i]);
            }

            return fd;
        },
        clearMsg() {
            app.successMsg = '';
            app.errorMsg = '';
        }
       
    }
    
})

