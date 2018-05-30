<?php
define("ROMSYNC_SEARCH_QUERY", "SELECT SQL_CALC_FOUND_ROWS * FROM `roms` %s %s");
define("ROMSYNC_SYSTEM_QUERY", "SELECT `systems`.name as name, `roms`.system as link
            FROM `roms`
            LEFT JOIN `systems`
            ON `roms`.system = `systems`.systemid
            GROUP BY system 
            ORDER BY name ASC");
define("ROMSYNC_DECADE_QUERY", "SELECT (FLOOR(year / 10) * 10) AS decades, 
                                COUNT(id) AS `count` 
                            FROM `roms` 
                            WHERE year >= 1970 
                            GROUP BY FLOOR(year/10) 
                            ORDER BY decades DESC");
define("ROMSYNC_YEAR_QUERY", "SELECT year 
                            FROM `roms` 
                            WHERE year NOT LIKE '%?' 
                            GROUP BY year 
                            ORDER BY year DESC");
define("ROMSYNC_NUM_OF_ROWS_QUERY", "SELECT FOUND_ROWS()");
define("DEFAULT_APP_NAME", "Romsync2");
define("DEFAULT_APP_VERSION", "1.0.0");
define("DEFAULT_APP_PAGINATION_START", 0);
define("DEFAULT_APP_QUERY_LIMIT", 20);
define("ROMSYNC_ORDERBY", "ORDER BY name LIMIT %s OFFSET %s");
class RomsyncModel{
    protected $pdo = null;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    /**
     * ?filterType=primary&page=0&system=Arcade
     * ?query=street&limit=20
     * search by name
     * {
     *  query: street fighter
     * }
     * search by id
     * {
     *  id: 33
     * }
     * search by filename
     * {
     *  filename: "sf3"
     * }
     */
    public function pagination($pageNumber, $limit = 25){
        $offset = $pageNumber * $limit;
        return sprintf(ROMSYNC_ORDERBY, $limit, $offset);
    }
    public function query(){

    }
    public function getGames($queryObject){
        $data = new stdClass();
        $query = "";
        $pagination = "";
        //
        $stmt = $this->pdo->query(sprintf(ROMSYNC_SEARCH_QUERY, $query, $pagination));
        $data->games = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        //
        $stmt = $this->pdo -> query(ROMSYNC_NUM_OF_ROWS_QUERY);
        $data->total = $stmt -> fetchAll(PDO::FETCH_ASSOC)[0]["FOUND_ROWS()"];
        return $data;
    }
    public function getSystems(){
        $stmt = $this->pdo->query(ROMSYNC_SYSTEM_QUERY);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDecades(){
        $stmt = $this->pdo->query(ROMSYNC_DECADE_QUERY);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function getYears(){
        $stmt = $this->pdo->query(ROMSYNC_YEAR_QUERY);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    public function getInfo($settings){
        $data = new stdClass();
        $data->name = DEFAULT_APP_NAME;
        $data->version = ($settings->version || DEFAULT_APP_VERSION);
        $data->databaseConnected = false;
        if($this->pdo){
            $data->databaseConnected = true;
        }
        return $data;
    }
}
?>