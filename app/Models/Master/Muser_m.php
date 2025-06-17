<?php

namespace App\Models\Master;

use App\Models\Core_m;

class Muser_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek user
        if ($this->request->getVar("user_id")) {
            $userd["user_id"] = $this->request->getVar("user_id");
        } else {
            $userd["user_id"] = 0;
        }
        $us = $this->db
            ->table("user")
            ->getWhere($userd);
        /* echo $this->db->getLastquery();
        die; */
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    $data[$field] = $user->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploaduser_picture'] = "";
        if (isset($_FILES['user_picture']) && $_FILES['user_picture']['name'] != "") {
            $avatar = $this->request->getFile('user_picture');
            $validated = $this->validate([
                'file' => [
                    'uploaded[user_picture]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/user_picture', $newName);
                $msg = 'File has been uploaded';
                $input['user_picture'] = $newName;
            }
            $data['uploaduser_picture'] = $msg;
        }

        /*  if (isset($_FILES['user_picture']) && $_FILES['user_picture']['name'] != "") {
            $user_picture = str_replace(' ', '_', $_FILES['user_picture']['name']);
            $user_picture = date("H_i_s_") . $user_picture;
            if (file_exists('images/user_picture/' . $user_picture)) {
                unlink('images/user_picture/' . $user_picture);
            }
            $config['file_name'] = $user_picture;
            $config['upload_path'] = 'images/user_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user_picture')) {
                $data['uploaduser_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploaduser_picture'] = "Upload Success !";
                $input['user_picture'] = $user_picture;
            }
        } */

        //delete
        if ($this->request->getVar("delete") == "OK") {
            $this->db
                ->table("user")
                ->delete(array("user_id" => $this->request->getVar("user_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getVar("create") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'create' && $e != 'user_id') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            $input["user_token"] = rand(1000, 9999) . date("md");
            $this->db->table('user')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getVar("change") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'change' && $e != 'user_picture') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            $this->db->table('user')->update($input, array("user_id" => $this->request->getVar("user_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
