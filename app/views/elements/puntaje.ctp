<div id="contresultinferior">
<!-- InstanceBeginEditable name="EditRegion4" --><div id="puntajeenpie">
  <table id="tablita" width="675" height="111" border="0">
    <tr>
      <td width="134" height="27">&nbsp;</td>
      <td width="186">&nbsp;</td>
      <td width="166">&nbsp;</td>
      <td width="171">&nbsp;</td>
    </tr>
    <tr>
		<td height="78">
			<?php if ($puntos_total > 45000) {
				$medalla = 'medal_oro.png';
			} elseif ($puntos_total > 25000) {
				$medalla = 'medal_plata.png';
			} else {
				$medalla = 'medal_bronce.png';
			}
			?>
			<img src="<?php echo $html->url('/img/') . $medalla; ?>" width="72" height="70" border="0" />
		</td>
		<td><?php echo (int)$puntos_amigo; ?></td>
		<td><?php echo (int)$puntos_bonus; ?></td>
		<td><strong><?php echo (int)$puntos_total; ?></strong></td>
    </tr>
  </table>
</div><!-- InstanceEndEditable -->
</div>
