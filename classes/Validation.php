<?php include '../lib/Database.php'; 
    session_start();
    //$_SESSION['logged'] = false;
?>

<?php
class Validation {

    private $db;
    private $test;
    public $error;
    public $registerMsg;
    public $result;
   
    
    public function __construct() {
        $this->db = new Database();
        //$this->registerMsg = '';
        $this->validate = true;
        $this->result = array('error'=>false);
    }

    public function userRegister($userName, $userPass,$userPass2,$userEmail){
        
        $Name = mysqli_real_escape_string($this->db->link,$userName);
        $Pass = mysqli_real_escape_string($this->db->link,$userPass);
        $Pass2 = mysqli_real_escape_string($this->db->link,$userPass2);
        $Email = mysqli_real_escape_string($this->db->link,$userEmail);
    
        ///Checking username
        if ((strlen($Name) < 3 ) || (strlen($Name) >20)) {
            $this->validate = false;
            $this->result['error'] = true;
            $this->result['message'] = "Username or Password must contain between 3 and 20 characters";
        }
        if (ctype_alnum($Name) == false) {
            $this->validate = false;
            $this->result['error'] = true;
            $this->result['message'] = "USername may consist of numbers and letters";
        }
        $query = "SELECT COUNT(user_name) as usName from users WHERE user_name = '$Name'";
        $result = $this->db->select($query);
        $data = mysqli_fetch_assoc($result);
       //echo $data['usName'];
        if ($data['usName'] > 0) {
        $this->validate = false;
        $this->result['error'] = true;
        $this->result['message'] = "name already exist";
        }
        ///Checking password
        if ($Pass != $Pass2) {
            $this->validate = false;
            $this->result['error'] = true;
            $this->result['message'] = "Password are diffrent";
        }
        //Checking email
        if (filter_var($Email,FILTER_VALIDATE_EMAIL) == false ){
            $this->validate = false;
            $this->result['error'] = true;
            $this->result['message'] = "Uncorect email";
        }
        $query = "SELECT COUNT(user_email) as email from users WHERE user_email = '$userEmail'";
        $result = $this->db->select($query);
        
        if (!$result) {
            $this->result['message'] = 'failed conection';
            $this->result['error'] = true;
        }
        $data = mysqli_fetch_assoc($result);
        //echo $data['email'];
       
        if ($data['email'] > 0) {
            $this->validate = false;
            $this->result['error'] = true;
            $this->result['message'] = "email already exist";
        }
        
        //if $validate in the end is true, validate is camplete
        if ($this->validate) {
           
            $query = "INSERT INTO users (user_name, user_pass, user_email) VALUES ('$Name', '$Pass','$Email')";
            

            if( $this->db->insert($query)) {
                
                $this->result['error'] = false;
                $this->result['message'] = "Successfully created account";
            }

        } 
        echo json_encode($this->result);
    }

    public function userLogin($userName,$userPass) {
    
        $name = mysqli_real_escape_string($this->db->link,$userName);
        $pass = mysqli_real_escape_string($this->db->link,$userPass);

        if (empty($name) || empty($pass)){
            $this->result['message'] = 'name and password must not be empty ';
            $this->result['logged'] = false;
            $this->result['error'] = true;
        } else {
            $query = "SELECT * from users WHERE user_name = '$name' AND user_pass = '$pass'";

            $result = $this->db->select($query);
        
            if ($result != false){
                $value = $result->fetch_assoc();

                $this->result['message'] = "logged sucesfully";
                $this->result['logged'] = true;
                $this->result['error'] = false;
                //$this->result['userId'] = $value['user_id'];
                $_SESSION['user_id'] = $value['user_id'];
                $_SESSION['logged'] = true;
                
            }
            else {
                $this->result['message'] = "wrong login or password";
                $this->result['logged'] = false;
                $this->result['error'] = true;
               
            }
            //echo json_encode($this->result);
        }
        echo json_encode($this->result);
    }
    
    public function getUsers() {
        $query = "SELECT * FROM users";
        $sql = $this->db->select($query);
        $users = array();
        while($row = $sql->fetch_assoc()){
            array_push($users, $row);
        }
        $this->result['users'] = $users;
        $this->result['message'] = 'wyswietl dane ';
        $this->result['error'] = false;
       
        echo json_encode($this->result);
    }
    
}

