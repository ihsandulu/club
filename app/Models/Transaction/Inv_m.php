<?php

namespace App\Models\transaction;

use App\Models\Core_m;

class Inv_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek inv
        if ($this->request->getVar("inv_id")) {
            $invd["inv_id"] = $this->request->getVar("inv_id");
        } else {
            $invd["inv_id"] = -1;
        }
        $us = $this->db
            ->table("inv")
            ->getWhere($invd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "inv_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $inv) {
                foreach ($this->db->getFieldNames('inv') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $inv->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('inv') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $inv_id =   $this->request->getPost("inv_id");
            $this->db
                ->table("inv")
                ->delete(array("inv_id" =>  $inv_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'inv_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('inv');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $inv_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'inv_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $inv_id = $this->request->getPost("inv_id");
            $this->db->table('inv')->update($input, array("inv_id" => $inv_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
