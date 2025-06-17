<?php

namespace App\Models\Master;

use App\Models\Core_m;

class Msbank_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek sbank
        if ($this->request->getVar("sbank_id")) {
            $sbankd["sbank_id"] = $this->request->getVar("sbank_id");
        } else {
            $sbankd["sbank_id"] = 0;
        }
        $us = $this->db
            ->table("sbank")
            ->getWhere($sbankd);
        /* echo $this->db->getLastquery();
        die; */
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $sbank) {
                foreach ($this->db->getFieldNames('sbank') as $field) {
                    $data[$field] = $sbank->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('sbank') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadsbank_picture'] = "";
        if (isset($_FILES['sbank_picture']) && $_FILES['sbank_picture']['name'] != "") {
            $avatar = $this->request->getFile('sbank_picture');
            $validated = $this->validate([
                'file' => [
                    'uploaded[sbank_picture]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/sbank_picture', $newName);
                $msg = 'File has been uploaded';
                $input['sbank_picture'] = $newName;
            }
            $data['uploadsbank_picture'] = $msg;
            // dd($data);
        }

        /*  if (isset($_FILES['sbank_picture']) && $_FILES['sbank_picture']['name'] != "") {
            $sbank_picture = str_replace(' ', '_', $_FILES['sbank_picture']['name']);
            $sbank_picture = date("H_i_s_") . $sbank_picture;
            if (file_exists('images/sbank_picture/' . $sbank_picture)) {
                unlink('images/sbank_picture/' . $sbank_picture);
            }
            $config['file_name'] = $sbank_picture;
            $config['upload_path'] = 'images/sbank_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sbank_picture')) {
                $data['uploadsbank_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadsbank_picture'] = "Upload Success !";
                $input['sbank_picture'] = $sbank_picture;
            }
        } */

        //delete
        if ($this->request->getVar("delete") == "OK") {
            $this->db
                ->table("sbank")
                ->delete(array("sbank_id" => $this->request->getVar("sbank_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'sbank_id' && $e != 'sbank') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('sbank')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'sbank_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('sbank')->update($input, array("sbank_id" => $this->request->getVar("sbank_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
