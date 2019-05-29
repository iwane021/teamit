<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Team IT</title>
        <link rel="stylesheet" href="liststyle.css" >
    </head>
<body>

<?php
    $jsondata = file_get_contents('data.json');
    $getjson = json_decode($jsondata);  

    $url = $_SERVER['REQUEST_URI'];
    $x = pathinfo($url);
    $CurrentUrl = 'http://'.$_SERVER['HTTP_HOST'].$x["dirname"];
?>
<div id="container">
    <div class="marquee">
        <p>Berikut ini contoh form inputan untuk memanage Tim IT. Untuk perintah crud ini saya buat hanya menggunakan file json, tanpa database. Silahkan dikembangkan sesuai kebutuhan anda masing-masing</p>
    </div>

    <table id="teams">
        <tr>
            <th>No</th>
            <th width="11%">Profile</th>
            <th width="12%">Name</th>
            <th width="12%">Jabatan</th>
            <th width="12%">Email</th>
            <th>Phone</th>
            <th width="20%">Jobdesc</th>
            <th>Motto</th>
            <th></th>
        </tr>
        <?php 
		if ($getjson) :
			if (count($getjson->team) > 0) :
				foreach ($getjson->team as $index => $value) { ?>
				
				<tr>
					<td class="center"><?php echo $index + 1; ?></td>
					<td class="center"><img src="<?php echo $value->profile; ?>"> </td>
					<td>
					<?php
						$name = $value->firstname;
						$name .= ($value->middlename !== '') ? ' '.$value->middlename : $value->middlename;
						$name .= ' '.$value->lastname;
						echo $name;
					?>
					</td>
					<td><?php echo $value->jabatan; ?></td>
					<td><?php echo $value->email; ?></td>
					<td class="center"><?php echo ($value->phoneext === '') ? '-' : $value->phoneext; ?></td>
					<td><pre><?php echo $value->jobdesc; ?></pre></td>
					<td><div style="word-break:break-all;"><?php echo $value->motto; ?></div></td>
					<td>
						<a href="<?php echo $CurrentUrl.'/edit.php?id='.$index; ?>">EDIT</a>
						<a href="<?php echo $CurrentUrl.'/delete.php?id='.$index; ?>">HAPUS</a>
					</td>
				</tr>
			<?php 
				}
			else : ?>
				<tr>
					<td colspan="9" class="center"> No Data Record</td>
				</tr>
			<?php endif; ?>
	<?php else : ?>
				<tr>
					<td colspan="9" class="center"> No Data Record</td>
				</tr>
	<?php endif; ?>
    </table>
	
    <div class="links">
        <p><a href="<?php echo $CurrentUrl; ?>"><< Back to index</a></p>
    </div>
<footer>
    &copy; Copyright - IT Team 2019
</footer>
</div>

</body>
</html>
