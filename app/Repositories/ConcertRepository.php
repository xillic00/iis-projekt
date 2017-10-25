<?php

namespace App\Repositories;

use App\ConcertItemInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\ConcertItem;

class ConcertRepository implements ConcertRepositoryInterface {

    protected $columns = [
        '`iis_concert`.`iis_concertid`',
        '`iis_concert`.`iis_eventid`',
        '`iis_concert`.`capacity`',
        '`iis_concert`.`date`',
        '`iis_concert`.`created_at`',
        '`iis_concert`.`updated_at`',
    ];

    /**
     * @return Builder
     */
    protected function getQueryBuilder()
    {
        return DB::table('iis_concert')
            ->select(DB::raw(implode(',', $this->columns)));
    }

    public function getAllItems()
    {
        return $this->_toItems($results = $this->getQueryBuilder()
            ->get());
    }

    private function _toItem($row)
    {
        if($row) {
            return new ConcertItem((array) $row);
        }
    }

    private function _toItems($rows)
    {
        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->_toItem((array) $row);
        }
        return $items;
    }

    /**
     * @param int $id
     * @return ConcertItemInterface ConcertItem
     */
    public function getItemById(int $id): ConcertItemInterface
    {
        return $this->_toItem($this->getQueryBuilder()
            ->where('iis_concertid', $id)
            ->first());
    }

//    public function save($eventid, $capacity, $date)
//    {
//        return DB::table('`iis_concert`')->insertGetId([
//            'eventid' => $eventid,
//            'capacity' => $capacity,
//            'date' => $date,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);
//    }
}