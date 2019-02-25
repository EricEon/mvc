<?php

namespace Flux\Controller;

use Flux\Core\Http\Request;
use Flux\Core\Helpers\Mailer;
use Flux\Core\Helpers\Session;
use Flux\Core\Database\Connector;


class AuthController 
{
    
    /**
     * register.
     *
     * @author	Unknown
     * @since	v0.0.1
     * @version	v1.0.0	Friday, February 8th, 2019.
     * @access	public static
     * @param	string	$table	
     * @param	array 	$data 	
     * @return	void
     */
    public static function register(String $table, Array $data){
        $connect = Connector::connect();
        $keys = [];
        $values = [];
        $prepKey = "";
        $prepVal = array();
        $serverName = Request::host();
        $header = ["FROM" => "no-reply@loginoo.test"];

        $email = $data['email'];
        
        //var_dump($data);
        if (!is_array($data) && empty($data)) {
            $error = new \PDOException("Values passed must be of type array");
            $error->getMessage();
        }
        /**
         * If the password from the password_confirm input matches the first password entered, then save password value to a variable and unset both password and password_confirm.
         * Pass in new data using the unary array method, this makes the key value pair pushed to not have to be sorted.
         * Hash the password and the activation data.
         */
        if(array_key_exists('password_confirm',$data)){
            if($data['password'] === $data['password_confirm']){
                $pass = $data['password'];
                $activation_code = hash('sha512',$data['name']);
                unset($data['password']);
                unset($data['password_confirm']);
                $data += ['password' => password_hash($pass,PASSWORD_DEFAULT)];
                $data += ['activation_code' => $activation_code];
            }
        }
        /*
         *The foreach loop splits the array given into key and value for each index.
         * The keys are separated into a $keys array, the same is done to the values.
         * A $prepKey array is used for the key binding needed by pdo for the data manipulation.
         * A $prepVal array is used to store the $prepKey and values giving a :name => name Array.
         */
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
            $prepKey = ":" . $key; //$prepKey is a variable that stores strings
            $prepVal[$prepKey] = $value;
        }
        /**
         * Use implode not list to separate the array values into a string with a glue string joining them.
         */
        $columns = implode(",",$keys);
        $params = ":".implode(",:",$keys);

        /**
         * Resulting sql string should contain pdo named placeholder for values and normal string for the columns.
         */
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$params})";

        //Prepare the sql statement for execution by pdo
        $prep = $connect->prepare($sql);

        //Using foreach loop bind the values to their placeholders, represented by the key value pairs in the array.
        foreach($prepVal as $key => $value){
            $prep->bindValue($key,$value);
        }
        try {
            $create = $prep->execute();
            
            $message = "
            <html>
            <head>
            <title>Activation Code Link</title>
            </head>
            <body>
            <p>Below is the activation code</p>
            <table>
                <tr>
                <td colspan='2'>
                <a style='text-decoration:none;width:300px;background-color:grey;' target='_blank' href='http://$serverName/activate/$email/$activation_code'>ACTIVATE</a>   
                </td>
                </tr>
            </table>
            </body>
            </html>
            ";
            Mailer::send($email,"Click the button below to activate your account",$message,$header);
            return $create;
        } catch (\Throwable $th) {
            Session::create('danger','Unsuccessful Registration!!');
        }
        
        
    }


    public static function  activate(Array $data){
        $email = $data['email'];
        $activation_code = $data['activation_code'];
        $connect = Connector::connect();

        try {
            $sql = "SELECT id  FROM users WHERE email=:email AND activation_code=:activation_code";
        var_dump($sql);

        $user = $connect->prepare($sql);
        //var_dump($user);
        $user->execute(["email"=> $email,"activation_code"=> $activation_code]);
        $count = $user->rowCount();
        //dd($count);
        if($count > 0){
           $sql = "UPDATE users SET activation_confirm=1, activation_code=0 WHERE email=:email";
           $user = $connect->prepare($sql);
            //var_dump($user);
            $user->execute(["email"=> $email]);
            $count = $user->rowCount();
            //dd($count);
            if($count>0){
                Session::create('success','You can now login to your account');
            }
        }else{
            Session::create('danger','Unsuccessful Activation!!');
        }

        } catch (\Throwable $th) {
            //throw $th;
            Session::create('danger','Unsuccessful Activation!!');
        }
        
    }

    public function login(){
        echo "login";
    }
   
}