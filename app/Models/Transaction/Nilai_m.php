<?php

namespace App\Models\transaction;

use App\Models\Core_m;

class Nilai_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek nilai
        if ($this->request->getVar("nilai_id")) {
            $nilaid["nilai_id"] = $this->request->getVar("nilai_id");
        } else {
            $nilaid["nilai_id"] = -1;
        }
        $us = $this->db
            ->table("nilai")
            ->getWhere($nilaid);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "nilai_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $nilai) {
                foreach ($this->db->getFieldNames('nilai') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $nilai->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('nilai') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $nilai_id =   $this->request->getPost("nilai_id");
            $this->db
                ->table("nilai")
                ->delete(array("nilai_id" =>  $nilai_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'nilai_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('nilai');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $nilai_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'nilai_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $nilai_id = $this->request->getPost("nilai_id");
            $this->db->table('nilai')->update($input, array("nilai_id" => $nilai_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
