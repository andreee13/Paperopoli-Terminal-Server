<?php
class Person extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO persona (nome, tipo) VALUES (?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'si',
            $params['name'],
            $params['type'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function showAll()
    {
        $sql = "SELECT * from persona_vista";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showTypes()
    {
        $sql = "SELECT * from persona_tipo";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function showStatusNames()
    {
        $sql = "SELECT * from persona_stato_nome";
        $req = Database::getDb()->prepare($sql);
        $req->execute();
        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function edit($params)
    {
        $sql = "SELECT * FROM persona_tipo WHERE nome = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            's',
            $params['type'],
        );
        $req->execute();
        $type_id = $req->get_result()->fetch_all(MYSQLI_ASSOC)[0]['ID'];
        $sql = "UPDATE persona SET tipo = ?, cf = ?, nome_completo = ? WHERE ID = ?";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'issi',
            $type_id,
            $params['cf'],
            $params['fullname'],
            $params['id'],
        );
        return $req->execute();
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM persona WHERE ID = ?';
        $req1 = Database::getDb()->prepare($sql);
        $req1->bind_param(
            'i',
            $params['id'],
        );
        $sql = 'DELETE FROM persona_stato WHERE persona = ?';
        $req2 = Database::getDb()->prepare($sql);
        $req2->bind_param(
            'i',
            $params['id'],
        );
        return $req1->execute() && $req2->execute();
    }
}
