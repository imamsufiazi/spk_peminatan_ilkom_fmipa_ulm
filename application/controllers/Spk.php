<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends CI_Controller
{
    //halaman home
    /////////////////////////////////////////////
    public function index()
    {   
        //cek apakah user sudah ada session atau belum
        if($this->session->userdata('nim'))
        {
            //bersihkan data session
            $this->selesai();
        }
        
        //set rules untuk form validation nim dan nama
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|numeric', [
            'required' => 'NIM kosong, silahkan isi!',
            'numeric' => 'NIM harus angka!'
            ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Nama kosong, silahkan isi!'
            ]);
            
        //cek apakah form validation pada form user sudah berjalan atau belum
        if ($this->form_validation->run() == false)
        {
            $data['title'] = 'SPK - Peminatan Mahasiswa Ilkom';
            $this->load->view('templates/spk_header', $data);
            $this->load->view('spk/home');
            $this->load->view('templates/spk_footer');
        }
        else
        {
            //masukkan data inputan di view ke $data
            $data = [
                'nim' => htmlspecialchars($this->input->post('nim', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'tgl_dibuat' => time()
            ];
            
            //menyimpan data inputan di view ke variable nim
            $nim = $this->input->post('nim');
            $nama = $this->input->post('nama');
            
            //ambil data user didatabase untuk cek apakah sudah ada data atau belum
            $ceknim = $this->db->get_where('tbl_user', ['nim' => $nim])->row_array();
            $ceknama = $this->db->get_where('tbl_user', ['nama' => $nama])->row_array();
            
            //jika user sudah ada didatabase
            if ($ceknim)
            {
                //jika data nim dan nama sudah ada didatabase
                if($ceknama)
                {
                    //masukkan data nim dan nama ke session
                    $this->session->set_userdata($data);
                    
                    //tampilkan halaman hasil
                    redirect('spk/hasil');
                }
                //jika nim sudah ada, namun nama salah
                else
                {
                    //jika nama dan nim beda, tampilkan pesan
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger text-center" role="alert">NIM sudah terdaftar, namun Nama anda salah!</div>');
                    //kembalikan ke halaman home
                    redirect('spk/');
                }
            }
            //jika user belum ada didatabase
            else
            {
                //insert ke database tb_user
                $this->db->insert('tbl_user', $data);
                
                //masukkan data nim dan nama ke session
                $this->session->set_userdata($data);
                
                //arahkan ke halaman input1
                redirect('spk/input');
            }
        }
    }
    
    //halaman input nilai
    ////////////////////////////////////////////////
    
    public function input()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('nim'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('spk/');
        }
        
        //mengirimkan data title
        $data['title'] = 'Input Nilai Matkul - Peminatan Mahasiswa Ilkom';
        //ngambil data dari session
        $data['tbluser'] = $this->db->get_where('tbl_user', ['nim' => $this->session->userdata('nim')])->row_array();
        
        //set rules untuk form validation matkul1-16
        for($a=1; $a<17; $a++)
        {
            $this->form_validation->set_rules('matkul'.$a, 'Matkul'.$a, 'required|trim', [
                'required' => 'Matkul ini kosong, silahkan pilih nilai!',
            ]);
        }
            
        //model untuk tampilkan matkul dan nilainya ke view dari db master
        $query_matkul = $this->db->get('tbl_matkul');
        $query_nilai = $this->db->get('tbl_nilai');
        //controller untuk tampilkan matkul dan nilainya ke view dari db master
        $data['matkul'] = $query_matkul->result();
        $data['nilai'] = $query_nilai->result();
        
        //cek apakah form validation pada form user sudah berjalan atau belum
        if ($this->form_validation->run() == false)
        {
            //load view
            $this->load->view('templates/spk_header', $data);
            $this->load->view('spk/input', $data);
            $this->load->view('templates/spk_footer');
        }
        else
        {
            //masukkan data inputan di view ke $data
            $data = [
                'nim' => $data['tbluser']['nim'],
                'mkn_1' => $this->input->post('matkul1', true),
                'mkn_2' => $this->input->post('matkul2', true),
                'mkn_3' => $this->input->post('matkul3', true),
                'mkn_4' => $this->input->post('matkul4', true),
                'mkn_5' => $this->input->post('matkul5', true),
                'mkn_6' => $this->input->post('matkul6', true),
                'mkn_7' => $this->input->post('matkul7', true),
                'mkn_8' => $this->input->post('matkul8', true),
                'mkn_9' => $this->input->post('matkul9', true),
                'mkn_10' => $this->input->post('matkul10', true),
                'mkn_11' => $this->input->post('matkul11', true),
                'mkn_12' => $this->input->post('matkul12', true),
                'mkn_13' => $this->input->post('matkul13', true),
                'mkn_14' => $this->input->post('matkul14', true),
                'mkn_15' => $this->input->post('matkul15', true),
                'mkn_16' => $this->input->post('matkul16', true)
            ];
            
            //insert ke database tbl_nilai_matkul
            $this->db->insert('tbl_nilai_matkul', $data);
            
            //panggil fungsi perhitungan saw
            $this->_perhitungan_saw();
            
            //jika berhasil, arahkan ke halaman hasil
            redirect('spk/hasil');
        }
    }

    //fungsi untuk konversi nilai huruf ke rating kecocokan tiap alternatif
    ///////////////////////////////////////////////////

    private function _perhitungan_saw()
    {
        //model untuk mengambil matkul dan nilai  dari db master
        $query_matkul = $this->db->query("SELECT mkn_1, mkn_2, mkn_3, mkn_4, mkn_5, mkn_6, mkn_7, mkn_8, mkn_9, mkn_10,
        mkn_11, mkn_12, mkn_13, mkn_14, mkn_15, mkn_16 FROM tbl_nilai_matkul WHERE nim = ".$_SESSION['nim']." ORDER BY id_nilai_matkul DESC LIMIT 1");
        
        //perhitungan rating kecocokan
        foreach ($query_matkul->result_array() as $nilai_matkul)
        {
            for($a=1; $a<17; $a++)
            {
                if($nilai_matkul['mkn_'.$a] == "A" || $nilai_matkul['mkn_'.$a] == "A-")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 4; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 5; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 4; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 5; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 4; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 5; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 3; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 4; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 5; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 4; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 3; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 4; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 3; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 3; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 5; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 5; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 3; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 4; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 4; }
                            else if ($a == 4) { $data['nalt2_kn_4'] = 4; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 4; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 4; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 5; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 5; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 5; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 5; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 5; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 5; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 5; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 5; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 4; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 5; }
                        }
                    }
                }
                else if($nilai_matkul['mkn_'.$a] == "B+" || $nilai_matkul['mkn_'.$a] == "B" || $nilai_matkul['mkn_'.$a] == "B-")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 3; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 5; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 4; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 3; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 4; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 4; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 3; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 3; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 5; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 4; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 3; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 4; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 3; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 3; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 5; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 4; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 2; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 4; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 3; }
                            else if ($a == 4) { $data['nalt2_mkn_4'] = 3; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 2; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 3; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 5; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 4; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 5; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 4; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 5; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 4; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 5; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 5; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 3; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 4; }
                        }
                    }
                }
                else if($nilai_matkul['mkn_'.$a] == "C+" || $nilai_matkul['mkn_'.$a] == "C")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 2; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 4; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 3; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 3; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 3; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 3; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 2; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 2; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 3; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 3; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 2; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 3; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 2; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 2; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 4; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 4; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 1; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 3; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 2; }
                            else if ($a == 4) { $data['nalt2_mkn_4'] = 2; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 2; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 2; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 4; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 3; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 4; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 3; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 4; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 4; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 4; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 4; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 2; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 3; }
                        }
                    }
                }
                else if($nilai_matkul['mkn_'.$a] == "D+" || $nilai_matkul['mkn_'.$a] == "D")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 2; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 3; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 2; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 2; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 2; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 2; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 2; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 1; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 2; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 2; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 1; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 2; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 1; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 1; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 3; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 3; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 1; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 2; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 1; }
                            else if ($a == 4) { $data['nalt2_mkn_4'] = 1; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 2; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 1; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 3; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 2; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 3; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 3; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 3; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 3; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 3; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 3; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 1; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 2; }
                        }
                    }
                }
                else if($nilai_matkul['mkn_'.$a] == "E")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 1; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 2; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 2; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 2; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 2; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 1; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 1; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 1; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 1; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 1; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 1; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 2; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 1; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 1; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 2; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 2; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 1; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 1; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 1; }
                            else if ($a == 4) { $data['nalt2_mkn_4'] = 1; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 1; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 1; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 2; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 2; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 1; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 2; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 2; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 3; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 3; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 3; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 1; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 1; }
                        }
                    }
                }
                else if($nilai_matkul['mkn_'.$a] == "-")
                {
                    for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
                    {
                        if($nalt_bool == 1)
                        {
                            if($a == 1) { $data['nalt1_mkn_1'] = 0; }
                            else if ($a == 2) { $data['nalt1_mkn_2'] = 0; }
                            else if ($a == 3) { $data['nalt1_mkn_3'] = 0; }
                            else if ($a == 4) { $data['nalt1_mkn_4'] = 0; }
                            else if ($a == 5) { $data['nalt1_mkn_5'] = 0; }
                            else if ($a == 6) { $data['nalt1_mkn_6'] = 0; }
                            else if ($a == 7) { $data['nalt1_mkn_7'] = 0; }
                            else if ($a == 8) { $data['nalt1_mkn_8'] = 0; }
                            else if ($a == 9) { $data['nalt1_mkn_9'] = 0; }
                            else if ($a == 10) { $data['nalt1_mkn_10'] = 0; }
                            else if ($a == 11) { $data['nalt1_mkn_11'] = 0; }
                            else if ($a == 12) { $data['nalt1_mkn_12'] = 0; }
                            else if ($a == 13) { $data['nalt1_mkn_13'] = 0; }
                            else if ($a == 14) { $data['nalt1_mkn_14'] = 0; }
                            else if ($a == 15) { $data['nalt1_mkn_15'] = 0; }
                            else if ($a == 16) { $data['nalt1_mkn_16'] = 0; }
                        }
                        else if($nalt_bool == 2)
                        {
                            if($a == 1) { $data['nalt2_mkn_1'] = 0; }
                            else if ($a == 2) { $data['nalt2_mkn_2'] = 0; }
                            else if ($a == 3) { $data['nalt2_mkn_3'] = 0; }
                            else if ($a == 4) { $data['nalt2_mkn_4'] = 0; }
                            else if ($a == 5) { $data['nalt2_mkn_5'] = 0; }
                            else if ($a == 6) { $data['nalt2_mkn_6'] = 0; }
                            else if ($a == 7) { $data['nalt2_mkn_7'] = 0; }
                            else if ($a == 8) { $data['nalt2_mkn_8'] = 0; }
                            else if ($a == 9) { $data['nalt2_mkn_9'] = 0; }
                            else if ($a == 10) { $data['nalt2_mkn_10'] = 0; }
                            else if ($a == 11) { $data['nalt2_mkn_11'] = 0; }
                            else if ($a == 12) { $data['nalt2_mkn_12'] = 0; }
                            else if ($a == 13) { $data['nalt2_mkn_13'] = 0; }
                            else if ($a == 14) { $data['nalt2_mkn_14'] = 0; }
                            else if ($a == 15) { $data['nalt2_mkn_15'] = 0; }
                            else if ($a == 16) { $data['nalt2_mkn_16'] = 0; }
                        }
                    }
                }

                //echo 'Nilai Alt1 C'.$a.' : '.$data['nalt1_mkn_'.$a]."<br/>";
                //echo 'Nilai Alt2 C'.$a.' : '.$data['nalt2_mkn_'.$a]."<br/>";
                //echo 'Nilai Huruf C'.$a.' : '.$nilai_matkul['mkn_'.$a]."<br/><br/>";
            }
        }

        //perhitungan normalisasi
        for($a=1; $a<17; $a++)
        {
            //perulangan peminatan alternatif
            for($nalt_bool=1; $nalt_bool<3; $nalt_bool++)
            {
                //alternatif 1
                if($nalt_bool == 1)
                {
                    if($data['nalt1_mkn_'.$a] > $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt1_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt1_mkn_'.$a] = ($data['nalt1_mkn_'.$a]/$data['nalt1_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt1_mkn_'.$a] = 0;    
                        }
                    }
                    else if($data['nalt1_mkn_'.$a] < $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt2_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt1_mkn_'.$a] = ($data['nalt1_mkn_'.$a]/$data['nalt2_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt1_mkn_'.$a] = 0;    
                        }
                    }
                    else if($data['nalt1_mkn_'.$a] == $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt1_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt1_mkn_'.$a] = ($data['nalt1_mkn_'.$a]/$data['nalt1_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt1_mkn_'.$a] = 0;    
                        }
                    }
                }
                //alternatif 2
                else if($nalt_bool == 2)
                {
                    if($data['nalt1_mkn_'.$a] > $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt1_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt2_mkn_'.$a] = ($data['nalt2_mkn_'.$a]/$data['nalt1_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt2_mkn_'.$a] = 0;
                        }
                    }
                    else if($data['nalt1_mkn_'.$a] < $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt2_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt2_mkn_'.$a] = ($data['nalt2_mkn_'.$a]/$data['nalt2_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt2_mkn_'.$a] = 0;
                        }
                    }
                    else if($data['nalt1_mkn_'.$a] == $data['nalt2_mkn_'.$a])
                    {
                        if($data['nalt2_mkn_'.$a] != 0)
                        {
                            $data['matriks_alt2_mkn_'.$a] = ($data['nalt2_mkn_'.$a]/$data['nalt2_mkn_'.$a]);
                        }
                        else
                        {
                            $data['matriks_alt2_mkn_'.$a] = 0;
                        }
                    }
                }
                //echo "Matrik alt ".$nalt_bool.", matkul ".$a." : ".$data['matriks_alt'.$nalt_bool.'_mkn_'.$a]."<br/><br/>";
            }
        }

        //model untuk mengambil bobot dari db master
        $query_bobot = $this->db->query("SELECT mkb_1, mkb_2, mkb_3, mkb_4, mkb_5, mkb_6, mkb_7, mkb_8, mkb_9, mkb_10,
        mkb_11, mkb_12, mkb_13, mkb_14, mkb_15, mkb_16 FROM tbl_bobot WHERE id_bobot = 'B01'");

        //perhitungan bobot tiap alternatif
        foreach ($query_bobot->result_array() as $bobot)
        {
            for($alt=1; $alt<3; $alt++)
            {
                if($alt == 1)
                {
                    $data['nilai_akhir_alt1'] =
                    (($data['matriks_alt1_mkn_1'] * $bobot['mkb_1']) +
                    ($data['matriks_alt1_mkn_2'] * $bobot['mkb_2']) +
                    ($data['matriks_alt1_mkn_3'] * $bobot['mkb_3']) +
                    ($data['matriks_alt1_mkn_4'] * $bobot['mkb_4']) +
                    ($data['matriks_alt1_mkn_5'] * $bobot['mkb_5']) +
                    ($data['matriks_alt1_mkn_6'] * $bobot['mkb_6']) +
                    ($data['matriks_alt1_mkn_7'] * $bobot['mkb_7']) +
                    ($data['matriks_alt1_mkn_8'] * $bobot['mkb_8']) +
                    ($data['matriks_alt1_mkn_9'] * $bobot['mkb_9']) +
                    ($data['matriks_alt1_mkn_10'] * $bobot['mkb_10']) +
                    ($data['matriks_alt1_mkn_11'] * $bobot['mkb_11']) +
                    ($data['matriks_alt1_mkn_12'] * $bobot['mkb_12']) +
                    ($data['matriks_alt1_mkn_13'] * $bobot['mkb_13']) +
                    ($data['matriks_alt1_mkn_14'] * $bobot['mkb_14']) +
                    ($data['matriks_alt1_mkn_15'] * $bobot['mkb_15']) +
                    ($data['matriks_alt1_mkn_16'] * $bobot['mkb_16']));
                }
                else if($alt == 2)
                {
                    $data['nilai_akhir_alt2'] =
                    (($data['matriks_alt2_mkn_1'] * $bobot['mkb_1']) +
                    ($data['matriks_alt2_mkn_2'] * $bobot['mkb_2']) +
                    ($data['matriks_alt2_mkn_3'] * $bobot['mkb_3']) +
                    ($data['matriks_alt2_mkn_4'] * $bobot['mkb_4']) +
                    ($data['matriks_alt2_mkn_5'] * $bobot['mkb_5']) +
                    ($data['matriks_alt2_mkn_6'] * $bobot['mkb_6']) +
                    ($data['matriks_alt2_mkn_7'] * $bobot['mkb_7']) +
                    ($data['matriks_alt2_mkn_8'] * $bobot['mkb_8']) +
                    ($data['matriks_alt2_mkn_9'] * $bobot['mkb_9']) +
                    ($data['matriks_alt2_mkn_10'] * $bobot['mkb_10']) +
                    ($data['matriks_alt2_mkn_11'] * $bobot['mkb_11']) +
                    ($data['matriks_alt2_mkn_12'] * $bobot['mkb_12']) +
                    ($data['matriks_alt2_mkn_13'] * $bobot['mkb_13']) +
                    ($data['matriks_alt2_mkn_14'] * $bobot['mkb_14']) +
                    ($data['matriks_alt2_mkn_15'] * $bobot['mkb_15']) +
                    ($data['matriks_alt2_mkn_16'] * $bobot['mkb_16']));
                }
            }
        }

        //perhitungan presentase alternatif
        for($alt=1; $alt<3; $alt++)
        {
            if($alt == 1)
            {
                $data['presentase_alt1'] = (($data['nilai_akhir_alt1']/64)*100);
            }
            else if($alt == 2)
            {
                $data['presentase_alt2'] = (($data['nilai_akhir_alt2']/64)*100);
            }
        }

        //masukkan data perhitungan ke variabel data
        $data['inputdb'] = [
            'nim' => $_SESSION['nim'],
            'minat_ds' => $data['nilai_akhir_alt1'],
            'minat_se' => $data['nilai_akhir_alt2'],
            'persen_ds' => $data['presentase_alt1'],
            'persen_se' => $data['presentase_alt2'],
            'tgl_update' => time()
        ];

        //insert ke database tbl_hasil
        $this->db->insert('tbl_hasil', $data['inputdb']);
    } 
    
    //halaman hasil
    //////////////////////////////////////////////////
    
    public function hasil()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('nim'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('spk/');
        }
        
        //mengirimkan table title
        $data['title'] = 'Hasil - Peminatan Mahasiswa Ilkom';
        //ngambil data dari session
        $data['tbluser'] = $this->db->get_where('tbl_user', ['nim' => $this->session->userdata('nim')])->row_array();
        
        //mengambil data hasil dari table hasil database
        $data['hasil'] = $this->db->query("SELECT minat_ds, minat_se, persen_ds, persen_se FROM tbl_hasil WHERE nim = ".$_SESSION['nim']." ORDER BY id_hasil DESC LIMIT 1")->row_array();


        $this->load->view('templates/spk_header', $data);
        $this->load->view('spk/hasil', $data);
        $this->load->view('templates/spk_footer');
    }
    
    //untuk menghapus session user
    ///////////////////////////////////////////////////
    
    public function selesai()
    {
        //bersihkan data session
        $this->session->unset_userdata('nim');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('tgl_dibuat');
    
        //jika keluar berhasil, redirect ke halaman home
        $this->session->set_flashdata('pesan', '<div class="alert alert-success text-center" role="alert">Selamat! Anda telah selesai!</div>');
        redirect('spk/');
    }
}