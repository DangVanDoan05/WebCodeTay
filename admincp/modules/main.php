<div class="clear"></div>
<div class="main">
                <?php
                
               if(isset($_GET['action']))
               {
                $tam= $_GET['action'];
               }else{
                $tam='';
               }
               if($tam=='quanlydanhmucsanpham')
               {
                include("main/danhmuc.php");
               }elseif($tam=='quanlysanpham'){
                include("main/giohang.php");
               }elseif($tam=='quanlybaiviet'){
                include("main/tintuc.php");
               }elseif($tam=='quanlydanhmucbaiviet'){
                include("main/lienhe.php");
               }else{
                include("main/welcome.php");
               }
               
               ?>

</div>