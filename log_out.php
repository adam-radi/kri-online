<?php 
session_start();      // نشغل السيشن
session_unset();      // نفرغ كلشي من السيشن
session_destroy();    // نحذف السيشن كامل

header("Location:index.php"); // نرجعو المستخدم لصفحة تسجيل الدخول
exit;
?>   
