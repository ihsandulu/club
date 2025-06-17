<?php

namespace App\Models\Master;

use App\Models\Core_m;

class Midentity_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek identity
        if ($this->request->getVar("identity_id")) {
            $identityd["identity_id"] = $this->request->getVar("identity_id");
        } else {
            $identityd["identity_id"] = 0;
        }
        $us = $this->db
            ->table("identity")
            ->getWhere($identityd);
        /* echo $this->db->getLastquery();
        die; */
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $identity) {
                foreach ($this->db->getFieldNames('identity') as $field) {
                    $data[$field] = $identity->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('identity') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadidentity_picture'] = "";
        if (isset($_FILES['identity_picture']) && $_FILES['identity_picture']['name'] != "") {
            $avatar = $this->request->getFile('identity_picture');
            $validated = $this->validate([
                'file' => [
                    'uploaded[identity_picture]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/identity_picture', $newName);
                $msg = 'File has been uploaded';
                $input['identity_picture'] = $newName;
            }
            $data['uploadidentity_picture'] = $msg;
        }

        /*  if (isset($_FILES['identity_picture']) && $_FILES['identity_picture']['name'] != "") {
            $identity_picture = str_replace(' ', '_', $_FILES['identity_picture']['name']);
            $identity_picture = date("H_i_s_") . $identity_picture;
            if (file_exists('images/identity_picture/' . $identity_picture)) {
                unlink('images/identity_picture/' . $identity_picture);
            }
            $config['file_name'] = $identity_picture;
            $config['upload_path'] = 'images/identity_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('identity_picture')) {
                $data['uploadidentity_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadidentity_picture'] = "Upload Success !";
                $input['identity_picture'] = $identity_picture;
            }
        } */

        //delete
        if ($this->request->getVar("delete") == "OK") {
            $this->db
                ->table("identity")
                ->delete(array("identity_id" => $this->request->getVar("identity_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getVar("create") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'create' && $e != 'identity_id') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            $input["user_id_created"] = session()->get("user_id");
            $input["user_id_updated"] = session()->get("user_id");
            $input["created"] = date("Y-m-d H:i:s");
            $input["updated"] = date("Y-m-d H:i:s");
            $this->db->table('identity')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getVar("change") == "OK") {
            foreach ($this->request->getVar() as $e => $f) {
                if ($e != 'change' && $e != 'identity_picture') {
                    $input[$e] = $this->request->getVar($e);
                }
            }
            $input["identity_name"] = htmlentities($input["identity_name"], ENT_QUOTES);
            $this->db->table('identity')->update($input, array("identity_id" => $this->request->getVar("identity_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
