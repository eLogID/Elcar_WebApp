<?php
class EmailTemplate
{	
	public static function forgotPasswordRequest()
	{
      $website_title=Yii ::app()->functions->getOptionAdmin('website_title');      
	  return <<<HTML
	  <p>Hi {first_name}</p>
	  <br/>
	  <p>Your password change code is : {code}</p>	  
	  <p>Thank you.</p>
	  <p>- $website_title</p>
HTML;
	}		
		
} /*end class*/