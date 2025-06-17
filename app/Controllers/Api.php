<?php

namespace App\Controllers;



class Api extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\Global_m();
        $sesi_user->ceksesi();
    }

    public function index()
    {
        echo "Halaman tidak ditemukan!";
    }

    public function pilihpoin()
    {
        $ujian_id=$this->request->getGet("ujian_id");?>
        <option value="0">Pilih Poin Penilaian</option>
        <?php $build = $this->db->table("ujiand")->where("ujian_id",$ujian_id);
        if (session()->get("position_id") > -1) {
            $build->where("schools_id", session()->get("schools_id"));
        }
        $ujiand = $build->get();
        foreach ($ujiand->getResult() as $row) { ?>
            <option value="<?= $row->ujiand_id; ?>"><?= $row->ujiand_name; ?></option>
        <?php } ?>
        <?php
    }
    public function poindelete()
    {
        $ujiand_id = $this->request->getVar("ujiand_id");
        $ujian_id = $this->request->getVar("ujian_id");
        $where["ujiand_id"] = $ujiand_id;
        $this->db->table("ujiand")
            ->delete($where);
        // echo $this->db->getLastQuery();die;
        $ujiand = $this->db->table("ujiand")->where("ujian_id", $ujian_id)->get();
        foreach ($ujiand->getResult() as $row) { ?>
            <span onclick="poindelete(<?= $row->ujiand_id; ?>,<?= $ujian_id; ?>)" class="btn btn-danger fa fa-times"></span> <?= $row->ujiand_name; ?>,
        <?php }
    }

    public function submitpoin()
    {
        $ujian_id = $this->request->getVar("ujian_id");
        $schools_id = $this->request->getVar("schools_id");
        $input["ujian_id"] = $ujian_id;
        $input["schools_id"] = $schools_id;
        $input["ujiand_name"] = $this->request->getVar("ujiand_name");

        $this->db->table("ujiand")
            ->insert($input);
        // echo $this->db->getLastQuery();die;
        $ujiand = $this->db->table("ujiand")->where("ujian_id", $ujian_id)->get();
        foreach ($ujiand->getResult() as $row) { ?>
            <span onclick="poindelete(<?= $row->ujiand_id; ?>,<?= $ujian_id; ?>)" class="btn btn-danger fa fa-times"></span> <?= $row->ujiand_name; ?>,
        <?php }
    }

    public function listclass()
    {
        $schools_id = $this->request->getVar("schools_id");
        $user_class = $this->request->getVar("user_class");
        ?>
        <option value="" <?= ($user_class == "") ? "selected" : ""; ?>>Pilih Kelas</option>
        <?php
        $class = $this->db->table("class")
            ->where("schools_id", $schools_id)
            ->orderBy("class_id", "asc")->get();
        foreach ($class->getResult() as $class) { ?>
            <option value="<?= $class->class_id; ?>" <?= ($class == $class->class_id) ? "selected" : ""; ?>><?= $class->class_name; ?></option>
        <?php } ?>
<?php }

    public function getusertime()
    {

        date_default_timezone_set("Asia/Bangkok");

        $jenis = $this->request->getVar("jenis");
        $us = "user_" . $jenis . "time";
        $sc = "schools_w" . $jenis;

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

        if ($data[$us] > '00:00:00') {
            $bataswaktu = $data[$us];
            $pilih = $us;
        } else {
            $bataswaktu = $data[$sc];
            $pilih = $sc;
        }
        $waktu = explode(":", $bataswaktu);
        $tampil = date("Y-m-d H:i:s", strtotime("+" . $waktu[0] . " hour +" . $waktu[1] . " minutes", strtotime(date("Y-m-d H:i:s"))));
        // echo $tampil . "=" . $pilih;
        echo $tampil;
    }

    public function usertime()
    {
        $jenis = $this->request->getVar("jenis");
        $input[$jenis] = $this->request->getVar("isijenis");
        $where["user_id"] = $this->request->getVar("user_id");
        $this->db->table("user")->update($input, $where);
    }


    /////////////////////////////////////////////////////////
    //mbti 
    public function hasilmbti()
    {
        $rmbti_hasil = $this->request->getVar("rmbti_hasil");
        $builder = $this->db->table("rmbti");
        $rmbti = $builder->where("rmbti_hasil", $rmbti_hasil)->get();
        if ($rmbti->getNumRows() > 0) {
            foreach ($rmbti->getResult() as $rmbti) {
                foreach ($this->db->getFieldNames('rmbti') as $field) {
                    $data[$field] = $rmbti->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('rmbti') as $field) {
                $data[$field] = "";
            }
        }
        echo json_encode($data);
    }

    public function cekhasilmbti()
    {
        $rmbti_hasil = $this->request->getVar("rmbti_hasil");
        $builder = $this->db->table("rmbti");
        $usr = $builder->where("rmbti_hasil", $rmbti_hasil)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function ceknombti()
    {
        $no = $this->request->getVar("mmbti_questionno");
        $builder = $this->db->table("mmbti");
        $usr = $builder->where("mmbti_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function savembti()
    {
        foreach ($this->request->getVar() as $e => $f) {
            if ($e != 'create' && $e != 'mmbti_id') {
                $input[$e] = $this->request->getVar($e);
            }
        }
        //cek jawaban
        $jawaban = $this->db->table("mmbti");
        $ja = $jawaban->where("mmbti_questionno", $input['mmbti_questionno'])->get();
        foreach ($ja->getResult() as $ja) {
            if ($input['ambti_answer'] == "A") {
                $input["ambti_type"] = $ja->mmbti_typea;
            }
            if ($input['ambti_answer'] == "B") {
                $input["ambti_type"] = $ja->mmbti_typeb;
            }
        }

        $where["ambti.user_id"] = $input['user_id'];
        $where["ambti.mmbti_questionno"] = $input['mmbti_questionno'];
        $builder = $this->db->table("ambti");
        $usr = $builder
            ->getWhere($where);
        if ($usr->getNumRows() > 0) {
            $this->db->table('ambti')->update($input, $where);
        } else {
            $this->db->table('ambti')->insert($input);
        }
        //echo $this->db->getLastquery();

        //cek jawaban apakah selesai semua?
        $selesai = $this->db->table("ambti");
        echo $null = $selesai->where("user_id", $input['user_id'])
            ->where("schools_id", $input['schools_id'])
            ->get()
            ->getNumRows();
        // echo $this->db->getLastquery();
    }


    /////////////////////////////////////////////////////////
    //sds 


    public function ceknosds()
    {
        $no = $this->request->getVar("msds_questionno");
        $builder = $this->db->table("msds");
        $usr = $builder->where("msds_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }


    public function cekhasilsds()
    {
        $rsds_minat = $this->request->getVar("rsds_minat");
        $builder = $this->db->table("rsds");
        $usr = $builder->where("rsds_minat", $rsds_minat)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function savesds()
    {
        foreach ($this->request->getVar() as $e => $f) {
            if ($e != 'create' && $e != 'msds_id') {
                $input[$e] = $this->request->getVar($e);
            }
        }
        //cek jawaban
        $jawaban = $this->db->table("msds");
        $ja = $jawaban->where("msds_questionno", $input['msds_questionno'])->get();
        foreach ($ja->getResult() as $ja) {
            if ($input['asds_answer'] == "O") {
                $input["asds_type"] = $ja->msds_typeo;
            }
            if ($input['asds_answer'] == "X") {
                $input["asds_type"] = $ja->msds_typex;
            }
        }

        $where["asds.user_id"] = $input['user_id'];
        $where["asds.msds_questionno"] = $input['msds_questionno'];
        $builder = $this->db->table("asds");
        $usr = $builder
            ->getWhere($where);
        //echo $this->db->getLastquery();
        if ($usr->getNumRows() > 0) {
            $this->db->table('asds')->update($input, $where);
        } else {
            $this->db->table('asds')->insert($input);
        }
        //echo $this->db->getLastquery();

        //cek jawaban apakah selesai semua?
        $selesai = $this->db->table("asds");
        echo $null = $selesai->where("user_id", $input['user_id'])
            ->where("schools_id", $input['schools_id'])
            ->get()
            ->getNumRows();
        // echo $this->db->getLastquery();

    }

    public function hasilsds()
    {
        $rsds_minat = $this->request->getVar("rsds_minat");
        $builder = $this->db->table("rsds");
        $rsds = $builder->where("rsds_minat", $rsds_minat)->get();
        if ($rsds->getNumRows() > 0) {
            foreach ($rsds->getResult() as $rsds) {
                foreach ($this->db->getFieldNames('rsds') as $field) {
                    $data[$field] = $rsds->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('rsds') as $field) {
                $data[$field] = "";
            }
        }
        echo json_encode($data);
    }


    /////////////////////////////////////////////////////////
    //papi 

    public function ceknopapi()
    {
        $no = $this->request->getVar("mpapi_questionno");
        $builder = $this->db->table("mpapi");
        $usr = $builder->where("mpapi_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function savepapi()
    {
        foreach ($this->request->getVar() as $e => $f) {
            if ($e != 'create' && $e != 'mpapi_id') {
                $input[$e] = $this->request->getVar($e);
            }
        }
        //cek jawaban        
        $input["apapi_type"] = $input['apapi_answer'];
        $where["apapi.user_id"] = $input['user_id'];
        $where["apapi.mpapi_questionno"] = $input['mpapi_questionno'];
        $builder = $this->db->table("apapi");
        $usr = $builder
            ->getWhere($where);
        //echo $this->db->getLastquery();
        if ($usr->getNumRows() > 0) {
            $this->db->table('apapi')->update($input, $where);
        } else {
            $this->db->table('apapi')->insert($input);
        }
        //echo $this->db->getLastquery();

        //cek jawaban apakah selesai semua?
        $selesai = $this->db->table("apapi");
        echo  $selesai->where("user_id", $input['user_id'])
            ->where("schools_id", $input['schools_id'])
            ->get()
            ->getNumRows();
        // echo $this->db->getLastQuery();
    }

    //////////////////////////

    public function saveist()
    {
        foreach ($this->request->getVar() as $e => $f) {
            if ($e != 'create' && $e != 'mse_id') {
                $input[$e] = $this->request->getVar($e);
            }
        }
        //cek jawaban        
        $input["aist.rist_age"] = $this->session->get("age");
        $where["aist.rist_code"] = $input['rist_code'];
        $where["aist.user_id"] = $input['user_id'];
        $where["aist.mist_questionno"] = $input['mist_questionno'];
        $builder = $this->db->table("aist");
        $usr = $builder
            ->getWhere($where);

        if ($input["rist_code"] == "GE") {

            $input["aist_nilai"] = 0;
            $input["aist_type"] = "";

            $mge = $this->db->table("mge")
                ->orWhere("FIND_IN_SET('" . $input['aist_answer'] . "',mge_1) <>", "0")
                ->get();
            foreach ($mge->getResult() as $mge) {
                $input["aist_nilai"] = 1;
                $input["aist_type"] = $input['aist_answer'];
            }
            $mge = $this->db->table("mge")
                ->where("FIND_IN_SET('" . $input['aist_answer'] . "',mge_2) <>", "0")
                ->get();
            foreach ($mge->getResult() as $mge) {
                $input["aist_nilai"] = 2;
                $input["aist_type"] = $input['aist_answer'];
            }
        }
        /* echo $this->db->getLastquery();
        die; */
        if ($usr->getNumRows() > 0) {
            $this->db->table('aist')->update($input, $where);
        } else {
            $this->db->table('aist')->insert($input);
        }
        //echo $this->db->getLastquery();

        //cek jawaban apakah selesai semua?
        $selesai = $this->db->table("aist");
        echo  $selesai->where("user_id", $input['user_id'])
            ->where("schools_id", $input['schools_id'])
            ->get()
            ->getNumRows();
        // echo $this->db->getLastQuery();

    }

    //////////////////////////
    //SE 

    public function ceknose()
    {
        $no = $this->request->getVar("mse_questionno");
        $builder = $this->db->table("mse");
        $usr = $builder->where("mse_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //WA 

    public function ceknowa()
    {
        $no = $this->request->getVar("mwa_questionno");
        $builder = $this->db->table("mwa");
        $usr = $builder->where("mwa_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //an 

    public function ceknoan()
    {
        $no = $this->request->getVar("man_questionno");
        $builder = $this->db->table("man");
        $usr = $builder->where("man_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //ge 

    public function ceknoge()
    {
        $no = $this->request->getVar("mge_questionno");
        $builder = $this->db->table("mge");
        $usr = $builder->where("mge_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //me 

    public function ceknome()
    {
        $no = $this->request->getVar("mme_questionno");
        $builder = $this->db->table("mme");
        $usr = $builder->where("mme_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //ra 

    public function ceknora()
    {
        $no = $this->request->getVar("mra_questionno");
        $builder = $this->db->table("mra");
        $usr = $builder->where("mra_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //zr 

    public function ceknozr()
    {
        $no = $this->request->getVar("mzr_questionno");
        $builder = $this->db->table("mzr");
        $usr = $builder->where("mzr_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //fa 

    public function ceknofa()
    {
        $no = $this->request->getVar("mfa_questionno");
        $builder = $this->db->table("mfa");
        $usr = $builder->where("mfa_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////
    //wu 

    public function ceknowu()
    {
        $no = $this->request->getVar("mwu_questionno");
        $builder = $this->db->table("mwu");
        $usr = $builder->where("mwu_questionno", $no)->get();
        if ($usr->getNumRows() > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }



    //////////////////////////








    public function carisekolah()
    {
        $where["schools_no"] = $this->request->getVar("schools_no");
        $cari = $this->db->table("schools")
            ->getWhere($where);
        $id = 0;
        foreach ($cari->getResult() as  $cari) {
            $id = $cari->schools_id;
        }
        echo $id;
    }
}
