<?php
class VehicleStatus extends Model
{

    public function create($params)
    {
        $sql = "INSERT INTO veicolo_stato (stato, timestamp, veicolo) VALUES (?, ?, ?)";
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'iss',
            $params['name_id'],
            $params['timestamp'],
            $params['vehicle'],
        );
        $req->execute();
        return $req->insert_id;
    }

    public function delete($params)
    {
        $sql = 'DELETE FROM veicolo_stato WHERE ID = ?';
        $req = Database::getDb()->prepare($sql);
        $req->bind_param(
            'i',
            $params['status_id'],
        );
        return $req->execute();
    }
}
