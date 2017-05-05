<?php
namespace App\Model;

/**
 * Description of ReportingModel
 *
 * @author Skyfall174
 */
class ReportingModel {

    private $db;

    function __construct(\Dibi\Connection $connection) {
        $this->db = $connection;
    }

    public function getReportListLikeArray1(int $report_id) {
        $ret = [];
        $row1 = new \Dibi\Row([
            "ID" => 1,
            "ELEMENT_TYPE" => "header",
            "ELEMENT_ORDER" => 1,
            "NAME" => "NAME",
            "ELEMENT_ID" => 1,
        ]);
        $row2 = new \Dibi\Row([
            "ID" => 1,
            "ELEMENT_TYPE" => "table",
            "ELEMENT_ORDER" => 2, 
            "NAME" => "NAME",
            "ELEMENT_ID" => 1,
        ]);
        $row3 = new \Dibi\Row([
            "ID" => 1,
            "ELEMENT_TYPE" => "header",
            "ELEMENT_ORDER" => 3,
            "NAME" => "NAME1",
            "ELEMENT_ID" => 2,
        ]);

        array_push($ret, $row1);
        array_push($ret, $row2);
        array_push($ret, $row3);

        return $ret;
    }

    public function executeQuery1($q) {
        if ($q["ELEMENT_TYPE"] == "header") {
            if ($q["ELEMENT_ID"] == 1) {
                return "HELO";
            } else {
                return "WORLD";
            }
        }
        if ($q["ELEMENT_TYPE"] == "table") {
            if ($q["ELEMENT_ID"] == 1) {
                $row1 = new \Dibi\Row([
                    "ID" => 1,
                    "NAME" => "demo1",
                ]);
                $row2 = new \Dibi\Row([
                    "ID" => 2,
                    "NAME" => "demo2",
                ]);
                $row3 = new \Dibi\Row([
                    "ID" => 3,
                    "NAME" => "demo3",
                ]);

                return [$row1, $row2, $row3];
            } else {
                $row1 = new \Dibi\Row([
                    "ID" => 1,
                    "HELLO" => "demo1",
                ]);
                $row2 = new \Dibi\Row([
                    "ID" => 2,
                    "HELLO" => "demo2",
                ]);
                $row3 = new \Dibi\Row([
                    "ID" => 3,
                    "HELLO" => "demo3",
                ]);

                return [$row1, $row2, $row3];
            }
        }
    }

}
