<?php
Yii::setAlias('@common_base', '/chiefsRS/common/');
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

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

//START: Project message
Yii::setAlias('tag_add_message', 'Tag has been added successfully !');
Yii::setAlias('tag_update_message', 'Tag has been updated successfully !');
Yii::setAlias('tag_delete_message', 'Tag has been deleted successfully !');
//END:  Project message

//START: Milestone message
Yii::setAlias('menu_category_add_message', 'Menu Category has been added successfully !');
Yii::setAlias('menu_category_update_message', 'Menu Category has been updated successfully !');
Yii::setAlias('menu_category_delete_message', 'Menu Category has been deleted successfully !');
//END:  Milestone message

//START: Task message
Yii::setAlias('restaurant_add_message', 'Restaurant has been added successfully !');
Yii::setAlias('restaurant_update_message', 'Restaurant has been updated successfully !');
Yii::setAlias('restaurant_delete_message', 'Restaurant has been deleted successfully !');
//END:  Task message

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
Yii::setAlias('user_permission_message', 'User Permission has been updated successfully.');
//END:  User message

//START: Update status of task
Yii::setAlias('milestone_update_status_message', 'Your milestone status has been updated successfully.');
//END:  Update status of task

//START: Update status of task
Yii::setAlias('task_update_status_message', 'Your task status has been updated successfully.');
//END:  Update status of task
//END: BACK-END message 

//START: add leave
Yii::setAlias('create_leave_message', 'Your leave application has been created successfully.');
//END:  add leave

//START: add leave
Yii::setAlias('create_leave_error_message', 'Something went wrong.Please try again later.');
//END:  add leave


//START: update leave
Yii::setAlias('update_leave_message', 'Your leave application has been updated successfully.');
//END:  update leave

//START: update leave
Yii::setAlias('success_add_total_leave', 'Total leaves has been added successfully.');
//END:  update leave

//START: approve leave
Yii::setAlias('success_approve_leave', 'Leave application approved successfully.');
//END:  approve leave

//START: reject leave
Yii::setAlias('success_reject_leave', 'Leave application rejected successfully.');
//END:  reject leave


//START: cancel leave
Yii::setAlias('success_cancel_leave', 'Leave application canceled successfully.');
//END:  cancel leave

//START: cancel leave
Yii::setAlias('error_approve_leave', 'This leave application can not be approved');
//END:  cancel leave


//START: upload document
Yii::setAlias('document_upload_success_message', 'Document has been uploaded successfully.');
//END: upload document


//START: error upload document
Yii::setAlias('document_upload_error_message', 'Something went wrong.Please try again later.');
//END:  error upload document

//START: download document
Yii::setAlias('document_delete_success_message', 'Document has been deleted successfully.');
//END: delete document

//START: Milestone successfully sent for QA
Yii::setAlias('success_send_for_qa', 'Milestone has been successfully sent for QA.');
//END: Milestone successfully sent for QA

//START: QA approval
Yii::setAlias('success_qa_approval', 'Milestone has been successfully approved by QA.');
//END: QA approval

//START: add technical skills
Yii::setAlias('success_add_technical_skills', 'Technical skills have been added successfully.');
//END:   add technical skills

//START: technology
Yii::setAlias('technology_create_message', 'Technology has been added successfully !');
Yii::setAlias('technology_update_message', 'Technology has been updated successfully !');
Yii::setAlias('technology_delete_message', 'Technology has been deleted successfully !');
//START: technology
