<?php

namespace App\Models;

class Login_m extends Core_m
{
    function hitung_umur($tanggal_lahir)
    {
        date_default_timezone_set("Asia/Bangkok");
        $birthDate = new \DateTime($tanggal_lahir);
        $today = new \DateTime("today");
        if ($birthDate > $today) {
            exit("0 tahun 0 bulan 0 hari");
        }
        $y = $today->diff($birthDate)->y;
        $m = $today->diff($birthDate)->m;
        $d = $today->diff($birthDate)->d;
        /*  return $y .
        " tahun " . $m .
        " bulan " . $d .
        " hari"; */
        return $y;
    }
    public function index()
    {
        // dd($this->request->getVar());
        //require_once("meta_m.php");
        $data = array();
        $data["message"] = "";
        $data["hasil"] = "";
        $data['masuk'] = 0;


        $domain = $_SERVER['HTTP_HOST'];
        $parts = explode('.', $domain);
        $countpart = count($parts);

        $identity = $this->db->table("identity")->get()->getRow();
        $data["schools_nname"] = "Club";
        $data["schools_tagline"] = "Kelola Klub, Tanpa Repot.";
        $data["schools_logo"] = base_url("images/identity_picture/" . $identity->identity_picture);
        if ((isset($_GET["schools_nname"]) && $_GET["schools_nname"] != "") || ($countpart > 0)) {
            if (isset($_GET["schools_nname"]) && $_GET["schools_nname"] != "") {
                $ischools_nname = $_GET["schools_nname"];
            }
            if ( $parts[0]!= "club" && $countpart > 0) {
                $ischools_nname = $parts[0];
            }
            $schools = $this->db->table("schools")
                ->where("schools_nname", $ischools_nname)
                ->get();
            // echo $this->db->getLastQuery();die;
            foreach ($schools->getResult() as $school) {
                foreach ($this->db->getFieldNames('schools') as $field) {
                    $data[$field] = $school->$field;
                    $data["schools_logo"] = base_url("images/schools_logo/" . $school->schools_logo);
                }
            }
        }
        // dd($data);

        // echo "ngaco";die;
        if (isset($_POST["user_phone"]) && isset($_POST["user_token"])) {
            if (isset($_GET["schools_nname"]) && $_GET["schools_nname"] != "") {
                $input["schools_nname"] = $_GET["schools_nname"];
            }
            $input["user_phone"] = $this->request->getVar("user_phone");
            $user1 = $this->db
                ->table("user")
                ->join("schools", "schools.schools_id=user.schools_id", "left")
                ->getWhere($input);
            // echo $this->db->getLastQuery();die;
            //echo $user1->getNumRows();die;
            if ($user1->getNumRows() > 0) {
                foreach ($user1->getResult() as $user) {
                    $user_token = $user->user_token;
                    // echo $this->request->getVar("user_token")." == ".$user_token;die;
                    if ($this->request->getVar("user_token") == $user_token) {

                        //cek aktif
                        $active = $this->db->table("schools")
                            ->where("schools_active", "1")
                            ->where("schools_id", $user->schools_id)
                            ->get();
                        if ($active->getNumRows() > 0 ||  $user->position_id == 1 ||  $user->position_id == -1) {

                            foreach ($this->db->getFieldNames('user') as $field) {
                                $this->session->set($field, $user->$field);
                            }
                            foreach ($this->db->getFieldNames('schools') as $field) {
                                $data[$field] = $user->$field;
                            }
                            if ($user->position_id > -1) {
                                $data["schools_logo"] = base_url("images/schools_logo/" . $user->schools_logo);
                                $data["schools_nname"] = $user->schools_nname;
                                $data["schools_tagline"] = $user->schools_tagline;
                            } else {
                                $data["schools_nname"] = "Club";
                                $data["schools_tagline"] = "Kelola Klub, Tanpa Repot.";
                                $data["schools_logo"] = base_url("images/identity_picture/" . $identity->identity_picture);
                            }
                            // dd($data);
                            foreach ($data as $key => $value) {
                                $this->session->set($key, $value);
                            }

                            $umur = $this->hitung_umur($user->user_birthdate);
                            $this->session->set("age", $umur);

                            $identity = $this->db->table("identity")->get();
                            foreach ($identity->getResult() as $identity) {
                                foreach ($this->db->getFieldNames('identity') as $field) {
                                    $this->session->set($field, $identity->$field);
                                }
                            }

                            /*
                            $this->session->set("branch_name",$user->branch_name);
                            $this->load->library("email");
                            $this->email->from("admin@cargoplus.co.id","admin");
                            $this->email->to($user->username;);
                            $this->email->subject("Login");
                            $this->email->message("Selamat anda berhasil Login.");
                            $this->email->send();
                            */
                            $data["hasil"] = " Welcome  " . $user->user_name;
                            $this->session->setFlashdata('hasil', $data["hasil"]);
                            $data['masuk'] = 1;
                        } else {
                            $data["hasil"] = " There are no active Club! Please contact " . $identity->identity_phone;
                        }
                    } else {
                        $data["hasil"] = " Wrong Token Number !";
                    }
                }
            } else {
                $data["hasil"] = " User Not Found !";
            }
        }
        $this->session->setFlashdata('message', $data["hasil"]);

        //upload anggota image
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

        //insert anggota
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'message') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["user_token"] = rand(1000, 9999) . date("md");
            // dd($input);
            $this->db->table('user')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Token akan diberikan Admin via whatsapp!";
            $this->session->setFlashdata('message', $data["message"]);
        }

        //upload club logo
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
                $inputschools['schools_logo'] = $newName;
            }
            $data['uploadschools_logo'] = $msg;
        }

        //insert club
        if ($this->request->getPost("createclub") == "OK") {
            //club
            $inputschools["schools_name"] = $this->request->getPost("schools_name");
            $inputschools["schools_nname"] = $this->request->getPost("schools_nname");

            $inputschools["schools_address"] = $this->request->getPost("schools_address");
            $inputschools["schools_no"] = date("Ymd") . rand(100, 999);

            $inputschools["schools_register"] = 1;
            $inputschools["schools_score"] = 1;
            $inputschools["schools_bill"] = 1;

            $inputschools["schools_date"] = date("Y-m-d");
            $inputschools["schools_tagline"] = $this->request->getPost("schools_tagline");
            $inputschools["schools_no"] = rand(1000, 9999) . date("md");
            // dd($inputschools);
            $this->db->table('schools')->insert($inputschools);
            $school_id = $this->db->insertID();


            //user admin
            $input["position_id"] = 1;
            $input["schools_id"] = $school_id;
            $input["user_name"] = $this->request->getPost("user_name");
            $input["user_gender"] = $this->request->getPost("user_gender");
            $input["user_phone"] = $this->request->getPost("user_phone");
            $input["user_birthdate"] = $this->request->getPost("user_birthdate");
            $input["user_token"] = rand(1000, 9999) . date("md");
            // dd($input);
            $this->db->table('user')->insert($input);


            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Token akan diberikan Admin via whatsapp!";
            $this->session->setFlashdata('message', $data["message"]);
        }

        return $data;
    }
}
