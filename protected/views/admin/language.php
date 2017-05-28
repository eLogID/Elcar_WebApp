
<div class="card">
 <div class="card-content">

 <h5><?php echo t("Manage Language")?></h5>
 
 
 <?php if(is_array($list) && count($list)>=1):?>
 
   <div class="top30"></div>
   <p><?php echo t("Tick the language to enabled")?></p>
  
   <form id="frm" method="POST" onsubmit="return false;">
   <?php echo CHtml::hiddenField('action','saveLanguage')?>
 
    <ul class="collection">
      <?php foreach ($list as $val):?>
       <li class="collection-item">
               
         <?php echo CHtml::checkBox('lang[]',
	      in_array($val,(array)$selected_lang)?true:false
	      ,array(
	        'id'=>$val,
	        'class'=>"with-gap",
	        'value'=>$val
	      ))?>
	      <label for="<?php echo $val?>"><?php echo $val?></label>	
	      	      
       </li>
      <?php endforeach;?>
    </ul>
    
    <div class="card-action" style="margin-top:20px;">
     <button class="btn waves-effect waves-light" type="submit" name="action">
       <?php echo t("Save settings")?>
     </button>
    </div>
         
   </form>  
 <?php else :?>
 <p><?php echo t("No language found")?></p>
 <?php endif;?>
 
 </div>
</div>