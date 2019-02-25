<?php

namespace Flux\Core\Database;

use Flux\Core\Helpers\Mailer;
use Flux\Core\Helpers\Session;
use Flux\Core\Database\Connector as Db;

class QueryBuilder implements DataQueryTrait
{
    /**
     * @var		string	$table
     */
    public $table = '';

    /**
     * @var		array	$data
     */
    public $data = [];



    /**
     * __construct.
     *
     * @author	eonflux
     * @since	v0.0.1
     * @version	v1.0.0	Sunday, February 24th, 2019.
     * @access	public
     * @param	mixed	$con	Default: null
     * @return	void
     */
    public function __construct($con = null)
    {
        // $pdo = new Connector();
        $this->con = Db::connect();
    }

    /**
     * table.
     *
     * @author	eonflux
     * @since	v0.0.1
     * @version	v1.0.0	Sunday, February 24th, 2019.
     * @access	public
     * @param	string	$table	
     * @return	mixed
     */
    public function table(String $table)
    {
        if (!is_string($table)) {
            throw new \PDOException("Datatype must be of type String");
        }
        $this->table = $table;
        return $this;
    }

    /**
     * create.
     *
     * @author	eonflux
     * @since	v0.0.1
     * @version	v1.0.0	Sunday, February 24th, 2019.
     * @access	public
     * @param	array	$data	
     * @return	void
     */
    public function create(array $data)
    {
        $keys = [];
        $values = [];
        $prepKey = "";
        $prepVal = array();

        $email = $data['email'];
        
        //var_dump($data);
        if (!is_array($data) && empty($data)) {
            $error = new \PDOException("Values passed must be of type array");
            $error->getMessage();
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
        // var_dump($keys);
        // var_dump($values);
        // var_dump($prepVal);
        /**
         * Use implode not list to separate the array values into a string with a glue string joining them.
         */
        $columns = implode(",", $keys);
        $params = ":" . implode(",:", $keys);
        // var_dump($columns);
        // var_dump($params);

        /**
         * Resulting sql string should contain pdo named placeholder for values and normal string for the columns.
         */
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$params})";
        // var_dump($sql);

        //Prepare the sql statement for execution by pdo
        $prep = $this->con->prepare($sql);
        // var_dump($prep);

        //Using foreach loop bind the values to their placeholders, represented by the key value pairs in the array.
        foreach ($prepVal as $key => $value) {
            $prep->bindValue($key, $value);
        }
        //$create;
        try {
            $create = $prep->execute();
            Session::create('success', 'Data Saved!!');

            return $create;
        } catch (\Throwable $th) {
            Session::create('danger', 'Unsuccessful Process');
        }


    }


}