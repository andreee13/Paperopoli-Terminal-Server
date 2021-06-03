<?php
class ShipStatus extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO nave_stato (stato, timestamp, nave) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iss',
            $params['name_id'],
            $params['timestamp'],
            $params['ship'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM nave_stato WHERE id = ?';
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'i',
            $params['status_id'],
        );
        return $req->execute();
    }
}
