<?php
if ($_SERVER['HTTP_HOST'] == "localhost"){
	
	Yii::setAlias('@common_base', '/chiefsRS/common/');

}else{

	Yii::setAlias('@common_base', '/../../../chiefsrs_zenocraft_com/common/');
}
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@root', realpath(dirname(__FILE__).'/../../'));

//START: site configuration
Yii::setAlias('site_title', 'Chiefs RS');
Yii::setAlias('site_footer', 'Chiefs RS');
//END: site configuration

//START: BACK-END message

//START: Admin users 
Yii::setAlias('admin_user_change_password_msg', 'Your password has been changed successfully !');
Yii::setAlias('admin_user_forget_password_msg', 'E-Mail has been sent with new password successfully !');
//END: Admin user

//START: Email template message
Yii::setAlias('email_template_add_message', 'Template has been added successfully !');
Yii::setAlias('email_template_update_message', 'Template has been updated successfully !');
Yii::setAlias('email_template_delete_message', 'Template has been deleted successfully !');
//END: Email template message

//START: Tag message
Yii::setAlias('tag_add_message', 'Tag has been added successfully !');
Yii::setAlias('tag_update_message', 'Tag has been updated successfully !');
Yii::setAlias('tag_delete_message', 'Tag has been deleted successfully !');
//END:  Tag message

//START: Menu Category message
Yii::setAlias('menu_category_add_message', 'Menu Category has been added successfully !');
Yii::setAlias('menu_category_update_message', 'Menu Category has been updated successfully !');
Yii::setAlias('menu_category_delete_message', 'Menu Category has been deleted successfully !');
//END:  Menu Category message

//START: Restaurant message
Yii::setAlias('restaurant_add_message', 'Restaurant has been added successfully !');
Yii::setAlias('restaurant_update_message', 'Restaurant has been updated successfully !');
Yii::setAlias('restaurant_delete_message', 'Restaurant has been deleted successfully !');
//END:  Restaurant message

//START: Restaurant Gallery message
Yii::setAlias('restaurant_gallery_add_message', 'Photo has been added successfully !');
Yii::setAlias('restaurant_gallery_update_message', 'Photo has been updated successfully !');
Yii::setAlias('restaurant_gallery_delete_message', 'Photo has been deleted successfully !');
//END:  Restaurant Gallery message

//START: Restaurant Menu message
Yii::setAlias('restaurant_menu_add_message', 'Menu has been added successfully !');
Yii::setAlias('restaurant_menu_update_message', 'Menu has been updated successfully !');
Yii::setAlias('restaurant_menu_delete_message', 'Menu has been deleted successfully !');
//END:  Restaurant Menu message
Yii::setAlias('restaurant_mealtime_update_message', 'Meal Time has been updated successfully !');
Yii::setAlias('restaurant_working_hours_update_message', "Restaurant's Working Hours has been updated successfully !");

//START: Page message
Yii::setAlias('page_add_message', 'Page has been added successfully !');
Yii::setAlias('page_update_message', 'Page has been updated successfully !');
Yii::setAlias('page_delete_message', 'Page has been deleted successfully !');
//END:  Page message

//START: User message
Yii::setAlias('user_add_message', 'User has been added successfully !');
Yii::setAlias('user_update_message', 'User has been updated successfully !');
Yii::setAlias('user_delete_message', 'User has been deleted successfully !');
//END:  User message

//START: User message
Yii::setAlias('hours_update_message', "Restaurant's Hours has been updated successfully.");
//END:  User message

//START: Restaurant layout message
Yii::setAlias('restaurant_layout_add_message', 'Layout has been added successfully !');
Yii::setAlias('restaurant_layout_update_message', 'Layout has been updated successfully !');
Yii::setAlias('restaurant_layout_delete_message', 'Layout has been deleted successfully !');
//END:  Restaurant layout message


//START: Restaurant table message
Yii::setAlias('restaurant_table_add_message', 'Table has been added successfully !');
Yii::setAlias('restaurant_table_update_message', 'Table has been updated successfully !');
Yii::setAlias('restaurant_table_delete_message', 'Table has been deleted successfully !');
//END:  Restaurant table message

//START: Admin users 
Yii::setAlias('reset_password_message', 'Your password has been sent successfully !');
//Yii::setAlias('admin_user_forget_password_msg', 'E-Mail has been sent with new password successfully !');
//END: Admin user

////////Frontend Users///////////////

Yii::setAlias('create_booking_message', 'Your Booking has been done successfully !');
Yii::setAlias('update_booking_message', 'Your Booking has been updated successfully !');
Yii::setAlias('cancel_booking_message', 'Your Booking has been canceled successfully !');
Yii::setAlias('delete_booking_message', 'Your Booking has been deleted successfully !');

