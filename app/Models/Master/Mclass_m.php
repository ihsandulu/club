<?php

namespace App\Models\Master;

use App\Models\Core_m;

class Mclass_m extends Core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek class
        if ($this->request->getVar("class_id")) {
            $classd["class_id"] = $this->request->getVar("class_id");
        } else {
            $classd["class_id"] = 0;
        }
        $us = $this->db
            ->table("class")
            ->getWhere($classd);
        /* echo $this->db->getLastquery();
        die; */
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $class) {
                foreach ($this->db->getFieldNames('class') as $field) {
                    $data[$field] = $class->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('class') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadclass_picture'] = "";
        if (isset($_FILES['class_picture']) && $_FILES['class_picture']['name'] != "") {
            $avatar = $this->request->getFile('class_picture');
            $validated = $this->validate([
                'file' => [
                    'uploaded[class_picture]',
                    'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[file,4096]',
                ],
            ]);

            $msg = 'Please select a valid file';

            if ($validated) {
                $newName = $avatar->getRandomName();
                $avatar->move(ROOTPATH . 'images/class_picture', $newName);
                $msg = 'File has been uploaded';
                $input['class_picture'] = $newName;
            }
            $data['uploadclass_picture'] = $msg;
            // dd($data);
        }

        /*  if (isset($_FILES['class_picture']) && $_FILES['class_picture']['name'] != "") {
            $class_picture = str_replace(' ', '_', $_FILES['class_picture']['name']);
            $class_picture = date("H_i_s_") . $class_picture;
            if (file_exists('images/class_picture/' . $class_picture)) {
                unlink('images/class_picture/' . $class_picture);
            }
            $config['file_name'] = $class_picture;
            $config['upload_path'] = 'images/class_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('class_picture')) {
                $data['uploadclass_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadclass_picture'] = "Upload Success !";
                $input['class_picture'] = $class_picture;
            }
        } */

        //delete
        if ($this->request->getVar("delete") == "OK") {
            $this->db
                ->table("class")
                ->delete(array("class_id" => $this->request->getVar("class_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'class_id' && $e != 'class') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // dd($input);
            $this->db->table('class')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'class_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('class')->update($input, array("class_id" => $this->request->getVar("class_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
