<?php
class Operation extends Model
{

    public function create($params)
    {
        $sql = "SELECT * FROM movimentazione_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "INSERT INTO movimentazione (ID, tipo, descrizione, viaggio, navi, merci, persone, veicoli) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iisissss',
            $params['id'],
            $type_id,
            $params['description'],
            $params['trip'],
            $params['ships'],
            $params['goods'],
            $params['people'],
            $params['vehicles'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from movimentazione_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showTypes()
    {
        $sql = "SELECT * from movimentazione_tipo";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "SELECT * FROM movimentazione_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "UPDATE movimentazione SET tipo = ?, descrizione = ?, viaggio = ?, navi = ?, merci = ?, persone = ?, veicoli = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'isissssi',
            $type_id,
            $params['description'],
            $params['trip'], 
            $params['ships'],
            $params['goods'],
            $params['people'],
            $params['vehicles'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM movimentazione WHERE movimentazione.ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        $sql = 'DELETE FROM movimentazione_stato WHERE movimentazione_stato.movimentazione = ?';
        $req2 = Database::getDb()->prepare($sql);
        $req2->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute() && $req2->execute();
    }
}
