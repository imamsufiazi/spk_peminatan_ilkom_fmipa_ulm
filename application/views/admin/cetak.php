<!DOCTYPE html>
<html lang="en">

<head>

    <title>Cetak PDF</title>

</head>
<style type="text/css">
    td {
        padding: 5px;
    }
</style>

<body style="font-family:Times New Roman;font-size:12px">
    <center>
        <h1>Cetak pdf</h1>
    </center>
    <table border="1">
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Alamat</td>
            <td>Kelas</td>
        </tr>
        <?php $no = 1;
        foreach ($record->result() as $row) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->alamat ?></td>
                <td><?php echo $row->kelas ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>