    <div class="bg-contact" style="background-image: url('<?= base_url('assets/spk/'); ?>images/bg/bg.jpg');">
	<div class="container-contact100">
		<div class="wrap-contact100">
            <div class="contact100-form-mhs">
                <a href="<?= base_url('admin/'); ?>" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            </div>

            <div class="subwrap-contact100">
                <span class="contact100-form-title">
                    SISTEM PENDUKUNG KEPUTUSAN PEMINATAN ILMU KOMPUTER FMIPA ULM
                </span>

                <?= $this->session->flashdata('pesan'); ?>

                <form class="contact100-form" method="post" action="<?= base_url('spk/'); ?>">
                    
                    <div class="wrap-input100">
                        <span class="label-input100">NIM Anda</span>
                        <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
                        <input class="input100" type="text" id="nim" name="nim" placeholder="Masukkan NIM anda" value="<?= set_value('nim')?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100">
                        <span class="label-input100">Nama Anda</span>
                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        <input class="input100" type="text" id="nama" name="nama" placeholder="Masukkan Nama anda" value="<?= set_value('nama')?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-contact100-form-btn">
                        <div class="wrap-contact100-form-btn">
                            <div class="contact100-form-bgbtn"></div>
                            <button type="submit" class="contact100-form-btn">
                                <span>
                                    Mulai
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