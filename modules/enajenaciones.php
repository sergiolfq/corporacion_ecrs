<?php
if(!isset($_SESSION["user"])  ){
	require("soporte_error.php");
}else{
	
?>

        <table width="980" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th valign="top" scope="col"><?= $Banners->showBanners(6);?></th>
            </tr>
        </table>
            <br />
            <table width="980" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="720" height="auto" valign="top" scope="col">
                <iframe frameborder="0" width="980" height="900" src="soporte/login.php" ></iframe>
                </th>
                <!--<th width="260" align="center" valign="top" scope="col"><?php// require("inc_right.php") ?></th>-->
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
                <th align="center" valign="top" scope="col">&nbsp;</th>
              </tr>
          </table>


<?php
}
?>





