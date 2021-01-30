        <nav class="navbar-isi navbar-expand-lg">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-6">
                    <!-- Query table kriteria untuk tampil diview -->
                        <?php
                            $query_matkul = $this->db->query("SELECT `id_matkul`, `nama_matkul` FROM `tbl_matkul`")->result_array();
                        ?>

                        <h4><br/>Table Matkul Kriteria</h4>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">ID Matkul</th>
                                    <th scope="col">Nama Matkul</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($query_matkul as $matkul) : ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $matkul['id_matkul']; ?></td>
                                        <td><?= $matkul['nama_matkul']; ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Query table kriteria untuk tampil diview -->
                    </div>


                    <div class="col-md-6">
                        <!-- Query table nilai untuk tampil diview -->
                        <?php
                            $query_nilai = $this->db->query("SELECT `id_nilai`, `nama_nilai` FROM `tbl_nilai`")->result_array();
                        ?>

                        <h4><br/>Table Nilai</h4>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">ID Nilai</th>
                                    <th scope="col">Nama Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($query_nilai as $nilai) : ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $nilai['id_nilai']; ?></td>
                                        <td><?= $nilai['nama_nilai']; ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Query table nilai untuk tampil diview -->
                    </div>
                </div>


                <div class="row">
                    <!-- Query table bobot untuk tampil diview -->
                    <?php
                        $query_bobot = $this->db->query("SELECT `mkb_1`, `mkb_2`, `mkb_3`, `mkb_4`, `mkb_5`,
                        `mkb_6`, `mkb_7`, `mkb_8`, `mkb_9`, `mkb_10`, `mkb_11`, `mkb_12`, `mkb_13`, `mkb_14`,
                        `mkb_15`, `mkb_16`  FROM `tbl_bobot`")->result_array();
                    ?>

                    <div class="col-lg-6">
                        <h4><br/>Table Bobot Matkul 1-8</h4>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Matkul 1</th>
                                    <th scope="col">Matkul 2</th>
                                    <th scope="col">Matkul 3</th>
                                    <th scope="col">Matkul 4</th>
                                    <th scope="col">Matkul 5</th>
                                    <th scope="col">Matkul 6</th>
                                    <th scope="col">Matkul 7</th>
                                    <th scope="col">Matkul 8</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($query_bobot as $bobot) : ?>
                                    <tr>
                                        <td><?= $bobot['mkb_1']; ?></td>
                                        <td><?= $bobot['mkb_2']; ?></td>
                                        <td><?= $bobot['mkb_3']; ?></td>
                                        <td><?= $bobot['mkb_4']; ?></td>
                                        <td><?= $bobot['mkb_5']; ?></td>
                                        <td><?= $bobot['mkb_6']; ?></td>
                                        <td><?= $bobot['mkb_7']; ?></td>
                                        <td><?= $bobot['mkb_8']; ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Query table bobot untuk tampil diview -->
                    </div>
                    <div class="col-lg-6">
                        <h4><br/>Table Bobot Matkul 9-16</h4>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Matkul 9</th>
                                    <th scope="col">Matkul 10</th>
                                    <th scope="col">Matkul 11</th>
                                    <th scope="col">Matkul 12</th>
                                    <th scope="col">Matkul 13</th>
                                    <th scope="col">Matkul 14</th>
                                    <th scope="col">Matkul 15</th>
                                    <th scope="col">Matkul 16</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($query_bobot as $bobot) : ?>
                                    <tr>
                                        <td><?= $bobot['mkb_9']; ?></td>
                                        <td><?= $bobot['mkb_10']; ?></td>
                                        <td><?= $bobot['mkb_11']; ?></td>
                                        <td><?= $bobot['mkb_12']; ?></td>
                                        <td><?= $bobot['mkb_13']; ?></td>
                                        <td><?= $bobot['mkb_14']; ?></td>
                                        <td><?= $bobot['mkb_15']; ?></td>
                                        <td><?= $bobot['mkb_16']; ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Query table bobot untuk tampil diview -->
                    </div>

                </div>


            </div>
        </nav>
    </div>