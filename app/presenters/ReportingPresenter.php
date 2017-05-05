<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use App\Model;
use Ublaboo\DataGrid\DataGrid;
use Dibi;
use Nette\Application\UI;

/**
 * Description of ReportingPresenter
 *
 * @author Klochkov Mikhail
 */
class ReportingPresenter extends BasePresenter {

    private $report_model;

    /** @persistent */
    public $report_id;
    private $items;

    /** @var \IReportingControlFactory @inject */
    public $iReportInfo;

    function __construct(\Dibi\Connection $db) {
        $this->report_model = new \App\Model\ReportingModel($db);
        $this->report_id = $this->getParameter("report_id") ?? -1;
    }

    function renderReportInfo() {
        $this->template->items_info = $this->items = $this->report_model->getReportListLikeArray1($this->report_id);
    }

    public function createComponentReportInfo($name) {
        
        return new \Nette\Application\UI\Multiplier(function ($id) {

            if ($this->items[$id]["ELEMENT_TYPE"] == "table") {

                $res = $this->report_model->executeQuery1($this->items[$id]);
                $data = $res;
                $paggination = [15, 30, 240, 480];
                $grid = new DataGrid();
                $grid->setItemsPerPageList($paggination);
                $grid->setPrimaryKey("ID");
                $grid->setDataSource($data);
                $columns = $data[0];
                foreach ($columns as $column=>$value) {
                    $grid->addColumnText($column, $column)
                            ->setSortable();
                    $grid->addFilterText($column, $column, [$column]);
                }

                return $grid;
            } else if ($this->items[$id]["ELEMENT_TYPE"] == "header") {
                return new \HeaderComponent($this->report_model->executeQuery1($this->items[$id]));
            }
           
        });
    }
}
