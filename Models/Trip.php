<?php
class Trip extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO viaggio (ID, partenza_prevista, arrivo_previsto, partenza_effettiva, arrivo_effettivo, banchina) VALUES (?, ?, ?, ?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'issssi',
            $params['id'],
            $params['partenza_prevista'],
            $params['arrivo_previsto'],
            $params['partenza_effettiva'],
            $params['arrivo_effettivo'],
            $params['banchina'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from viaggio_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "UPDATE viaggio SET arrivo_previsto = ?, arrivo_effettivo = ?, partenza_prevista = ?, partenza_effettiva = ?, banchina = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'ssssii',
            $params['arrivo_previsto'],
            $params['arrivo_effettivo'],
            $params['partenza_prevista'],
            $params['partenza_effettiva'],
            $params['banchina'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM viaggio WHERE viaggio.ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute();
    }
}
