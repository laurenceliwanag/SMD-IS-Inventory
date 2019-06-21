<?php

if(isset($_SESSION['userId'])){
   header('Location: home/');
}
else{
   header('Location: login/');
}

?>



<!--------------------DEVELOPED BY LALAINE BALDOVINO ★ LAURENCE HANS LIWANAG ★ ARJAY VERDERA-------------------->