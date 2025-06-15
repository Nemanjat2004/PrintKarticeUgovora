<?php

    include 'db.class.7.php';
    $db = DBstambena();
    //$db->query("SET NAMES UTF8");
    $idugovora = $_GET['id'];
    $q         = "SELECT
    stranke.ime,
    stranke.prezime,
    stanovi.naziv,
    stanovi.adresa,
    ugovori.broj_ugovora,
    ugovori.ukupan_iznos,
    ugovori.datum_vazenja AS ugovor_datum,
    ugovori.broj_rata,
    ugovori.devizni,
    ugovori.id AS idugovora,
    rate.redni_broj,
    rate.rev_vrednost AS duguje,
    NULL AS potrazuje,
    rate.datum AS datum,
    'rate' AS source

FROM rate
JOIN ugovori ON rate.id_ugovora = ugovori.id
JOIN stranke ON ugovori.id_stranke = stranke.id
JOIN stanovi ON ugovori.id_stana = stanovi.id

WHERE ugovori.id = 18

UNION ALL

SELECT
    stranke.ime,
    stranke.prezime,
    stanovi.naziv,
    stanovi.adresa,
    ugovori.broj_ugovora,
    ugovori.ukupan_iznos,
    ugovori.datum_vazenja AS ugovor_datum,
    ugovori.broj_rata,
    ugovori.devizni,
    ugovori.id AS idugovora,
    NULL AS redni_broj,
    NULL AS duguje,
    izvod.potrazuje,
    izvod.datum AS datum,
    'izvod' AS source

FROM izvod
JOIN uplata ON uplata.id_izvoda = izvod.id
JOIN ugovori ON uplata.id_ugovora = ugovori.id
JOIN stranke ON ugovori.id_stranke = stranke.id
JOIN stanovi ON ugovori.id_stana = stanovi.id

WHERE ugovori.id = ?
ORDER BY datum ASC;
     ";
    $result = $db->prepareAndExecute($q, "i", $idugovora);
    $row    = $db->fetchNextObject($result);
    if (! $row) {
        die("Nema podataka za prikaz.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Izvestaj zbirna otprema</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">




  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page {
        size: A4 landscape; margin: 10mm;
    }

    @media print {
        .pagebreak { page-break-before: always; } /* page-break-after works, as well */
    }

</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>

</script>


<style>
body {
	color: #566787;
	background: #f5f5f5;
	font-family: 'Varela Round', sans-serif;
	font-size: 13px;
}
.table-responsive {
    margin: 15px 0;
}
.table-wrapper {
	background: #fff;
	//padding: 20px 25px;
	border-radius: 3px;
	//min-width: 1000px;
	box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
	padding-bottom: 15px;
	background: #435d7d;
	color: #fff;
	padding: 16px 30px;
	min-width: 100%;
	margin: -20px -25px 10px;
	border-radius: 3px 3px 0 0;
}
.title-page {
    color: white;
}

.title-page h2 {
    margin: 5px 10px 0;
    font-size: 24px;
}

.table-title h2 {
	margin: 5px 0 0;
	font-size: 24px;
}
.table-title .btn-group {
	float: right;
}
.table-title .btn {
	color: #fff;
	float: right;
	font-size: 13px;
	border: none;
	min-width: 50px;
	border-radius: 2px;
	border: none;
	outline: none !important;
	margin-left: 10px;
}
.table-title .btn i {
	float: left;
	font-size: 21px;
	margin-right: 5px;
}
.table-title .btn span {
	float: left;
	margin-top: 2px;
}
table.table tr th, table.table tr td {
	border-color: #e9e9e9;
	padding: 12px 15px;
	vertical-align: middle;
}
table.table tr th:first-child {
	width: 60px;
}
table.table tr th:last-child {
	width: 100px;
}
table.table-striped tbody tr:nth-of-type(odd) {
	background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
	background: #f5f5f5;
}
table.table th i {
	font-size: 13px;
	margin: 0 5px;
	cursor: pointer;
}
table.table td:last-child i {
	opacity: 0.9;
	font-size: 22px;
	margin: 0 5px;
}
table.table td a {
	font-weight: bold;
	color: #566787;
	display: inline-block;
	text-decoration: none;
	outline: none !important;
}
table.table td a:hover {
	color: #2196F3;
}
table.table td a.edit {
	color: #FFC107;
}
table.table td a.delete {
	color: #F44336;
}
table.table td i {
	font-size: 19px;
}
table.table .avatar {
	border-radius: 50%;
	vertical-align: middle;
	margin-right: 10px;
}
.pagination {
	float: right;
	margin: 0 0 5px;
}
.pagination li a {
	border: none;
	font-size: 13px;
	min-width: 30px;
	min-height: 30px;
	color: #999;
	margin: 0 2px;
	line-height: 30px;
	border-radius: 2px !important;
	text-align: center;
	padding: 0 6px;
}
.pagination li a:hover {
	color: #666;
}
.pagination li.active a, .pagination li.active a.page-link {
	background: #03A9F4;
}
.pagination li.active a:hover {
	background: #0397d6;
}
.pagination li.disabled i {
	color: #ccc;
}
.pagination li i {
	font-size: 16px;
	padding-top: 6px
}
.hint-text {
	float: left;
	margin-top: 10px;
	font-size: 13px;
}
/* Custom checkbox */
.custom-checkbox {
	position: relative;
}
.custom-checkbox input[type="checkbox"] {
	opacity: 0;
	position: absolute;
	margin: 5px 0 0 3px;
	z-index: 9;
}
.custom-checkbox label:before{
	width: 18px;
	height: 18px;
}
.custom-checkbox label:before {
	content: '';
	margin-right: 10px;
	display: inline-block;
	vertical-align: text-top;
	background: white;
	border: 1px solid #bbb;
	border-radius: 2px;
	box-sizing: border-box;
	z-index: 2;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
	content: '';
	position: absolute;
	left: 6px;
	top: 3px;
	width: 6px;
	height: 11px;
	border: solid #000;
	border-width: 0 3px 3px 0;
	transform: inherit;
	z-index: 3;
	transform: rotateZ(45deg);
}
.custom-checkbox input[type="checkbox"]:checked + label:before {
	border-color: #03A9F4;
	background: #03A9F4;
}
.custom-checkbox input[type="checkbox"]:checked + label:after {
	border-color: #fff;
}
.custom-checkbox input[type="checkbox"]:disabled + label:before {
	color: #b8b8b8;
	cursor: auto;
	box-shadow: none;
	background: #ddd;
}
/* Modal styles */
.modal .modal-dialog {
	max-width: 400px;
}
.modal .modal-header, .modal .modal-body, .modal .modal-footer {
	padding: 20px 30px;
}
.modal .modal-content {
	border-radius: 3px;
	font-size: 14px;
}
.modal .modal-footer {
	background: #ecf0f1;
	border-radius: 0 0 3px 3px;
}
.modal .modal-title {
	display: inline-block;
}
.modal .form-control {
	border-radius: 2px;
	box-shadow: none;
	border-color: #dddddd;
}
.modal textarea.form-control {
	resize: vertical;
}
.modal .btn {
	border-radius: 2px;
	min-width: 100px;
}
.modal form label {
	font-weight: normal;
}
.my-i{
    float: left;
    font-size: 21px;
    margin-right: 5px;
    padding-top: 3px;
}
.my-span{
    float: left;
    margin-top: 2px;
}
table.table tr td{
    border-color: #e9e9e9;
    padding: 2px 15px;
    vertical-align: middle;
	border: solid black 1px;
	white-space: nowrap;
	overflow: hidden;
}
.table-responsive {
    margin: 0px 0;
}
</style>
<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;
			});
		} else{
			checkbox.each(function(){
				this.checked = false;
			});
		}
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
</head>
<body style="background:white;">
<div class="container-xl">
  <div class="row" style="background-color: orange; color: white; padding: 10px;">
    <div class="col-6 text-start">
      <h3 style="margin: 0;">Primer agencija</h3>
    </div>
    <div class="col-6 text-end">
      <h3 style="margin: 0;">Primer agencija za nekretnine</h3>
    </div>
  </div>

  <!-- INFO BLOK -->
  <div class="row mt-3">
    <div class="col-12">
      <div class="p-3 border rounded shadow-sm" style="background-color: #ffffff;">
        <div class="row">
          <div class="col-6 text-start">
            <strong>Primer agencija grada Novog Sada</strong><br>
            Adresa: Bulevar Oslobođenja 123<br>
            Grad: Novi Sad<br>
            Država: Srbija
          </div>
          <div class="col-6 text-end">
            Email: info@primeragencija.rs<br>
            Telefon: +381 21 123 456
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- RAČUN I PIB -->
  <div class="row mt-2">
    <div class="col-6 text-start">
      Broj računa: 160-123456789-10
    </div>
    <div class="col-6 text-end">
      PIB: 123456789
    </div>
  </div>

  <!-- PODNASLOV -->
  <div class="row mt-4">
    <div class="col-6 text-start">
      <h4 style="margin-bottom: 0;"><?php echo $row->ime . ' ' . $row->prezime . " - " . $row->naziv ?></h4>
    </div>
    <div class="col-6 text-end">
      Datum važenja ugovora:                                                                                                                                                                               <?php echo date('d.m.Y', strtotime($row->ugovor_datum)); ?>
    </div>
  </div>

  <!-- TABELA -->
  <div class="row mt-3">
    <div class="col-12">
      <table class="table table-bordered table-striped" style="width: 100%; border: 1px solid black;">
        <thead style="background-color: #f2f2f2;">
          <tr>
            <th style="border: 1px solid black; width: 10%">R.Br.</th>
            <th style="border: 1px solid black; width: 20%">Datum</th>
            <th style="border: 1px solid black; width: 35%">Duguje</th>
            <th style="border: 1px solid black; width: 35%">Potražuje</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $i = 1;
              if ($row) {
                  do {
                      $duguje    = $row->duguje;
                      $potrazuje = $row->potrazuje;
                      $datum     = date('d.m.Y', strtotime($row->datum));
                      echo "<tr>";
                      echo "<td style='border: 1px solid black;'>$i</td>";
                      echo "<td style='border: 1px solid black;'>$datum</td>";
                      echo "<td style='border: 1px solid black;'>$duguje</td>";
                      echo "<td style='border: 1px solid black;'>$potrazuje</td>";
                      echo "</tr>";
                      $i++;
                  } while ($row = $db->fetchNextObject($result));
              }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  window.onload = function() {
    //window.print();
  }
</script>
</body>

</html>
