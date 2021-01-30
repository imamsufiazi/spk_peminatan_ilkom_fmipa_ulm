    <div class="bg-contact" style="background-image: url('<?= base_url('assets/spk/'); ?>images/bg/bg.jpg');">
	<div class="container-contact100">
		<div class="wrap-contact100">
            <div class="contact100-form-login">
                <a href="<?= base_url('spk/'); ?>" class="btn-login">
                    <i class="fas fa-home"></i>
                </a>
            </div>

            <div class="subwrap-contact100">
                <span class="contact100-form-title">
                    LOGIN ADMIN
                </span>
                
                <?= $this->session->flashdata('pesan'); ?>
                
                <form class="contact100-form" method="post" action="<?= base_url('admin/'); ?>">
                    
                    <div class="wrap-input100">
                        <span class="label-input100">Email anda</span>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        <input class="input100" type="text" name="email" placeholder="Masukkan Email anda" value="<?= set_value('email')?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100">
                        <span class="label-input100">Password Anda</span>
                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                        <input class="input100" type="password" name="password" placeholder="Masukkan Password anda">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-contact100-form-btn">
                        <div class="wrap-contact100-form-btn">
                            <div class="contact100-form-bgbtn"></div>
                            <button type="submit" class="contact100-form-btn">
                                <span>
                                    Login
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