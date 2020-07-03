<?php

$this->registerJs('
 
  $(\'#' . $id . '\').multiSelect();
  
');

?>

<select id='<?= $id ?>' name='<?= $name ?>' multiple='multiple'>
    <?php foreach ($data as $k => $v) { ?>
        <option value="<?= $k ?>" <?php if (in_array($v, $value)) {
            echo 'selected';
        } ?> ><?= $v ?></option>
    <?php } ?>
</select>
