<?php
class Quay extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO banchina (ID, descrizione) VALUES (?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'is',
            $params['id'],
            $params['description'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from banchina";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showView()
    {
        $sql = "SELECT * from banchina_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "UPDATE banchina SET descrizione = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'si',
            $params['description'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM banchina WHERE banchina.ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute();
    }
}
