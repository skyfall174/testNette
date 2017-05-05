<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GraphComponent
 *
 * @author nood7
 */
class GraphComponent extends \Nette\Application\UI\Control {

    public $id;
    public $data, $db_id, $name, $data_for_graph, $type, $min_color, $max_color;

    function __construct(int $id, int $db_id, string $name, string $type, array $data, string $min_color = "#000000", string $max_color = "#FFFFFF") {
        $this->id = $id;
        $this->data = $data;
        $this->db_id = $db_id;
        $this->name = $name;
        $this->type = $type;
        $this->prepareData();
        $this->min_color = $min_color;
        $this->max_color = $max_color;
    }

    public function render() {
        $this->template->setFile(__DIR__ . "/graph.latte");
        $this->template->id = "grpaph_" . $this->id;
        $this->template->db_id = $this->db_id;
        $this->template->data = json_encode($this->data_for_graph);
        $this->template->render();
    }

    private function prepareData() {
        $this->data_for_graph = 1;
        $label = [];
        $values = [];
        $color = [];
        $graduations = sizeof($this->data);

        $i = 0;
        foreach ($this->data as $val) {
            array_push($color, "rgba(" . rand(0, 255) . ","
                    . rand(0, 255) . "," . rand(0, 255) .
                    "," . rand(0, 255) . ")");
//            array_push($color, "\"#\"+((1<<24)*Math.random()|0).toString(16)");

            array_push($label, $val["LABEL"]);
            array_push($values, $val["VALUE"]);
            $i++;
        }

        $this->data_for_graph = [
            "type" => $this->type,
            "data" => [
                "labels" => $label,
                "datasets" => [
                    ["data" => $values,
                        "backgroundColor" => $color,
                        "label" => $this->name],
//                    "borderWidth" => 1
                ]
            ],
            "options" => "{legend: {display: true, labels: {fontColor: 'rgb(255, 99, 132)'},animation:{animateScale:true,duration: 10000}}"
        ];
    }

}
