    <div class="bg-contact" style="background-image: url('<?= base_url('assets/spk/'); ?>images/bg/bg.jpg');">
	<div class="container-contact100">
		<div class="wrap-contact100-input">

            <div class="subwrap-contact100">
                <span class="contact100-form-title">
                    INPUT NILAI MATKUL - BAGIAN 1
                </span>

                <span class="contact100-form-subtitle">
                    <?= $tbluser['nim']; ?> - <?= $tbluser['nama']; ?>
                </span>
                
                <form class="contact100-form" method="post" action="<?= base_url('spk/input1'); ?>">

                <div class="row"> 
                        <div class="col-lg-6">
                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Matematika Diskrit</span>
                                <?= form_error('matkul1', '<small class="text-danger pl-3">', '</small>'); ?>

                                <?php for($a=1; $a<2; $a++) { ?>
                                <?= form_error('M'.$a, '<small class="text-danger pl-3">', '</small>'); ?>
                                <?php } ?>

                                <div>
                                    <select class="selection-2" id="matkul1" name="matkul1">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Pemrograman Dasar</span>
                                <?= form_error('matkul2', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul2" name="matkul2">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Pemrograman Lanjut</span>
                                <?= form_error('matkul3', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul3" name="matkul3">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Pemrograman Berorientasi Objek</span>
                                <?= form_error('matkul4', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul4" name="matkul4">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Kalkulus</span>
                                <?= form_error('matkul5', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul5" name="matkul5">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Statistika dan Probabilitas</span>
                                <?= form_error('matkul6', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul6" name="matkul6">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Kecerdasan Buatan</span>
                                <?= form_error('matkul7', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul7" name="matkul7">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">Algoritma dan Struktur Data</span>
                                <?= form_error('matkul8', '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="matkul8" name="matkul8">
                                        <option value="">Masukkan Nilai anda</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="-">Belum Ada Nilai</option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>

                    <div class="container-contact100-form-btn">
                        <div class="wrap-contact100-form-btn">
                            <div class="contact100-form-bgbtn"></div>
                            <button type="submit" class="contact100-form-btn">
                                <span>
                                    Selanjutnya
                                    <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
		</div>
	</div>
    </div>


	<div id="dropDownSelect1"></div>