<?php 
	$numeroPregunta = 1;
	$numeroRespuesta = 1;
	$file = "nombre_del_archivo.xml";
	$XML = simplexml_load_file($file);
	$questions = $XML->question;
	$typeQuestion = "type";
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=documento.doc");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<!--<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252" />-->
	<title>Exportador de Examen extraordinario</title>
	<style>
		.ok
		{
			background: yellow;
		}
		.matching
		{
			background: fuchsia;
		}
		
	</style>
</head>
<body>
	<?php foreach ($questions as $q): ?>
		
		<?php $numeroRespuesta = 1; ?>

		<?php if ($q->attributes()->$typeQuestion == "multichoice"): ?>
			
			<h4><?=$numeroPregunta?>. <?=$q->questiontext->text?></h4>
			<p>Respuestas:</p>
			<?php foreach ($q->answer as $a):?>
				<p <?php if ($a->attributes()->fraction == "100"):?> class="ok" <?php endif; ?> ><?=$numeroRespuesta?>. <?=$a->text?></p>
				<?php $numeroRespuesta++; ?>
			<?php endforeach; ?>
			<?php $numeroPregunta++; ?>
		<?php endif; ?>

		<?php if ($q->attributes()->$typeQuestion == "truefalse"): ?>
			<h4><?=$numeroPregunta?>. <?=$q->questiontext->text?></h4>
			<p>Respuestas:</p>
			<?php foreach ($q->answer as $a):?>
				<p <?php if ($a->attributes()->fraction == "100"):?> class="ok" <?php endif; ?> ><?=$numeroRespuesta?> <?php if ($a->text == "true"):?>Verdadero<?php else: ?>Falso<?php endif; ?></p>
				<?php $numeroRespuesta++; ?>
			<?php endforeach; ?>
			<?php $numeroPregunta++; ?>
		<?php endif; ?>
		
		<?php if ($q->attributes()->$typeQuestion == "matching"): ?>
			<div>
				<h4 class="matching"><?=$numeroPregunta?>. <?=$q->questiontext->text?></h4>
				<?php foreach ($q->subquestion as $sq):?>
					<p><?=$numeroRespuesta?>. <?=$sq->text?></p>
					<p>Respuesta: <?=$sq->answer->text?></p>
					<?php $numeroRespuesta++; ?>
				<?php endforeach; ?>
			</div>
			<?php $numeroPregunta++; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</body>
</html>