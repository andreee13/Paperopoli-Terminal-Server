<?php
class Good extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO merce (ID, tipo, descrizione) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iis',
            $params['id'],
            $params['type'],
            $params['description'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from merce_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showTypes()
    {
        $sql = "SELECT * from merce_tipo";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showStatusNames()
    {
        $sql = "SELECT * from merce_stato_nome";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "SELECT * FROM merce_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "UPDATE merce SET tipo = ?, descrizione = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'isi',
            $type_id,
            $params['description'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM merce WHERE merce.ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        $sql = 'DELETE FROM merce_stato WHERE merce_stato.merce = ?';
        $req2 = Database::getDb()->prepare($sql);
        $req2->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute() && $req2->execute();
    }
}
