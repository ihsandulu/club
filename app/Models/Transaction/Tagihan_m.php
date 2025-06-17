<?php

namespace App\Models\transaction;

use App\Models\core_m;

class tagihan_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tagihan
        if ($this->request->getVar("tagihan_id")) {
            $tagihand["tagihan_id"] = $this->request->getVar("tagihan_id");
        } else {
            $tagihand["tagihan_id"] = -1;
        }
        $us = $this->db
            ->table("tagihan")
            ->getWhere($tagihand);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "tagihan_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tagihan) {
                foreach ($this->db->getFieldNames('tagihan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tagihan->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('tagihan') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $tagihan_id =   $this->request->getPost("tagihan_id");
            $this->db
                ->table("tagihan")
                ->delete(array("tagihan_id" =>  $tagihan_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tagihan_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('tagihan');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $tagihan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tagihan_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $tagihan_id = $this->request->getPost("tagihan_id");
            $this->db->table('tagihan')->update($input, array("tagihan_id" => $tagihan_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
