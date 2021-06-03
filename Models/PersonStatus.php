<?php
class PersonStatus extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO persona_stato (stato, timestamp, persona) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iss',
            $params['name_id'],
            $params['timestamp'],
            $params['person'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM persona_stato WHERE ID = ?';
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'i',
            $params['status_id'],
        );
        return $req->execute();
    }
}
