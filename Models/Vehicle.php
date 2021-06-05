<?php
class Vehicle extends Model
{

    public function create($params)
    {
        $sql = "SELECT * FROM veicolo_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "INSERT INTO veicolo (ID, targa, tipo) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'isi',
            $params['id'],
            $params['plate'],
            $type_id,
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from veicolo_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showTypes()
    {
        $sql = "SELECT * from veicolo_tipo";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "SELECT * FROM veicolo_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "UPDATE veicolo SET tipo = ?, targa = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'isi',
            $type_id,
            $params['plate'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM veicolo WHERE ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        $sql = 'DELETE FROM veicolo_stato WHERE veicolo = ?';
        $req2 = Database::getDb()->prepare($sql);
        $req2->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute() && $req2->execute();
    }
}
