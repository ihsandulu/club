<?php

namespace App\Models\Transactionm;

use App\Models\Core_m;

class Nilai_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";

        //user
        $userid["user_id"] = session()->get("user_id");
        $user = $this->db
            ->table("user")
            ->getWhere($userid);
        if ($user->getNumRows() > 0) {
            foreach ($user->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    $data[$field] = $user->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }

        //schools
        $schoolsid["schools_id"] = session()->get("schools_id");
        $schools = $this->db
            ->table("schools")
            ->getWhere($schoolsid);
        if ($schools->getNumRows() > 0) {
            foreach ($schools->getResult() as $schools) {
                foreach ($this->db->getFieldNames('schools') as $field) {
                    $data[$field] = $schools->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('schools') as $field) {
                $data[$field] = "";
            }
        }


        




        return $data;
    }
}
