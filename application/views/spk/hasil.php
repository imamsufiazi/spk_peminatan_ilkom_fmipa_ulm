    <div class="bg-contact" style="background-image: url('<?= base_url('assets/spk/'); ?>images/bg/bg.jpg');">
	<div class="container-contact100">
		<div class="wrap-contact100-hasil">
            <div class="contact100-form-mhs">
                <a class="btn-login">
                </a>
            </div>

            <div class="subwrap-contact100">
                <span class="contact100-form-title">
                    HASIL PEMINATAN ILMU KOMPUTER
                </span>
                <span class="contact100-form-subtitle">
                    <?= $_SESSION['nim']; ?> - <?= $_SESSION['nama']; ?>
                </span>                    

                <div class="row">
                    <div class="col-md-12">
                        <h5>
                            Berdasarkan nilai matakuliah yang telah anda input, maka anda lebih cocok mengambil peminatan :
                        </h5>
                    </div>
                </div>

                <?php
                    if($hasil['minat_ds'] >= $hasil['minat_se'])
                    { ?>
                        <h3 class="hasil1">
                            DATA SCIENCE
                        </h3>

                        <h5 class="hasil2">
                        (dengan nilai <?= number_format($hasil['minat_ds'], 2) ?> dan persentase <?= number_format($hasil['persen_ds'], 2) ?>%)
                        </h5>
                        <?php
                    }
                    else if($hasil['minat_ds'] <= $hasil['minat_se'])
                    { ?>
                        <h3 class="hasil1">
                            SOFTWARE ENGINEERING
                        </h3>

                        <h5 class="hasil2">
                        (dengan nilai <?= number_format($hasil['minat_se'], 2) ?> dan persentase <?= number_format($hasil['persen_se'], 2) ?>%)
                        </h5>
                        <?php
                    }
                ?>
                
                <div class="row">
                    <div class="col-md-12">
                    <h6>
                        Nilai matakuliah anda berubah? Perbaiki <a href="<?= base_url('spk/input'); ?>" class="btn-edit">
                            <b><u>disini</u></b>
                        </a>
                    </h6>

                    </div>
                </div>

                <div class="container-contact100-form-btn">
                    <div class="wrap-contact100-form-btn">
                        <div class="contact100-form-bgbtn"></div>
                        <a href="<?= base_url('spk/selesai'); ?>" class="contact100-form-btn">
                            <span>
                                Selesai
                                <i class="fas fa-check m-l-7" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
		</div>
	</div>
    </div>


	<div id="dropDownSelect1"></div>
