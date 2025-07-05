<style type="text/css">
	
	.modal .modal-dialog .modal-content .modal-body {
	    padding: 0px 25px 0px 26px;
	}

	#detailssec .card-body {
	    padding: 1.5rem 2.5rem;
	}

	@media screen and (max-width: 767px) {
	  #formobile {
	    margin-top: 10px;
	  }

	  #importModal .modal-dialog{
	  	 max-width: 100% !important;
	  }
	}
</style>

<div id="msgAppend1234"></div>

<div class="container-fluid page-body-wrapper">
	<div class="main-panel pnel" >
	   <div class="content-wrapper">
		   	<div class="page-header">
	            <h3 class="page-title"> Array API User Token</h3>

	            <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
	              <li class="breadcrumb-item active" aria-current="page">Array API User Token </li>
	            </ol>
	            
	          </nav>
	        </div>

	        <div class="row mb-4">

	        		<div class="col-md-10">
	        			<h4 class="text-default">userToken: <?php echo $userToken; ?></h4>
	        			<small class="text-info">Note: If userToken not created then something goes wrong</small>
	        		</div>
	        		<div class="col-md-2">
	        			<a onclick="history.back()" class="btn btn-success btn-sm">Go back</a>
	        		</div>
	        </div>
	        <hr>

	        <?php if($userToken !=''){ ?>

	        	<div class="row mt-4" style="display: none;">
	        		<div class="col-md-12">
	        			<h4 class="text-success">Order a Credit Report:</h4>
	        		</div>
	        	</div>

	        	<div class="row mt-1" style="display: none;">
	        		<div class="col-md-12">

	        			<?php

	        				$curl = curl_init();

							curl_setopt_array($curl, array(
							  CURLOPT_URL => 'https://sandbox.array.io/api/report/v2',
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>'{
								  "clientKey": "'.$clientKey.'",
								  "productCode": "tui1bReportScore"
								}',
							  CURLOPT_HTTPHEADER => array(
							    'x-credmo-user-token: '.$userToken.'',
							    'Content-Type: application/json'
							  ),
							));

							$response = curl_exec($curl);
							curl_close($curl);
							$datas = json_decode($response);

	        			?>

	        		</div>
	        	</div>

	        	<div class="row mt-1" style="display: none;">
	        		<div class="col-md-12">
	        			<h4 class="text-default">reportKey: <?php echo $datas->reportKey; ?></h4>
	        		</div>
	        		<div class="col-md-12">
	        			<h4 class="text-default">displayToken: <?php echo $datas->displayToken; ?></h4>
	        		</div>
	        	</div>
	        	


	        	<?php if($datas->reportKey !='' && $datas->displayToken !=''){ ?>

		        	<div class="row mt-4">
		        		<div class="col-md-9">
		        			<h4 class="text-success">Retrieve a Credit Report:</h4>
		        		</div>
		        		<div class="col-md-3">
		        			<a onclick="getJSONdata('<?php echo $datas->reportKey; ?>', '<?php echo $datas->displayToken; ?>')" class="btn btn-success btn-sm">Get JSON</a>
		        			<a onclick="getHTMLdata('<?php echo $datas->reportKey; ?>', '<?php echo $datas->displayToken; ?>')" class="btn btn-success btn-sm">Get HTML</a>
		        		</div>
		        	</div>

		        	<div class="row mt-1">
	        			<div class="col-md-12">

	        				<?php

	        					/*$curl = curl_init();

								curl_setopt_array($curl, array(
								  CURLOPT_URL => 'https://sandbox.array.io/api/report/v2?reportKey='.$datas->reportKey.'&displayToken='.$datas->displayToken.'',
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => '',
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 0,
								  CURLOPT_FOLLOWLOCATION => true,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => 'GET',
								  CURLOPT_HTTPHEADER => array(
								    'Content-Type: application/json'
								  ),
								));

								$response = curl_exec($curl);
								curl_close($curl);
								$datas = json_decode($response);*/

								

	        				?>

	        			</div>

	        			<div class="col-md-12" id="jsonres">
	        				<?php
	        					/*echo '<pre>';
								print_r($datas);
								echo '</pre>';*/
	        				?>
	        			</div>
	        		</div>
	        		



	        	<?php } ?>
	        <?php } ?>


	    </div>
	</div>
</div>
<script type="text/javascript">
	
	function getJSONdata(reportKey, displayToken){

		$.ajax({
				type : 'post',
				url : '<?php echo base_url()."Dashboard/get_json"?>',
				data : {reportKey:reportKey, displayToken:displayToken},
				success: function(res){

					$('#jsonres').html('');
					$('#jsonres').html(res);
				}
		})
	}

	function getHTMLdata(reportKey, displayToken){

		$.ajax({
				type : 'post',
				url : '<?php echo base_url()."Dashboard/get_html"?>',
				data : {reportKey:reportKey, displayToken:displayToken},
				success: function(res){

					$('#jsonres').html('');
					$('#jsonres').html(res);
				}
		})
	}
</script>