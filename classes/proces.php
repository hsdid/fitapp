<?php 
include '../classes/Validation.php';
include '../classes/Product.php';


ob_start();

//$_SESSION['logged'] = false;
//$_SESSION['user_id'] = 0;

$user = new Validation();
$product = new Product();
$action = '';

if (isset($_GET['action'])){
    $action = $_GET['action'];
    
}

if ($action == 'login') {
    $userName = $_POST['name'];
    $userPass = $_POST['password'];

   
    $user->userLogin($userName,$userPass);
}

if ($action == 'readproducts') {

    $user_id = $_SESSION['user_id'];
    $product->showProductlist($user_id);
}
/// add to cart 
if ($action == 'pname') {
    
    $name = $_POST['name'];
    $_SESSION['name'] = $name;
}
if ($action == 'readProduct'){
    
    
    $pname = $_SESSION['name'];
    $product->readProdukt($pname);
}
if ($action == 'create_account') {
    
    $name = $_POST['name'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $email = $_POST['email'];
    $user->userRegister($name, $pass1, $pass2, $email);
}
if ($action == 'addToCart') {
    
    $user_id = $_POST['user_id'];
    $pname = $_POST['pname'];
    $pweight = $_POST['pweight'];
    $kcalorie = $_POST['kcal'];
    $protein = $_POST['protein'];
    $fat = $_POST['fat'];
    $carb = $_POST['carb'];

    $product->addToCart($user_id,$pname,$pweight,$kcalorie,$protein,$fat,$carb);

    //$product->showProductlist($user_id);
}

//----------------

if ($action == 'logout') {
    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = null;
    header('location:../index.php');
}

if ($action == 'AddProductDb')
{
    $pname = $_POST['pname'];
    $pkcal_100 = $_POST['kcal_100'];
    $pprotein_100 = $_POST['protein_100'];
    $pfat_100 = $_POST['fat_100'];
    $pcarb_100 = $_POST['carb_100'];

    $product->addToDB($pname,$pkcal_100,$pprotein_100,$pfat_100,$pcarb_100);
}

if ($action == 'delete') {
    $id = $_POST['id_cart'];

    $product->deleteFromCart($id);
}

if ($action == 'update') {
    $id = $_POST['id_cart'];
    $pweight = $_POST['product_weight'];
    $product->updateProduct($id,$pweight);
}
   




?>
