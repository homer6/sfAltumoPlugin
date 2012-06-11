<?php 
    $chrome_element_attributes = html_entity_decode($chrome_element_attributes);
?>  
<div id="<?php echo $element_id; ?>" <?php echo $chrome_element_attributes; ?>>
    <?php echo htmlspecialchars_decode($content); ?>
</div>