<?php
class Operation extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO movimentazione (ID, tipo, descrizione, viaggio) VALUES (?, ?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iisi',
            $params['id'],
            $params['type'],
            $params['description'],
            $params['trip'],
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
        $sql = "UPDATE movimentazione SET tipo = ?, descrizione = ?, viaggio = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'isii',
            $params['type'],
            $params['description'],
            $params['trip'],
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
