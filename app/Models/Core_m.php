<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Config\Database;
use CodeIgniter\HTTP\Files\UploadedFile;

class Core_m extends Model
{

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($validation);

        if (is_null($db)) {
            $this->db = Database::connect($this->DBGroup);
        } else {
            $this->db = &$db;
        }
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        //Koneksi ke database default
        $this->db = Database::connect("default");

        //jika anda mempunyai database ke dua aktifkan line dibawah ini
        //$this->akunting = Database::connect("databasekedua");

        /*if ($this->db) {
			// check if db exists:
			if ($this->db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='default'")) {
				//db connection initialized
				echo $this->db->getLastQuery();
				die;
			} else {
				echo "ga konek";
				die;
			}
		} else {
			echo "ada yg ga bener setting db nya";
			die;
		}*/
    }
}
