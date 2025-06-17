<?php

namespace App\Models\transaction;

use App\Models\core_m;

class pay_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek pay
        if ($this->request->getVar("pay_id")) {
            $payd["pay_id"] = $this->request->getVar("pay_id");
        } else {
            $payd["pay_id"] = -1;
        }
        $us = $this->db
            ->table("pay")
            ->getWhere($payd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "pay_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $pay) {
                foreach ($this->db->getFieldNames('pay') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $pay->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('pay') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $pay_id =   $this->request->getPost("pay_id");
            $this->db
                ->table("pay")
                ->delete(array("pay_id" =>  $pay_id));
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'pay_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('pay');
            $builder->insert($input);
            // echo $this->db->getLastQuery(); die;
            $pay_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'pay_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $pay_id = $this->request->getPost("pay_id");
            $this->db->table('pay')->update($input, array("pay_id" => $pay_id));
            // echo $this->db->getLastQuery(); die;


            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
