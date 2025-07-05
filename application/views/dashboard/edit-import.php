<div class="container-fluid page-body-wrapper">
	<div class="main-panel pnel" >
	   <div class="content-wrapper">
		   	<div class="page-header">
	            <h3 class="page-title"> Edit Import Report (<?php echo $get_client_info->sq_first_name.' '.$get_client_info->sq_last_name;?>) </h3>
	            <nav aria-label="breadcrumb">
	            <!-- <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Home</a></li>
	              <li class="breadcrumb-item active" aria-current="page">Edit import</li>
	            </ol> -->
	            <button type="button" onclick="locatioBack();" class="btn btn-gradient-primary btn-sm float-left btn-icon-text"> 
	            	<i class="mdi mdi-arrow-left-thick btn-icon-prepend"></i> Back </button>
	          </nav>
	        </div>

	        <form method="post" action="<?php echo base_url();?>update_audit">
		        <div class="row">
		        	<div class="col-12">
	        			<input type="hidden" name="clientid" value="<?php echo get_encoded_id($get_client_info->sq_client_id);?>">
	        			<textarea name="source_codess" id="summernoteExample" class="textarea" required="required"><?php echo $source_codess[0]->source_code; ?></textarea>
		        	</div>
		        </div>
		        <div class="row mt-4">
		        	<div class="col-12 text-right">
		        		<button type="submit" name="edit" class="btn btn-gradient-success">Save & View Report</button>
		        	</div>
		        </div>
		    </form>
	    </div>
	</div>
</div>