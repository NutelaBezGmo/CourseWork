<?php
$days = array();
for ($i=12; $i >=0; $i--) {
  $days[] = new DateTime("-$i day");
}
print $days[0]->format('M d');
?>
