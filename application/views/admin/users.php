        <nav class="navbar-isi navbar-expand-lg">
            <div class="container-fluid">

                <!-- Query join table user dan matakuliah untuk tampil diview -->
                <?php
                    $query = "SELECT `tgl_update`, `tbl_user`.`nim`, `nama`, `minat_ds`, `minat_se`, `persen_ds`, `persen_se` FROM `tbl_user` JOIN `tbl_hasil`
                    ON `tbl_user`.`nim` = `tbl_hasil`.`nim`";
                    $join_users = $this->db->query($query)->result_array();
                ?>

                <?php if($join_users)
                { ?>

                    <!-- cetak data ke pdf -->
                    <a class="nav-link" href="<?= base_url('admin/cetak_semua_user'); ?>">
                    <i class="fas fa-print"></i>
                        Cetak PDF
                    </a><br/>
                    <!-- cetak data ke pdf -->

                    <table id="table_id" class="table table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal Update</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nilai Software Engineering</th>
                                <th scope="col">Nilai Data Science</th>
                                <th scope="col">Persentase Software Engineering</th>
                                <th scope="col">Persentase Data Science</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($join_users as $users) : ?>
                                <tr>
                                    <th scope="row"><?= $no; ?></th>
                                    <td><?= date('d F Y', $users['tgl_update']); ?></td>
                                    <td><?= $users['nim']; ?></td>
                                    <td><?= $users['nama']; ?></td>
                                    <td><?= number_format($users['minat_se'], 2); ?></td>
                                    <td><?= number_format($users['minat_ds'], 2); ?></td>
                                    <td><?= number_format($users['persen_se'], 2); ?></td>
                                    <td><?= number_format($users['persen_ds'], 2); ?></td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php }
                else
                {?>
                    <div class="h4 text-center" style="margin-top: 90px; margin-bottom: 90px; color: #584540;">
                        Data User masih kosong
                    </div>
                <?php } ?>

            </div>
        </nav>
        </div>