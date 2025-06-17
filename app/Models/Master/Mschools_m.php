<?php

namespace App\Models\Master;

use App\Models\Core_m;

class Mschools_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek schools
        if ($this->request->getVar("schools_id")) {
            $schoolsd["schools_id"] = $this->request->getVar("schools_id");
        } else {
            $schoolsd["schools_id"] = 0;
        }
        $us = $this->db
            ->table("schools")
            ->getWhere($schoolsd);
        /* echo $this->db->getLastquery();
        die; */
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $schools) {
                foreach ($this->db->getFieldNames('schools') as $field) {
                    $data[$field] = $schools->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('schools') as $field) {
                $data[$field] = "";
            }
        }

        //upload schools logo
        $data['uploadschools_logo'] = "";
        if (isset($_FILES['schools_logo']) && $_FILES['schools_logo']['name'] != "") {
            $avatar = $this->request->getFile('schools_logo');
            $validated = $this->validate([
                'file' => [
                    'uploaded[schools_logo]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/schools_logo', $newName);
                $msg = 'File has been uploaded';
                $input['schools_logo'] = $newName;
            }
            $data['uploadschools_logo'] = $msg;
        }

        //upload sponsor logo
        $data['uploadschools_sponsorlogo'] = "";
        if (isset($_FILES['schools_sponsorlogo']) && $_FILES['schools_sponsorlogo']['name'] != "") {
            $avatar = $this->request->getFile('schools_sponsorlogo');
            $validated = $this->validate([
                'file' => [
                    'uploaded[schools_sponsorlogo]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/schools_sponsorlogo', $newName);
                $msg = 'File has been uploaded';
                $input['schools_sponsorlogo'] = $newName;
            }
            $data['uploadschools_sponsorlogo'] = $msg;
        }



        //delete
        if ($this->request->getVar("delete") == "OK") {
            $this->db
                ->table("schools")
                ->delete(array("schools_id" => $this->request->getVar("schools_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getVar("create") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'create' && $e != 'schools_id') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            if ($input["schools_date"] == "") {
                $input["schools_date"] = date("Y-m-d");
            }
            $input["schools_no"] = date("Ymd") . rand(100, 999);
            $this->db->table('schools')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getVar("change") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'change' && $e != 'schools_logo' && $e != 'schools_sponsorlogo') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            $this->db->table('schools')->update($input, array("schools_id" => $this->request->getVar("schools_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
