<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    //halaman login admin
    public function index()
    {
        //cek apakah user sudah ada session atau belum
        if($this->session->userdata('email'))
        {
            //bersihkan data session
            $this->logout();
        }
        
        //set rules untuk form validation email dan password
        $this->form_validation->set_rules('email', 'Email', 'required|trim', [
            'required' => 'Email kosong, silahkan isi!'
            ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password kosong, silahkan isi!'
            ]);
            
        //cek apakah form validation pada form user sudah berjalan atau belum
        if ($this->form_validation->run() == false)
        {
            $data['title'] = 'Login Admin - Peminatan Mahasiswa Ilkom';
            $this->load->view('templates/spk_header', $data);
            $this->load->view('admin/login');
            $this->load->view('templates/spk_footer');
        }
        else
        {
            //masukkan data inputan di view ke $data
            $data = [
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => $this->input->post('password', true)
            ];

            //menyimpan data inputan di view ke variable email
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            //ambil data admin didatabase untuk cek apakah ada data
            $cekemail = $this->db->get_where('tbl_admin', ['email' => $email])->row_array();
            $cekpassword = $this->db->get_where('tbl_admin', ['password' => $password])->row_array();

            //jika email sudah ada didatabase
            if ($cekemail)
            {
                //jika password ada didatabase
                if($cekpassword)
                {
                    //masukkan data email ke session
                    $this->session->set_userdata($data);
                    
                    //tampilkan halaman hasil
                    redirect('admin/dashboard');
                }
                //jika email ada, namun password salah
                else
                {
                    //jika email dan password beda, tampilkan pesan
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger text-center" role="alert">Email atau password anda salah!</div>');
                    //kembalikan ke halaman login admin
                    redirect('admin/');
                }
            }
        }
    }

    //halaman dashboard admin
    public function dashboard()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('email'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('admin/');
        }
        
        //title untuk halaman nilai matakuliah
        $data['title'] = 'Dashboard Admin - Peminatan Mahasiswa Ilkom';
        $data['title_topbar'] = 'DASHBOARD ADMIN';

        //mengambil data dari session yang tersimpan
        $data['admin'] = $this->db->get_where('tbl_admin', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin/footer');
    }
    
    //halaman datausers
    public function users()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('email'))
        {
            ///jika belum ada, kembalikan ke halaman index
            redirect('admin/');
        }
        
        //title untuk halaman data users
        $data['title'] = 'Data Users - Peminatan Mahasiswa Ilkom';
        $data['title_topbar'] = 'DATA USERS';
    
        //mengambil data dari session yang tersimpan
        $data['admin'] = $this->db->get_where('tbl_admin', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/admin/footer');
    }

    //fungsi untuk cetak user
    public function cetak_semua_user()
    {

        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('email'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('admin/');
        }

        //mngatur halaman
        $pdf = new FPDF('L', 'mm', 'A4');
        //membuat halaman baru
        $pdf->AddPage();
        //mengatur font
        $pdf->SetFont('Arial','B',16);
        //mencetak string
        $pdf->Cell(190,7,'SISTEM PENDUKUNG KEPUTUSAN PEMINATAN ILMU KOMPUTER ', 0, 1, 'C');
        //memberikan space kosong kebawah
        $pdf->Cell(10,7,'',0,1);
        //mengatur font
        $pdf->SetFont('Arial', 'B', 10);
        //mencetak string
        $pdf->Cell(10,6,'No.', 1, 0);
        $pdf->Cell(40,6,'Tanggal Update', 1, 0);
        $pdf->Cell(30,6,'NIM', 1, 0);
        $pdf->Cell(60,6,'Nama', 1, 0);
        $pdf->Cell(20,6,'Nilai SE', 1, 0);
        $pdf->Cell(20,6,'Nilai DS', 1, 0);
        $pdf->Cell(30,6,'Persentase SE', 1, 0);
        $pdf->Cell(30,6,'Persentase DS', 1, 1);
        //mengatur font
        $pdf->SetFont('Arial', '', 10);

        $query = "SELECT `tgl_update`, `tbl_user`.`nim`, `nama`, `minat_ds`, `minat_se`, `persen_ds`, `persen_se` FROM `tbl_user` JOIN `tbl_hasil`
                ON `tbl_user`.`nim` = `tbl_hasil`.`nim`";
                $join_users = $this->db->query($query)->result();

        $no = 1;
        foreach ($join_users as $users)
        {
            $pdf->Cell(10, 6, $no, 1, 0);
            $pdf->Cell(40, 6, date('d F Y',$users->tgl_update), 1, 0);
            $pdf->Cell(30, 6, $users->nim, 1, 0);
            $pdf->Cell(60, 6, $users->nama, 1, 0);
            $pdf->Cell(20, 6, number_format($users->minat_se, 2), 1, 0);
            $pdf->Cell(20, 6, number_format($users->minat_ds, 2), 1, 0);
            $pdf->Cell(30, 6, number_format($users->persen_se, 2), 1, 0);
            $pdf->Cell(30, 6, number_format($users->persen_ds, 2), 1, 1);
            $no++;
        }
        //menampilkan output
        $pdf->Output();
    }

    
    public function saw()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('email'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('admin/');
        }

        //title untuk halaman data users
        $data['title'] = 'Data SAW - Peminatan Mahasiswa Ilkom';
        $data['title_topbar'] = 'DATA SAW';
    
        //mengambil data dari session yang tersimpan
        $data['admin'] = $this->db->get_where('tbl_admin', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('admin/saw', $data);
        $this->load->view('templates/admin/footer');
    }

    //halaman data pengembang
    public function pengembang()
    {
        //cek apakah user sudah ada session atau belum
        if(!$this->session->userdata('email'))
        {
            //jika belum ada, kembalikan ke halaman index
            redirect('admin/');
        }

        //title untuk halaman data users
        $data['title'] = 'Profil Pengembang - Peminatan Mahasiswa Ilkom';
        $data['title_topbar'] = 'PROFIL PENGEMBANG';
    
        //mengambil data dari session yang tersimpan
        $data['admin'] = $this->db->get_where('tbl_admin', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('templates/admin/topbar', $data);
        $this->load->view('admin/pengembang', $data);
        $this->load->view('templates/admin/footer');
    }

    //fungsi untuk logout admin
    public function logout()
    {
        //bersihkan data session
        $this->session->unset_userdata('email');
    
        //jika keluar berhasil, redirect ke halaman home
        $this->session->set_flashdata('pesan', '<div class="alert alert-success text-center" role="alert">Anda telah berhasil logout!</div>');
        redirect('admin/');
    }
}