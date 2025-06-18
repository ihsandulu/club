<?php

namespace App\Models\transaction;

use App\Models\Core_m;

class Ujiand_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek ujiand
        if ($this->request->getVar("ujiand_id")) {
            $ujiandd["ujiand_id"] = $this->request->getVar("ujiand_id");
        } else {
            $ujiandd["ujiand_id"] = -1;
        }
        $us = $this->db
            ->table("ujiand")
            ->getWhere($ujiandd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "ujiand_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $ujiand) {
                foreach ($this->db->getFieldNames('ujiand') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $ujiand->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('ujiand') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $ujiand_id =   $this->request->getPost("ujiand_id");
            $this->db
                ->table("ujiand")
                ->delete(array("ujiand_id" =>  $ujiand_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'ujiand_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('ujiand');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $ujiand_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'ujiand_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $ujiand_id = $this->request->getPost("ujiand_id");
            $this->db->table('ujiand')->update($input, array("ujiand_id" => $ujiand_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
