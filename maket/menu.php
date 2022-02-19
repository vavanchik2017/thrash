<?
    $menuItems=array(
        0=>array("link"=>"/", "itemName"=>"HOME") ,
        1=>array("link"=>"/pages/underConstruction.php?idPage=1", "itemName"=>"ABOUT"),
        2=>array("link"=>"/pages/underConstruction.php?idPage=2", "itemName"=>"MEETINGS"),
        3=>array("link"=>"/pages/varietes.php?idPage=3", "itemName"=>"CONTACTS"),
        4=>array("link"=>"/maket/loginMaket.php?idPage=3", "itemName"=>"LOGIN"),
        5=>array("link"=>"/pages/register.php?idPage=3", "itemName"=>"SIGN IN"),
    );
?>
<div class="nav-bar">
  <div class="nav-bar-elements">
    <?
    foreach($menuItems as $nItem=>$menuItem){
      if($actItem==$nItem) {     
        echo <<<NITEM
        <p ><a class='active-nav-bar-element' href={$menuItem["link"]}>{$menuItem["itemName"]}</a></p>
NITEM;
      }
      else {
        echo <<<NITEM
        <p class='nav-bar-element'><a class='bar-elem' href={$menuItem["link"]}>{$menuItem["itemName"]}</a></p>
    
NITEM;
      }
    }
    ?>
  </div>
</div>