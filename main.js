var app = new Vue({
    el: '#app',
    data:{
        errorMsg: "",
        successMsg: "",
        loginUser: {name: "", password: ""},
        newUser: {name:"", pass1:"", pass2:"", email:""},
        newProduct: {pname:"", kcal_100:"", protein_100:"", fat_100:"", carb_100:""},
        addProduct: {user_id:0, pname:"", pweight:0, kcal:0 , protein: 0, fat:0, carb:0},
        cart: [],
        addtoDb: true,
        showAddModal: false,
        showAddModalDb: false
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
            })

        },
        
        getProducts() {
            axios.get("http://localhost/fitapplication/classes/proces.php?action=readproducts").then(function(response) {
                if(response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.cart = response.data.products;
                    console.log('udalo sie ');
                        
                    app.successMsg = response.data.message;
                                
                    console.log(app.cart);
                   
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

