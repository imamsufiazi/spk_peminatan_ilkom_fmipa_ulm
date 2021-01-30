    <div class="bg-contact" style="background-image: url('<?= base_url('assets/spk/'); ?>images/bg/bg.jpg');">
	<div class="container-contact100">
		<div class="wrap-contact100-input">

            <div class="subwrap-contact100">
                <span class="contact100-form-title">
                    INPUT NILAI MATKUL
                </span>

                <span class="contact100-form-subtitle">
                    <?= $_SESSION['nim']; ?> - <?= $_SESSION['nama']; ?>
                </span>
                
                <form class="contact100-form" method="post" action="<?= base_url('spk/input'); ?>">

                <div class="row"> 
                        <div class="col-lg-12">
                            <?php foreach($matkul as $row1): ?>
                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">
                                    <?= $row1->nama_matkul; ?>
                                </span>
                                <?= form_error($row1->urutan_matkul, '<small class="text-danger pl-3">', '</small>'); ?>
                                <div>
                                    <select class="selection-2" id="<?= $row1->urutan_matkul; ?>" name="<?= $row1->urutan_matkul; ?>">
                                        <option value="">Masukkan Nilai anda</option>
                                        <?php foreach($nilai as $row2): ?>
                                        <option value="<?= $row2->nama_nilai; ?>"><?= $row2->nama_nilai; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>
                            <?php endforeach; ?>
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