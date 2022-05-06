<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Author.class.php");
include("includes/Member.class.php");
include("includes/Peminjaman.class.php");

$Member = new Member($db_host, $db_user, $db_pass, $db_name);
$Peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$author = new Author($db_host, $db_user, $db_pass, $db_name);

$Member->open();
$Peminjaman->open();
$buku->open();
$author->open();

$buku->getBuku();
$author->getAuthor();
$Member->getMember();
$Peminjaman->getPeminjaman();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $Peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $id = $_GET['id_edit'];

    $Peminjaman->KeteranganPeminjaman($id);
    header("location:peminjaman.php");
}

$data = null;
$dataMember = null;
$dataBuku = null;
$no = 1;

while (list($id_pinjam, $nim, $nama, $id_buku, $judul_buku, $Keterangan) = $Peminjaman->getResult()) {
    if ($Keterangan == "Sudah Dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nama . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $Keterangan . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id_pinjam . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nama . "</td>
            <td>" . $judul_buku . "</td>
            <td>" . $Keterangan . "</td>
            <td>
            <a href='peminjaman.php?id_edit=" . $id_pinjam .  "' class='btn btn-warning' '>Edit</a>
            <a href='peminjaman.php?id_hapus=" . $id_pinjam . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
}

while (list($nim, $nama, $jurusan) = $Member->getResult()) {
    $dataMember .= "<option value='".$nim."'>".$nama."</option>
                ";
}

while (list($id_buku, $judul_buku, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id_buku."'>". $judul_buku."</option>
                ";
}

$author->close();
$buku->close();
$Peminjaman->close();
$Member->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_MEMBER", $dataMember);
$tpl->replace("OPTION_BOOK", $dataBuku);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
