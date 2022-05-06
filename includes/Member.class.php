<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function getMemberbyId($id)
    {
        $query = "SELECT * FROM member Where nim = $id";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];

        $query = "insert into Member values ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM Member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function edit($data)
    {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];
        $query = "update member set nama = '$nama', jurusan = '$jurusan' where nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}


?>