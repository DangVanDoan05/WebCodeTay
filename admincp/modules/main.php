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
                include("modules/quanlydanhmucsp/them.php");
                include("modules/quanlydanhmucsp/lietke.php");
               }
               else{
                if($tam=='quanlybaiviet'){
                include("modules/quanlydanhmucsp/baiviet.php");
               }
               else{
                if($tam=='quanlydanhmucbaiviet'){
                    include("modules/quanlydanhmucsp/quanlydanhmucbaiviet.php");
                   }
                   else{
                include("dashboard.php");
               }}}
               
               ?>

            </div>