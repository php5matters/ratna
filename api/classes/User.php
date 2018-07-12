<?php
class User{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "user";

    // table columns
    public $id;
    public $username;
    public $icnumber;
    public $firstname;
    public $lastname;
    public $phone;
    public $address1;
    public $address2;
    public $address3; 
    public $postcode;
    public $city;
    public $state;
    public $country;
    public $email;
    public $gender;
    public $dob;
    public $race;
    public $parentcode;
    public $createdat;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //C
   // create product
    function create(){
     
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, icnumber=:icnumber, firstname=:firstname, lastname=:lastname,
                    phone=:phone, address1=:address1, address2=:address2, address3=:address3, 
                    postcode=:postcode, city=:city, state=:state, country=:country, 
                    email=:email, gender=:gender, dob=:dob, race=:race, 
                    parentcode=:parentcode, createdat=:createdat";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->username     =   htmlspecialchars(strip_tags($this->username));
        $this->icnumber     =   htmlspecialchars(strip_tags($this->icnumber));
        $this->firstname    =   htmlspecialchars(strip_tags($this->firstname));
        $this->lastname     =   htmlspecialchars(strip_tags($this->lastname));
        $this->phone        =   htmlspecialchars(strip_tags($this->phone));
        $this->address1     =   htmlspecialchars(strip_tags($this->address1));
        $this->address2     =   htmlspecialchars(strip_tags($this->address2));
        $this->address3     =   htmlspecialchars(strip_tags($this->address3));
        $this->postcode     =   htmlspecialchars(strip_tags($this->postcode));
        $this->city         =   htmlspecialchars(strip_tags($this->city));
        $this->state        =   htmlspecialchars(strip_tags($this->state));
        $this->country      =   htmlspecialchars(strip_tags($this->country));
        $this->email        =   htmlspecialchars(strip_tags($this->email));
        $this->gender       =   htmlspecialchars(strip_tags($this->gender));
        $this->dob          =   htmlspecialchars(strip_tags($this->dob));
        $this->race         =   htmlspecialchars(strip_tags($this->race));
        $this->parentcode   =   htmlspecialchars(strip_tags($this->parendcode));
     
        // bind values
        $stmt->bindParam(":username",   $this->username);
        $stmt->bindParam(":icnumber",   $this->icnumber);
        $stmt->bindParam(":firstname",  $this->firstname);
        $stmt->bindParam(":lastname",   $this->lastname);
        $stmt->bindParam(":phone",      $this->phone);        
        $stmt->bindParam(":address1",   $this->address1);
        $stmt->bindParam(":address2",   $this->address2);
        $stmt->bindParam(":address3",   $this->address3);
        $stmt->bindParam(":postcode",   $this->postcode);
        $stmt->bindParam(":city",       $this->city);        
        $stmt->bindParam(":state",      $this->state);
        $stmt->bindParam(":country",    $this->country);
        $stmt->bindParam(":email",      $this->email);
        $stmt->bindParam(":gender",     $this->gender);
        $stmt->bindParam(":dob",        $this->dob);        
        $stmt->bindParam(":race",       $this->race);
        $stmt->bindParam(":parentcode", $this->parentcode);
        $stmt->bindParam(":createdat",  $this->createdat);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
    //R
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY createdat DESC";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    //U
    public function update(){}
    //D
    public function delete(){}
}