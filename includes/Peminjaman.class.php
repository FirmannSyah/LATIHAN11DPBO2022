<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT peminjaman.id_pinjam, peminjaman.nim, member.nama, peminjaman.id_buku, buku.judul_buku,
                  peminjaman.keterangan FROM peminjaman
                  JOIN member ON member.nim = peminjaman.nim
                  JOIN buku ON buku.id_buku = peminjaman.id_buku";
        return $this->execute($query);
    }

    function add($data)
    {      
        $nim = $data['nim'];
        $id_buku = $data['id_buku'];
        $Keterangan = "Belum Dikembalikan";

        $query = "insert into peminjaman values ('', '$nim', '$id_buku', '$Keterangan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id_pinjam = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function KeteranganPeminjaman($id)
    {

        $Keterangan = "Sudah Dikembalikan";
        $query = "update Peminjaman set keterangan = '$Keterangan' where id_pinjam = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}


?>