<?php
class GoodStatus extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO merce_stato (stato, timestamp, merce) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iss',
            $params['name_id'],
            $params['timestamp'],
            $params['good'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM merce_stato WHERE ID = ?';
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'i',
            $params['status_id'],
        );
        return $req->execute();
    }
}
