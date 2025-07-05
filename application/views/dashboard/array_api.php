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
	            <h3 class="page-title"> Array API</h3>

	            <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
	              <li class="breadcrumb-item active" aria-current="page">Array API </li>
	            </ol>
	            
	          </nav>
	        </div>

	        <div class="row mb-4">

	        		<div class="col-md-9">
	        			<h4 class="text-default">ClientKey: <?php echo $fetchClientinfo[0]->array_clientkey; ?></h4>
	        			<small class="text-info">Note: If clientKey not created yet please create using "Create A User" button</small>
	        		</div>
	        		<div class="col-md-3">
	        			<a href="<?php echo base_url('create_array_user/'.$clientID.'') ?>" class="btn btn-success btn-sm">Create A User</a>
	        		</div>
	        </div>
	        <hr>
	        <?php if($fetchClientinfo[0]->array_clientkey !=''){ ?>

	        	<div class="row mt-4">
	        		<div class="col-md-12">
	        			<h4 class="text-success">Retrieve Authentication Questions:</h4>
	        		</div>
	        	</div>
	        	<div class="row mt-1">
	        		<div class="col-md-12">
	        			<?php
    						$curl = curl_init();
							curl_setopt_array($curl, array(
							  CURLOPT_URL => 'https://sandbox.array.io/api/authenticate/v2?appKey=3F03D20E-5311-43D8-8A76-E4B5D77793BD&clientKey='.$fetchClientinfo[0]->array_clientkey.'&provider1=tui&provider2=exp&provider3=efx',
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'GET',
							  CURLOPT_HTTPHEADER => array(
							    'Accept: application/json'
							  ),
							));

							$response = curl_exec($curl);
							curl_close($curl);

							$datas = json_decode($response);
							
							// echo "<pre>";
							// // print_r($fetchClientinfo[0]->array_clientkey);
							// print_r($datas);
							// echo "</pre>";
							// die('STOP');

	        			?>

	        			<form method="post" action="<?php echo base_url('submit_answer') ?>">

	        				<input type="hidden" name="authToken" value="<?php echo $datas->authToken;?>">
	        				<input type="hidden" name="clientKey" value="<?php echo $fetchClientinfo[0]->array_clientkey;?>">
	        				<input type="hidden" name="clientID" value="<?php echo $clientID;?>">

	        				<h4 class="text-success">Provider: <?php echo $datas->provider;?></h4>
	        				<?php foreach($datas->questions as $key => $vlaue){ ?>
		        				<div class="row mt-3">
		        					<div class="col-md-12">
		        						<label class=""><strong>Ques:</strong> <?php echo $vlaue->text;?></label>
		        						<select class="form-control" name="<?php echo $vlaue->id;?>" style="color:#423f3f">
		        							<?php foreach($vlaue->answers as $key1 => $vlaue1){ ?>
		        								<option value="<?php echo $vlaue1->id;?>"><?php echo $vlaue1->text;?></option>
		        							<?php } ?>
		        						</select>
		        					</div>
		        				</div>
		        			<?php } ?>

		        			<div class="row mt-3">
	        					<div class="col-md-12">
	        						<button type="submit" name="submit" class="btn btn-success btn-sm">Submit your answer</button>
	        					</div>
	        				</div>
	        				
	        			</form>
	        		</div>
	        	</div>

	        <?php } ?>
	    </div>
	</div>
</div>