<?php
class Form
{
    private $fields = array();
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;
    private $enctype = false;
    public function __construct($action, $submit, $enctype = false)
    { $this->action=$action; $this->submit=$submit; $this->enctype=$enctype;}
    
    public function displayForm()
    {
        $enc = $this->enctype ? "enctype='multipart/form-data'" : "";
        echo "<form action='" . $this->action . "' method='POST' $enc>";
        echo '<table width="100%" border="0">';

        for ($j = 0; $j < count($this->fields); $j++) {
            $field = $this->fields[$j];
            echo "<tr><td align='right'>{$field['label']}</td><td>";
            if ($field['type']=='select'){ echo "<select name='{$field['name']}'>"; foreach ($field['options'] as $val=>$text){ $selected=($val==$field['value']) ? 'selected' : ''; echo "<option value='$val' $selected>$text</option>";} echo "</select>";}
             elseif ($field['type']=='file'){ echo "<input type='file' name='{$field['name']}'>";}
             else{ $type=$field['type'] ?? 'text'; $value=htmlspecialchars($field['value'] ?? ''); echo "<input type='$type' name='{$field['name']}' value='$value'>";}
            echo "</td></tr>";
        }

        echo "<tr><td colspan='2'>";
        echo "<input type='submit' name='submit' value='" . $this->submit . "'></td></tr>";
        echo "</table></form>";
    }
    
    public function addField($name, $label)
    { $this->fields[$this->jumField]['name']=$name; $this->fields[$this->jumField]['label']=$label; $this->jumField++;}
    
    public function addText($name, $label, $value = '', $type = 'text')
    { $this->fields[]=['name'=>$name, 'label'=>$label, 'value'=>$value, 'type'=>$type];}
    
    public function addSelect($name, $label, $options, $selected = '')
    { $this->fields[]=['name'=>$name, 'label'=>$label, 'type'=>'select', 'options'=>$options, 'value'=>$selected];}
    
    public function addFile($name, $label)
    { $this->fields[]=['name'=>$name, 'label'=>$label, 'type'=>'file'];}

    public function addTextarea($name, $label, $value = '', $rows = 4)
    { $this->fields[]=[ 'name'=>$name, 'label'=>$label, 'type'=>'textarea', 'value'=>$value, 'rows'=>$rows ];}
}
?>