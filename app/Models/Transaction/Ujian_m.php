<?php

namespace App\Models\transaction;

use App\Models\core_m;

class Ujian_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek ujian
        if ($this->request->getVar("ujian_id")) {
            $ujiand["ujian_id"] = $this->request->getVar("ujian_id");
        } else {
            $ujiand["ujian_id"] = -1;
        }
        $us = $this->db
            ->table("ujian")
            ->getWhere($ujiand);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "ujian_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $ujian) {
                foreach ($this->db->getFieldNames('ujian') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $ujian->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('ujian') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $ujian_id =   $this->request->getPost("ujian_id");
            $this->db
                ->table("ujian")
                ->delete(array("ujian_id" =>  $ujian_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'ujian_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('ujian');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $ujian_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'ujian_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $ujian_id = $this->request->getPost("ujian_id");
            $this->db->table('ujian')->update($input, array("ujian_id" => $ujian_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
