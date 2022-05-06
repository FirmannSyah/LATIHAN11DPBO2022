<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $member->delete($id);
    header("location:member.php");
}



$data = null;
$no = 1;

while (list($nim, $nama, $jurusan) = $member->getResult()){
        $data .= "<tr>
                <td>" . $no++ . "</td>
                <td>" . $nim . "</td>
                <td>" . $nama . "</td>
                <td>" . $jurusan . "</td>
                <td>
                <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
                <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
                </td>
                </tr>";
}

$form = "<div class='col-lg-4 col-md-4 col-sm-4 col-4 m-3'>
            <div class='card p-5 mr-3'>
                <h2 class='card-title'>Add Member</h2>
                    <form action='member.php' method='POST'>
                        <div class='form-row'>
                        <div class='form-group col'>
                            <label for='nim'>NIM</label>
                            <input type='text' class='form-control' name='nim' required />
                        </div>
                        </div>

                        <div class='form-row'>
                        <div class='form-group col'>
                            <label for='nama'>Nama</label>
                            <input type='text' class='form-control' name='nama' required />
                        </div>
                        </div>

                        <div class='form-row'>
                        <div class='form-group col'>
                            <label for='jurusan'>Jurusan</label>
                            <input type='text' class='form-control' name='jurusan' required />
                        </div>
                        </div>

                        <button type='submit' name='add' class='btn btn-primary mt-3'>Add</button>
                    </form>
                </div>
            </div>";


$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);
if (isset($_GET['id_edit'])) {
    $memberget = new Member($db_host, $db_user, $db_pass, $db_name);
    $memberget->open();
    $memberget->getMemberbyID($_GET['id_edit']);
    list($nim, $nama, $jurusan) = $memberget->getResult();
    $update = "<div class='col-lg-4 col-md-4 col-sm-4 col-4 m-3'>
            <div class='card p-5 mr-3'>
                <h2 class='card-title'>Edit Member : $nim</h2>
                    <form action='member.php?nim_edit=$nim&id_edit=$nim' method='POST'>
                        <div class='form-row'>
                        <div class='form-group col' hidden>
                            <label for='nim'>nim</label>
                            <input type='text' class='form-control' name='nim' value='$nim' />
                        </div>
                        </div>

                        <div class='form-row'>
                        <div class='form-group col'>
                            <label for='nama'>Nama</label>
                            <input type='text' class='form-control' name='nama' value='$nama' required />
                        </div>
                        </div>

                        <div class='form-row'>
                        <div class='form-group col'>
                            <label for='jurusan'>Jurusan</label>
                            <input type='text' class='form-control' name='jurusan' value='$jurusan' required />
                        </div>
                        </div>

                        <button type='submit' name='edit' class='btn btn-success mt-3'>edit</button>
                    </form>
                </div>
            </div>";
    if(isset($_GET['nim_edit'])){
        $memberget->edit($_POST);
        $memberget->close();
        header("location:member.php");
    }
    $tpl->replace("FORM_ADD", $update);
}
else{
    $tpl->replace("FORM_ADD", $form);
}

$tpl->write();
