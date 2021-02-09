<?php

namespace App\Controllers;

class A_form
{
    public function input($name, $value = "", $attr = "")
    {
        return "<input id='" . $name . "' name='" . $name . "' value='" . $value . "' class='form-control' " . $attr . ">";
    }

    public function hidden($name, $value = "", $attr = "")
    {
        return "<input type='hidden' id='" . $name . "' name='" . $name . "' value='" . $value . "' class='form-control' " . $attr . ">";
    }

    public function select($name, $values, $selected = "",  $id = "id", $caption = "name", $startempty = true, $attr = "")
    {
        $return = "<select id='" . $name . "' name='" . $name . "' class='form-control' " . $attr . ">";
        if ($startempty) $return .= "<option></option>";
        foreach ($values as $value) {
            $_selected = "";
            if ($value->$id == $selected) $_selected = "selected";
            $return .= "<option value='" . $value->$id . "' " . $_selected . ">" . $value->$caption . "</option>";
        }
        $return .= "</select>";
        return $return;
    }

    public function selectwindow($title, $name, $value_id = "", $caption = "", $ajaxurl, $j_action_selecting, $j_func_after_selected = "")
    {
        $return = "<div class=\"input-group\">";
        $return .= "    <input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value_id . "\">";
        $return .= "    <input type=\"text\" class=\"form-control\" id=\"x_" . $name . "\" name=\"x_" . $name . "\" readonly value=\"" . $caption . "\" placeholder=\"" . $title . "\">";
        $return .= "    <span class=\"input-group-btn\">";
        $return .= "        <button type=\"button\" class=\"btn btn-info btn-flat\" onclick=\"browse_" . $name . "();\"><i class=\"fas fa-search\"></i></button>";
        $return .= "    </span>";
        $return .= "</div>";
        $return .= "<script>";
        $return .= "    function " . $j_action_selecting . "(id,name) {";
        $return .= "        $('#" . $name . "').val(id);";
        $return .= "        $('#x_" . $name . "').val(name);";
        $return .= "        $('#modal-form').modal('hide');";
        if ($j_func_after_selected != "")
            $return .=      $j_func_after_selected;
        $return .= "    }";
        $return .= "    function browse_" . $name . "() {";
        $return .= "        $('#modal_title').html('" . $title . "');";
        $return .= "        $('#modal_type').attr(\"class\", 'modal-content');";
        $return .= "        $('#modal_ok_link').attr(\"class\", 'btn btn-danger');";
        $return .= "        $('#modal_ok_link').html(\"Close\");";
        $return .= "        $('#modal_ok_link').attr(\"href\", 'javascript:$(\'#modal-form\').modal(\'toggle\');');";
        $return .= "        $('#modal-form').modal();";
        $return .= "        $.get(\"" . base_url() . "/" . $ajaxurl . "\", function(result) {";
        $return .= "            $('#modal_message').html(result);";
        $return .= "        });";
        $return .= "    }";
        $return .= "</script>";
        return $return;
    }
}
