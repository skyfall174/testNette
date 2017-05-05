<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportInfoControl
 *
 * @author Klochkov Mikhail
 */
use \Nette\Application\UI\Control;
use Ublaboo\DataGrid\DataGrid;

class ReportInfoControl extends Control {

    private $model;
    private $report_id;
    private $item;
    private $row;

    function __construct(\App\Model\ReportingModel $model, int $report_id) {
//        $this->row = $row;
        $this->model = $model;
        $this->report_id = $report_id;
    }

    public function render($item = null) {
        if (!empty($item)) {
            $this->item = $item;
            $this->template->i = $item;
            $this->template->render(__DIR__ . "/table.latte");

        }
    }

    public function createComponentDataGrid($name) {
        
        if ($this->item["ELEMENT_TYPE"] == "table") {
            return $this->createGrid();
        } else {
            return $this->createGraph();
        }
    }

    public function createGrid() {
        $paggination = [15, 30, 240, 480];
        $grid = new DataGrid();
        $grid->setItemsPerPageList($paggination);
        $grid->setPrimaryKey("ID");

        $result = $this->model->executeQuery($this->item["QUERY"]);
        $grid->setDataSource($result->fetchAll());
        $columns = $result->getColumns();
        foreach ($columns as $column) {
            $grid->addColumnText($column->getName(), $column->getName())
                    ->setSortable();
            $grid->addFilterText($column->getName(), $column->getName(), [$column->getName()]);
        }


        return $grid;
    }

    public function createGraph() {
        $grid = new DataGrid();
        $grid->setPrimaryKey("ID");
        $result = $this->model->executeQuery($this->item["QUERY"]);

        $grid->setDataSource([]); // Array
        $grid->addColumnText("name", "na");

        return $grid;
    }

}

interface IReportingControlFactory {

    /** @return ReportInfoControl */
    function create(\App\Model\ReportingModel $model, int $report_id);
}
