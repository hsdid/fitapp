<?php //include '../lib/Database.php'; 
    //session_start();
    //$_SESSION['logged'] = false;
?>
<?php 

class Product {
    
    private $db;
    private $test;
    public $error;
    public $registerMsg;
    public $result;

    public function __construct(){
        $this->db = new Database;
        $this->result = array('error'=>false);
    }
    public function addToDB($pname,$pkcal_100,$pprotein_100,$pfat_100,$pcarb_100){
        $name = mysqli_real_escape_string($this->db->link,$pname);
        $kcal_100 = mysqli_real_escape_string($this->db->link,$pkcal_100);
        $protein_100 = mysqli_real_escape_string($this->db->link,$pprotein_100);
        $fat_100 = mysqli_real_escape_string($this->db->link,$pfat_100);
        $carb_100 = mysqli_real_escape_string($this->db->link,$pcarb_100);

        $query = "INSERT INTO products (product_name,product_cal_100,product_protein_100,product_fat_100,product_carb_100) VALUES('$name', '$kcal_100', '$protein_100', '$fat_100', '$carb_100')";
        
        if ($this->db->insert($query)) {
            $this->result['error'] = false;
            $this->result['message'] = "Successfully added product";
        } else {
            $this->result['error'] = true;
            $this->result['message'] = "product cant be added ";
        }
        echo json_encode($this->result);
    } 

    public function readProdukt($pname){
        
        $name =  mysqli_real_escape_string($this->db->link,$pname);
        $query = "SELECT * FROM  products WHERE product_name = '$name'";
        $sql = $this->db->select($query);
        $product = array();
        
        while ($row = $sql->fetch_assoc()) {
            array_push($product,$row);
        }
            $this->result['error'] = false;
            $this->result['product'] = $product;
            $this->result['userId'] = $_SESSION['user_id'];
            
            echo json_encode($this->result);
    }
    
    public function addToCart($user_id,$pname,$pweight,$kcalorie,$protein,$fat,$carb){
        
        $u_id = mysqli_real_escape_string($this->db->link,$user_id);
        $name = mysqli_real_escape_string($this->db->link,$pname);
        $weight = mysqli_real_escape_string($this->db->link,$pweight);
        $kcal = mysqli_real_escape_string($this->db->link,$kcalorie);
        $proteins = mysqli_real_escape_string($this->db->link,$protein);
        $fats = mysqli_real_escape_string($this->db->link,$fat);
        $carbs = mysqli_real_escape_string($this->db->link,$carb);

        $query = "INSERT INTO cart (u_id,product_name,product_weight,product_kcal,product_protein,product_fat,product_carb) VALUES('$u_id','$name','$weight','$kcal','$proteins','$fats','$carbs')";
        if ($this->db->insert($query)) {
            $this->result['error'] = false;
            $this->result['message'] = "product added";
            

        } else {
            $this->result['error'] = true;
            $this->result['message'] = "product cant be added ";
        }
        echo json_encode($this->result);
    }
    public function showProductlist($user_id) {
        $u_id = mysqli_real_escape_string($this->db->link,$user_id);

        $query = "SELECT * FROM cart WHERE u_id = '$u_id'";
        
            
        $sql = $this->db->select($query);
        $products = array();
            while ($row = $sql->fetch_assoc()){
                array_push($products, $row);
            }
            $this->result['products'] = $products;
            $this->result['error'] = false;
            $this->result['message'] = 'user cart';

       
        echo json_encode($this->result);
    }
    public function deleteFromCart($id){

        $query = "DELETE FROM cart WHERE id_cart = '$id'";
        if ($this->db->delete($query)) {
            $this->result['error'] = false;
            $this->result['message'] = 'product has been removed';
        } else {
            $this->result['error'] = true;
            $this->result['message'] = 'cant remove product';
        }
    }

    public function updateProduct($id,$pweight){
        $query = "UPDATE cart 
        SET product_weight='$pweight' 
        WHERE id_cart = '$id'";
        
        if ($this->db->update($query)) {
            $this->result['error'] = false;
            $this->result['message'] = 'product has been updated';
        } else {
            $this->result['error'] = true;
            $this->result['message'] = 'cant update product';
        }
       
    }
}