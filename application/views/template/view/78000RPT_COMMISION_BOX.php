<?
foreach($viewdata as $rvdata):
endforeach;
$headerrs = $viewrs;
$header = array_shift($headerrs);
$fld_periode = $header->periode;
?>
<script>
var ovp = new Object();
var covp = null;

function hideParBox() {
	window.document.getElementById("parbox").style.visibility="hidden";
	};
function pgoto(page) {
	var pg = page;
	document.getElementById("currentpage").value= pg;
	document.forms["spar"].submit();
	};
function order(ind,sorting) {
	document.getElementById("order").value= ind;
	document.getElementById("sorting").value= sorting;
	document.forms["spar"].submit();
	};
function showParBox() {
	var lb = window.document.getElementById('parbox');
	var ls = lb;
	if (ls.style) { ls = ls.style; };

	var nx = window.document.body.scrollWidth>=0?window.document.body.scrollWidth:window.pageWidth;
	var ww = lb.scrollWidth>=0?lb.scrollWidth:lb.pageWidth;
	var wx = nx/2 - ww/2;

	var ny = window.document.body.scrollHeight>=0?window.document.body.scrollHeight:window.pageHeight;
	var wh = lb.scrollHeight>=0?lb.scrollHeight:lb.pageHeight;
	var wy = ny/2 - wh/2;

	var noPx = window.document.childNodes ? 'px' : 0;

	ls.left = wx+noPx;


	ls.visibility='visible';
	};
	</script>

<div id=parbox class=parbox>
<table class=parbox cellpadding=4 cellspacing=0>
	<tr class=parbox>
		<td align=left class=parbox>
			<b>Search Parameter</b>
			</td>
		<td align=right class=parbox>
			<a href=javascript:hideParBox()>Hide</a>
			</td>
		</tr>
	<tr>
		<td class=parboxsep colspan=2><?  include ("search_view.php"); ?></td>
		</tr>
	</table>
</div>
<?
echo "<form name='spar' id='spar' method='get' action='" . $rvdata->fld_viewnm . "'>";
if (isset($formfield)) {
foreach($formfield as $rff):
echo '<input type="hidden" name="' . $rff->fld_formfieldnm . '" value="' . $this->input->get($rff->fld_formfieldnm) . '">';
endforeach;
}
echo '<input type="hidden" name="currentpage" id="currentpage">';
echo '<input type="hidden" name="order" id="order" value="' . $order . '">';
echo '<input type="hidden" name="sorting" id="sorting" value="' . $sorting . '">';
echo "</form>";
?>

<form>
<table cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#CDCBBF" align="center">
    <td nowrap>Commision Date</td>
    <td nowrap>Vehicle Group</td>
    <td nowrap>Name</td>
    <td nowrap>Total DO</td>
    <td nowrap>Status </td>
    <td nowrap>Job Title</td>
    <td nowrap>Standby Allowence</td>
    <td nowrap>Commision</td>
    <td nowrap>Total</td>
    </tr>
   </tr>
<?

foreach ($viewrs as $rviewrs) {
 $driver_group[] = $rviewrs->Name;
}

$driver = array_unique($driver_group);
foreach ($driver as $rdriver) {
  ${"count" . $rdriver} = 0;
echo "<tr bgcolor='#CDCBBF'>";
echo "<td colspan=9<b>$rdriver</b></td>";
echo "</tr>";

  foreach ($viewrs as $rviewrs) {
    if ($rviewrs->Name == $rdriver) {
   $no=$no+1;
    if ($no % 2 == 1)
    {
    $bgcolor="#FFFFFF";
     }
   else
    {
    $bgcolor="#F5F5F5";
     }

    $total=$rviewrs->Standby_Allowance+$rviewrs->Commission;

    echo "<tr bgcolor=$bgcolor>";
    echo "<td>$rviewrs->commdate</td>";
    echo "<td>$rviewrs->vehgroup</td>";
    echo "<td>$rviewrs->Name</td>";
    echo "<td>$rviewrs->Total_DO</td>";
    echo "<td>$rviewrs->Status</td>";
    echo "<td>$rviewrs->Job_Title</td>";
    echo "<td>$rviewrs->Standby_Allowance</td>";
    echo "<td>$rviewrs->Commission</td>";
    echo "<td>" . number_format($total,2,',','.') . "</td>";
    echo "</tr>";
    if ($rviewrs->Total_DO == 0)
{
     ${"count" . $rdriver}= ${"count" . $rdriver}+ 0;
    }
else
    {
    ${"count" . $rdriver}= ${"count" . $rdriver}+ 1;
    }
    ${"standby" . $rdriver} = ${"standby" . $rdriver} + $rviewrs->Standby_Allowance;
    ${"commision" . $rdriver} = ${"commision" . $rdriver} + $rviewrs->Commision ;
    ${"subtotal" . $rdriver} = ${"subtotal" . $rdriver} + $total;
    
}
}
 

    echo "<tr bgcolor='green'>";
    echo "<td colspan=3> <b>" .  "Total " . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"count" . $rdriver},0,',','.')  . "</b></td>";
    echo "<td colspan=2> <b>" .  " " . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"standby" . $rdriver},0,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"Commision" . $rdriver},0,',','.')  . "</b></td>";
    echo "<td align='right'> <b>" .  number_format( ${"subtotal" . $rdriver},0,',','.')  . "</b></td>";
    echo "</tr>";
}

?>
</table>
<div  style="color:#000000">
<?
echo "Total Record = " . $numrows . "<br>";
/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show shck links
if ($currentpage > 1) {
   // show << link to go shck to page 1
   echo "  <a href=javascript:pgoto(1)><<</a>";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go shck to 1 page
   echo " <a href=javascript:pgoto($prevpage)><</a> ";
} // end if

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
         echo " <a href=javascript:pgoto($x)>$x</a>";
      } // end else
   } // end if
} // end for

// if not on last page, show forward and last page links
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page
   echo " <a href=javascript:pgoto($nextpage)>></a> ";
   // echo forward link for lastpage
    echo " <a href=javascript:pgoto($totalpages)>>></a> ";
} // end if
?>
</div>
<br>
</form>
