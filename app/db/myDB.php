<?php
    class DB {
        public function __construct(Type $name = null, $schema = null) {
            $this -> name = $name;
            $this -> schema = $schema;
        }
        public function model($data){
            public function create(){}
            public function find(){
                public function countDocument(){}
                public function Aggregate(){}
                public function save(){}
                public function remove(){} 
                public function validate(){}
            }
            public function findOne(){}
            public function updateOne(){}
            public function deleteOne(){}
            public function findOneById(){}
            public function findById(){}
            public function findByIdAndUpdate(){}
            public function findByIdAndDelete(){}

        }//class
        public function schema($data){}//class

        
    }

    // $name = "TechUsers";

    // $schema = "CREATE TABLE IF NOT EXISTS $users_table (
    //     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     firstname VARCHAR(225) NOT NULL,
    //     lastname VARCHAR(225) NOT NULL,
    //     username VARCHAR(225) NOT NULL,
    //     email VARCHAR(50) NOT NULL, 
    //     date_of_birth DATE NOT NULL,
    //     country VARCHAR(100) NOT NULL,
    //     gender VARCHAR(100) NOT NULL,
    //     password_hash VARCHAR(225) NOT NULL,
    //     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // )";

    
    // const $User = new DB($name, $Schema);


    // connect takes in the connection uri and connects the mysql database (e.g -> mypackage.connect(connectionUri));
    // schema takes in an object of the db_schema (eg -> userSchema = new mypackage.Schema({ })) note: schema looks like a class;
    // model takes in two parameter 1. the mdoel name 2. the schema (eg ->User = mypackage.model('User', userSchema)) note: model is a function;
    // the user model gets those functions(e.g -> User.find({}) and so on);
?>
