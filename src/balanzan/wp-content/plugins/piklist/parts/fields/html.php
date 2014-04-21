
<?php $tag = isset($attributes['tag']) ? $attributes['tag'] : 'div'; ?>

  <<?php echo $tag; ?> 
    id="<?php echo piklist_form::get_field_id($field, $scope, $index, $prefix); ?>" 
    <?php echo piklist_form::attributes_to_string($attributes); ?>
  >

    <?php echo !empty($value) ? $value : null; ?>

<?php 
  if (!in_array($tag, array(
    'br'
    ,'col'
    ,'command'
    ,'embed'
    ,'hr'
    ,'img'
    ,'input'
    ,'link'
    ,'meta'
    ,'param'
    ,'source'
  ))): 
?>
  
  </<?php echo $tag; ?> >

<?php endif; ?>