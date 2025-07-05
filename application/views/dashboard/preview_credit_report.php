<?php
$creditScore = [];
$dateOfBirth = [];
$names = [];
$fullAddress=[];
$pfullAddress=[];
$revolvingAccounts = [];
$totalInquires=[];
$totalPublicRecords=[];
$totalCollections=[];
$totalAccounts=[];
$totalbalance=[];
$totalpayment=[];
$reportdate='';
$client_id = get_encoded_id($client[0]->sq_client_id);
if (!empty($reports[0]->report)) {
    $reportData = json_decode($reports[0]->report);
$reportdate = date('Y-m-d', (int) ($reportData->generatedDate / 1000));
    if (!empty($reportData->providerViews)) {
        foreach ($reportData->providerViews as $view) {
            if (isset($view->summary->creditScore->score)) {
                $creditScore[] = $view->summary->creditScore->score;
            }
            if (isset($view->summary->subject->dateOfBirth)) {
                $dateOfBirth[] = date('Y-m-d', $view->summary->subject->dateOfBirth / 1000);
              
            }
             if (isset($view->summary->subject->dateOfBirth)) {
                $dateOfBirth[] = date('Y-m-d', $view->summary->subject->dateOfBirth / 1000);
              
            }
            if (isset($view->summary->subject->currentName)) {
                $nameParts = [];
                $currentName = $view->summary->subject->currentName;
                if (!empty($currentName->firstName)) {
                    $nameParts[] = $currentName->firstName;
                }
                if (!empty($currentName->middleName)) {
                    $nameParts[] = $currentName->middleName;
                }
                if (!empty($currentName->lastName)) {
                    $nameParts[] = $currentName->lastName;
                }
                if (!empty($currentName->suffix)) {
                    $nameParts[] = $currentName->suffix;
                }
            
                $fullName = implode(' ', $nameParts);
                $names[] = $fullName;
            }
            if (isset($view->summary->subject->currentAddress)) {
                $address = $view->summary->subject->currentAddress;
                $addressParts = [];
                if (!empty($address->line1)) $addressParts[] = $address->line1;
                if (!empty($address->line2)) $addressParts[] = $address->line2;
                if (!empty($address->line3)) $addressParts[] = $address->line3;
                if (!empty($address->line4)) $addressParts[] = $address->line4;
                if (!empty($address->line5)) $addressParts[] = $address->line5;
                $fullAddress[] = implode(', ', array_filter($addressParts));
            }
            if (isset($view->summary->subject->previousAddresses)) {
                $paddress = $view->summary->subject->previousAddresses;
                $paddressParts = [];
                if (!empty($paddress->line1)) $paddressParts[] = $paddress->line1;
                if (!empty($paddress->line2)) $paddressParts[] = $paddress->line2;
                if (!empty($paddress->line3)) $paddressParts[] = $paddress->line3;
                if (!empty($paddress->line4)) $paddressParts[] = $paddress->line4;
                if (!empty($paddress->line5)) $paddressParts[] = $paddress->line5;
                $pfullAddress[] = implode(', ', array_filter($paddressParts));
            }
            if (isset($view->revolvingAccounts)) {
                $revolvingAccounts[] = $view->revolvingAccounts;
            }
            if (isset($view->summary->totalPublicRecords)) {
                $totalPublicRecords[] = $view->summary->totalPublicRecords;
            }
            if (isset($view->summary->totalInquires)) {
                $totalInquires[] = $view->summary->totalInquires;
            }
             if (isset($view->summary->totalCollections)) {
                $totalCollections[] = $view->summary->totalCollections;
            }
             if (isset($view->summary->totalOpenAccounts->totalAccounts)) {
                $totalAccounts[] = $view->summary->totalOpenAccounts->totalAccounts;
            }
            if (isset($view->summary->totalOpenAccounts->balance->amount)) {
                $totalbalance[] = $view->summary->totalOpenAccounts->balance->amount;
            }
            if (isset($view->summary->totalOpenAccounts->monthlyPaymentAmount->amount)) {
                $totalpayment[] = $view->summary->totalOpenAccounts->monthlyPaymentAmount->amount;
            }
          
        }
    }
}

?>
<style type="text/css">
.card-text{
    font-size: 12px;
}
.score{
    display: grid;
    justify-content: center;
    text-align: center;
    font-size: 50px;
}
  #loader {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  }
    .swal2-modal .swal2-icon,
  .swal2-modal .swal2-success-ring {
    margin-top: 0 !important;
    margin-bottom: 0px !important;
  }

</style>


<div id="loader">
  <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
</div>
<div class="container-fluid page-body-wrapper">
	<div class="main-panel pnel">
		<div class="content-wrapper">

			<div class="row">
				<div class="col-md-12 navigation_mini" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content:center;">

					<a type="button" href="<?php echo base_url(); ?>dashboard/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-account-circle"></i> Dashboard</a>

					<a type="button" href="<?php echo base_url(); ?>import_audit/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="active btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-file-document"></i> Import/Audit</a>

					<a type="button" href="<?php echo base_url(); ?>pending_report/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-file-powerpoint"></i> Tag Pending Report</a>


          <a type="button" href="<?php echo base_url(); ?>generate-letters/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Generate Letters</a>

					<a type="button" href="<?php echo base_url(); ?>send_letter/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Send Letters</a>

					<a type="button" href="<?php echo base_url('letters-status/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-email"></i> Letters & Status
					</a>

					<a type="button" href="<?php echo base_url('dispute_items/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-note-plus"></i> Dispute Items</a>

					<a type="button" href="<?php echo base_url('messages/send/' . get_encoded_id($client[0]->sq_client_id)); ?>" class="btn btn-icons btn-light text-success mb-2 navigation-buttons"><i class="mdi mdi-comment"></i> Messages
					</a>

				</div>
			</div>
			<div class="row">
				<div class="col-md-12" id="formobile">
					<div class="card">

						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h4 class="heading-h4 table-heading"><b>Preview Credit Report</b> (<?php echo htmlspecialchars($get_client_info->sq_first_name . ' ' . $get_client_info->sq_last_name); ?>) </h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
              <div class="form-group row mt-3" style="padding: 0 20px;justify-content: end;">
                            <button type="button" class="btn btn-outline-success btn-icon-text mr-2" id="Pendingreportdelete" style="display:none">Delete the pending credit report</button>
               <a  href="<?php echo base_url(); ?>simple_audit/<?php echo get_encoded_id($client[0]->sq_client_id); ?>" class="btn btn-outline-success btn-icon-text mr-2" id="simpleAudit">Save This Report As Pending And Run Simple Audit</a>
              <button type="button" class="btn btn-success btn-icon-text" id="PendingLetter">Save This Report As Pending And Finish Later</button>
            </div>
            <h5 class="card-title">Personal Profile</h5>
            <span class="card-text d-block">
                Personal information as it appears on the credit file. Check carefully, as inaccuracies can mean identity theft.
                If any personal information is incorrect, click the record to save it as a saved dispute item for the wizard.
            </span>
            <div class="table-responsive">
            <table class="table table-bordered shadow-sm mt-3">
              <thead class="thead-light">
                <tr>
                <th></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Score</td>
                      <td><b><?= $creditScore[0]; ?></b></td>
                      <td><b><?= $creditScore[1]; ?></b></td>
                      <td><b><?= $creditScore[2]; ?></b></td>
                  </tr>
                  <tr>
                      <td>Credit Report Date:</td>
                      <td><?= $reportdate ?? '-'; ?></td>
                      <td><?= $reportdate ?? '-'; ?></td>
                      <td><?= $reportdate ?? '-'; ?></td>
                  </tr>
                  <tr>
                      <td>Year of Birth:</td>
<td>
    <?php if (!empty($dateOfBirth[0])): ?>
        <input type="checkbox" class="mr-2" id="dob1" value="<?= $dateOfBirth[0]; ?>">
    <?php endif; ?>
    <?= $dateOfBirth[0] ?? ''; ?>
</td>
<td>
    <?php if (!empty($dateOfBirth[1])): ?>
        <input type="checkbox" class="mr-2" id="dob2" value="<?= $dateOfBirth[1]; ?>">
    <?php endif; ?>
    <?= $dateOfBirth[1] ?? ''; ?>
</td>
<td>
    <?php if (!empty($dateOfBirth[2])): ?>
        <input type="checkbox" class="mr-2" id="dob3" value="<?= $dateOfBirth[2]; ?>">
    <?php endif; ?>
    <?= $dateOfBirth[2] ?? ''; ?>
</td>


                  </tr>
                  <tr>
                      <td>Name:</td>
<td>
    <?php if (!empty($names[0])): ?>
        <input type="checkbox" class="mr-2" name="name1" id="name1" value="<?= $names[0]; ?>">
    <?php endif; ?>
    <?= $names[0] ?? ''; ?>
</td>
<td>
    <?php if (!empty($names[1])): ?>
        <input type="checkbox" class="mr-2" name="name2" id="name2" value="<?= $names[1]; ?>">
    <?php endif; ?>
    <?= $names[1] ?? ''; ?>
</td>
<td>
    <?php if (!empty($names[2])): ?>
        <input type="checkbox" class="mr-2" name="name3" id="name3" value="<?= $names[2]; ?>">
    <?php endif; ?>
    <?= $names[2] ?? ''; ?>
</td>


                  </tr>
                  <tr>
                      <td>Former:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                   <tr>
                      <td>Also Known As:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                   <tr>
                      <td>Current Addresses:</td>
 <td>
    <?php if (!empty($fullAddress[0])): ?>
        <input type="checkbox" class="mr-2" id="fullAddress1" value="<?= $fullAddress[0]; ?>">
    <?php endif; ?>
    <?= $fullAddress[0] ?? ''; ?>
</td>
<td>
    <?php if (!empty($fullAddress[1])): ?>
        <input type="checkbox" class="mr-2"  id="fullAddress2" value="<?= $fullAddress[1]; ?>">
    <?php endif; ?>
    <?= $fullAddress[1] ?? ''; ?>
</td>
<td>
    <?php if (!empty($fullAddress[2])): ?>
        <input type="checkbox" class="mr-2" id="fullAddress3" value="<?= $fullAddress[2]; ?>">
    <?php endif; ?>
    <?= $fullAddress[2] ?? ''; ?>
</td>


                  </tr>
                   <tr>
                      <td>Previous Addresses:</td>
                  <td>
    <?php if (!empty($pfullAddress[0])): ?>
        <input type="checkbox" class="mr-2" id="pfullAddress1" value="<?= $pfullAddress[0]; ?>">
    <?php endif; ?>
    <?= $pfullAddress[0] ?? ''; ?>
</td>
<td>
    <?php if (!empty($pfullAddress[1])): ?>
        <input type="checkbox" class="mr-2" id="pfullAddress2" value="<?= $pfullAddress[1]; ?>">
    <?php endif; ?>
    <?= $pfullAddress[1] ?? ''; ?>
</td>
<td>
    <?php if (!empty($pfullAddress[2])): ?>
        <input type="checkbox" class="mr-2" id="pfullAddress3" value="<?= $pfullAddress[2]; ?>">
    <?php endif; ?>
    <?= $pfullAddress[2] ?? ''; ?>
</td>

                  </tr>
                   <tr>
                      <td>Previous Employer(s):</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
              </tbody>
              </table>
              </div>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Credit Summary</h5>
            <span class="card-text d-block">
                An overview of present and past credit status including open and closed accounts and balance information.
            </span>
            <div class="table-responsive">
            <table class="table table-bordered shadow-sm mt-3">
              <thead class="thead-light">
                <tr>
                <th></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Total Accounts:</td>
                       <td><?= $totalAccounts[0] ?? '0' ; ?></td>
                      <td><?= $totalAccounts[1] ?? '0' ; ?></td>
                      <td><?= $totalAccounts[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Open Accounts:</td>
                        <td><?= $totalAccounts[0] ?? '0' ; ?></td>
                      <td><?= $totalAccounts[1] ?? '0' ; ?></td>
                      <td><?= $totalAccounts[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Closed Accounts:</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                  </tr>
                  <tr>
                      <td>Delinquent:</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                  </tr>
                  <tr>
                      <td>Derogatory:</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                  </tr>
                  <tr>
                      <td>Collection:</td>
                      <td><?= $totalCollections[0] ?? '0' ; ?></td>
                      <td><?= $totalCollections[1] ?? '0' ; ?></td>
                      <td><?= $totalCollections[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Balances:</td>
                      <td>$<?= $totalbalance[0] ?? '0' ; ?></td>
                      <td>$<?= $totalbalance[1] ?? '0' ; ?></td>
                      <td>$<?= $totalbalance[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Payments:</td>
                      <td>$<?= $totalpayment[0] ?? '0' ; ?></td>
                      <td>$<?= $totalpayment[1] ?? '0' ; ?></td>
                      <td>$<?= $totalpayment[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Public Records:</td>
                      <td><?= $totalPublicRecords[0] ?? '0' ; ?></td>
                      <td><?= $totalPublicRecords[1] ?? '0' ; ?></td>
                      <td><?= $totalPublicRecords[2] ?? '0' ; ?></td>
                  </tr>
                  <tr>
                      <td>Inquiries(2 years):</td>
                      <td><?= $totalInquires[0] ?? '0' ; ?></td>
                      <td><?= $totalInquires[1] ?? '0' ; ?></td>
                      <td><?= $totalInquires[2] ?? '0' ; ?></td>
                  </tr>
              </tbody>
              </table>
              </div>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Credit Inquiries</h5>
            <span class="card-text d-block">
                Organizations who have obtained a copy of your Credit Report. Inquiries can remain on a credit file for up to two years.
            </span>
            <div class="table-responsive">
              <table class="table table-bordered shadow-sm mt-3">
              <thead class="thead-light">
                <tr>
                <th></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                </tr>
              </thead>
              <tbody>
               <tr>
                      <td class="text-center" colspan="4">No records found.</td>
                  </tr>
              </tbody>
              </table>
              </div>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Public Records</h5>
            <span class="card-text d-block">
                Public records include bankruptcy filings, court records, tax liens and monetary judgments. They remain for 7–10 years.
            </span>
            <div class="table-responsive">
             <table class="table table-bordered shadow-sm mt-3">
              <thead class="thead-light">
                <tr>
                <th></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                      <td class="text-center" colspan="4">No records found.</td>
                  </tr>
                  
              </tbody>
              </table>
              </div>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Account History</h5>
            <span class="card-text d-block">
                Accounts "paid as agreed" can remain on a report for 10 years from last activity. Negatives should be removed after 7 years or 10 years for bankruptcies.
            </span>
            <?php 
$accountsByName = [];
$comments = 'N/A';

foreach ($reportData->providerViews as $providerIndex => $view) {
    foreach ($view->revolvingAccounts as $data) {
       
            $name = $data->contactInformation->contactName ?? 'Unknown';
            $accountNumber = $data->accountNumber ?? 'N/A';
            $accountType = $data->accountType ?? 'N/A';
            $accountStatus = $data->accountStatus ?? 'N/A';
            $dateOpened = date('Y-m-d', (int) ($data->dateOpened / 1000));
            $balanceAmount = $data->balanceAmount->amount ?? '0';
            $highCreditAmount = $data->highCreditAmount->amount ?? '0';
            $creditLimitAmount = $data->creditLimitAmount->amount ?? '0';
            $monthlyPayment = $data->creditLimitAmount->monthlyPayment ?? '0';
            $pastDueAmount = $data->pastDueAmount->amount ?? '0';
            $lastActivityDate = date('Y-m-d', (int) ($data->lastActivityDate / 1000));
            $lastPaymentDate = date('Y-m-d', (int) ($data->lastPaymentDate / 1000));
            $monthsReviewed = $data->monthsReviewed;
                    $isNegative = $data->isNegative ?? true;
           if (!empty($data->comments) && is_array($data->comments) && isset($data->comments[0]->description)) {
    $comments = $data->comments[0]->description;
}


        // Store both accountNumber and isNegative per provider
            $accountsByName[$name][$providerIndex] = [
            'accountNumber' => $accountNumber,
            'accountType' => $accountType,
            'accountStatus' => $accountStatus,
            'dateOpened' => $dateOpened,
            'balanceAmount' => $balanceAmount,
            'highCreditAmount' => $highCreditAmount,
            'creditLimitAmount' => $creditLimitAmount,
            'monthlyPayment' => $monthlyPayment,
            'pastDueAmount' => $pastDueAmount,
            'lastActivityDate' => $lastActivityDate,
            'lastPaymentDate' => $lastPaymentDate,
            'monthsReviewed' => $monthsReviewed,
            'comments'=> $comments,
            'isNegative' => $isNegative,
            
            
            ];
    }
}
?>
<?php foreach ($accountsByName as $name => $accounts): 
?>
<div class="table-responsive">
          <table class="table table-bordered shadow-sm mt-3">
              <thead class="thead-light">
                <tr>
                <th></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                  <th><img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 25px !important; width: auto !important;"></th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                      <td colspan="4" class="text-center"><?= $name; ?></td>
                  </tr>
                  <tr>
                      <td>Account #:</td>
                       <td><?= $accounts[0]['accountNumber'] ?? ''; ?></td>
                <td><?= $accounts[1]['accountNumber'] ?? ''; ?></td>
                <td><?= $accounts[2]['accountNumber'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Account Type:</td>
                       <td><?= $accounts[0]['accountType'] ?? ''; ?></td>
                <td><?= $accounts[1]['accountType'] ?? ''; ?></td>
                <td><?= $accounts[2]['accountType'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Account Type - Detail:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td>Bureau Code:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td>Account Status:</td>
                        <td><?= $accounts[0]['accountStatus'] ?? ''; ?></td>
                <td><?= $accounts[1]['accountStatus'] ?? ''; ?></td>
                <td><?= $accounts[2]['accountStatus'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Monthly Payment:</td>
                         <td>$<?= $accounts[0]['monthlyPayment'] ?? '0'; ?></td>
                <td>$<?= $accounts[1]['monthlyPayment'] ?? '0'; ?></td>
                <td>$<?= $accounts[2]['monthlyPayment'] ?? '0'; ?></td>
                  </tr>
                  <tr>
                      <td>Date Opened:</td>
                         <td><?= $accounts[0]['dateOpened'] ?? ''; ?></td>
                <td><?= $accounts[1]['dateOpened'] ?? ''; ?></td>
                <td><?= $accounts[2]['dateOpened'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Balance:</td>
                         <td>$<?= $accounts[0]['balanceAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[1]['balanceAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[2]['balanceAmount'] ?? '0'; ?></td>
                  </tr>
                  <tr>
                      <td>No. of Months (terms):</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td>High Credit:</td>
                         <td>$<?= $accounts[0]['highCreditAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[1]['highCreditAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[2]['highCreditAmount'] ?? '0'; ?></td>
                  </tr>
                  <tr>
                      <td>Credit Limit:</td>
                           <td>$<?= $accounts[0]['creditLimitAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[1]['creditLimitAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[2]['creditLimitAmount'] ?? '0'; ?></td>
                  </tr>
                  <tr>
                      <td>Past Due:</td>
                          <td>$<?= $accounts[0]['pastDueAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[1]['pastDueAmount'] ?? '0'; ?></td>
                <td>$<?= $accounts[2]['pastDueAmount'] ?? '0'; ?></td>
                  </tr>
                  <tr>
                      <td>Date Last Active:</td>
                         <td><?= $accounts[0]['lastActivityDate'] ?? ''; ?></td>
                <td><?= $accounts[1]['lastActivityDate'] ?? ''; ?></td>
                <td><?= $accounts[2]['lastActivityDate'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Comments:</td>
                            <td><?= $accounts[0]['comments'] ?? ''; ?></td>
                <td><?= $accounts[1]['comments'] ?? ''; ?></td>
                <td><?= $accounts[2]['comments'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Date of Last Payment:</td>
                        <td><?= $accounts[0]['lastPaymentDate'] ?? ''; ?></td>
                <td><?= $accounts[1]['lastPaymentDate'] ?? ''; ?></td>
                <td><?= $accounts[2]['lastPaymentDate'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Months Reviewed:</td>
                       <td><?= $accounts[0]['monthsReviewed'] ?? ''; ?></td>
                <td><?= $accounts[1]['monthsReviewed'] ?? ''; ?></td>
                <td><?= $accounts[2]['monthsReviewed'] ?? ''; ?></td>
                  </tr>
                  <tr>
                      <td>Term Source Type:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td>Payment Status:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td>Late Payment Status:</td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>
                        <select class="form-control">
                            <option value="Positive" <?= ($isNegative === false) ? 'selected' : ''; ?>>Positive</option>
                            <option value="Negative" <?= ($isNegative === true) ? 'selected' : ''; ?>>Negative</option>
                              <option value="Repaired">Repaired</option>
                                <option value="Deleted">Deleted</option>
                                <option value="In Dispute">In Dispute</option>
                                <option value="Verified">Verified</option>
                                <option value="Updated">Updated</option>
                                <option value="Unspecified">Unspecified</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control">
                            <option value="Positive" <?= ($isNegative === false) ? 'selected' : ''; ?>>Positive</option>
                            <option value="Negative" <?= ($isNegative === true) ? 'selected' : ''; ?>>Negative</option>
                            <option value="Repaired">Repaired</option>
                                <option value="Deleted">Deleted</option>
                                <option value="In Dispute">In Dispute</option>
                                <option value="Verified">Verified</option>
                                <option value="Updated">Updated</option>
                                <option value="Unspecified">Unspecified</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control">
                            <option value="Positive" <?= ($isNegative === false) ? 'selected' : ''; ?>>Positive</option>
                            <option value="Negative" <?= ($isNegative === true) ? 'selected' : ''; ?>>Negative</option>
                               <option value="Repaired">Repaired</option>
                                <option value="Deleted">Deleted</option>
                                <option value="In Dispute">In Dispute</option>
                                <option value="Verified">Verified</option>
                                <option value="Updated">Updated</option>
                                <option value="Unspecified">Unspecified</option>
                        </select>
                    </td>
                </tr>
                <?php //if ($isNegative === true): ?>
                <tr>
                    <td>Status per system</td>
                    <td class="text-danger"><strong><?= ($isNegative === false) ? 'Positive' : 'Negative'; ?></strong></td>
                    <td class="text-danger"><strong><?= ($isNegative === false) ? 'Positive' : 'Negative'; ?></strong></td>
                    <td class="text-danger"><strong><?= ($isNegative === false) ? 'Positive' : 'Negative'; ?></strong></td>
                </tr>
                  <tr>
                      <td>Add Reason</td>
                      <td colspan="3">
                        <select class="form-control" id="reason">
                        <option value="The following personal information is incorrect">The following personal information is incorrect</option>
                        <option value="The following account is not mine">The following account is not mine</option>
                        <option value="The status is incorrect for the following account">The status is incorrect for the following account</option>
                        <option value="The status is incorrect for the following account">The status is incorrect for the following account</option>
                        <option value="The following information is outdated. I would like it removed from my credit history report">The following information is outdated. I would like it removed from my credit history report</option>
                        <option value="The following inquiry is more than two years old and I would like it removed">The following inquiry is more than two years old and I would like it removed</option>
                        <option value="The inquiry was not authorized">The inquiry was not authorized</option>
                        <option value="The following accounts were closed by me and should state that">The following accounts were closed by me and should state that</option>
                        <option value="The following account was a Bankruptcy/Charge-off. Balance should be $0">The following account was a Bankruptcy/Charge-off. Balance should be $0</option>
                        <option value="Mistaken Identity">Mistaken Identity</option>
                        <option value="Identity Theft">Identity Theft</option>
                     <option value="Sample Reason">Sample Reason</option>
                        <option value="Other information I would like changed">Other information I would like changed</option>
                        <option value="This is a duplicate account">This is a duplicate account</option>
                        <option value="The wrong amount is being reported">The wrong amount is being reported</option>
                        <option value="This is the wrong creditor for this item">This is the wrong creditor for this item</option>
                        <option value="Validate Account">Validate Account</option>
                        <option value="-">-</option>
                        <option value="Late Payments">Late Payments</option>
                        <option value="Charged Off">Charged Off</option>
                        <option value="Account Closed">Account Closed</option>
                        <option value="15 USC 1666 USC 1666B 12 CFR 1026.13 - Billing Error - Late Payments">15 USC 1666 USC 1666B 12 CFR 1026.13 - Billing Error - Late Payments</option>
                        </select>
                      </td>
                  </tr>
                   <tr>
                      <td>Add Instruction</td>
                      <td colspan="3">
                          <select class="form-control" id="instruction">
                             <option value="Please correct/update this inaccurate information on my credit report.">Please correct/update this inaccurate information on my credit report.</option>
                            <option value="Please remove this inaccurate information from my credit report." >Please remove this inaccurate information from my credit report.</option>
                            <option value="Please remove it from my credit report." >Please remove it from my credit report.</option>
                            <option value="This is not mine. I am a victim of ID Theft and I have included a police report. Please investigate and remove from my credit report.">This is not mine. I am a victim of ID Theft and I have included a police report. Please investigate and remove from my credit report.</option>
                            <option value="Please supply information on how you have verified this item.">Please supply information on how you have verified this item.</option>
                            <option value="This is not mine.">This is not mine.</option>
                            <option value="My parent has the same name as me." >My parent has the same name as me.</option>
                            <option value="Please investigate and delete from my credit report." >Please investigate and delete from my credit report.</option>
                            <option value="Please ensure that all information is accurate" >Please ensure that all information is accurate</option>
                            <option value="Please verify that the information is correct">Please verify that the information is correct</option>
                            <option value="Pursuant to 15 USC § 1681s-2 (a) Duty of Furnishers of Information to Provide Accurate information (1) Prohibition (A) Reporting information with actual knowledge of errors A person shall not furnish any information relating to a consumer to any consumer reporting agency if the person knows or has reasonable cause to believe that the information is inaccurate. " >Pursuant to 15 USC § 1681s-2 (a) Duty of Furnishers of Information to Provide Accurate information (1) Prohibition (A) Reporting information with actual knowledge of errors A person shall not furnish any information relating to a consumer to any consumer reporting agency if the person knows or has reasonable cause to believe that the information is inaccurate. </option>
                          </select>
                      </td>
                  </tr>
                  <?php //endif; ?>
                  </tbody>
                  </table>
                  </div>
<?php endforeach; ?>

         

                 <div class="form-group row mt-3" style="padding: 0 20px;justify-content: center;">
               <a type="button"class="btn btn-success btn-icon-text mr-2" id="submitwizard">Save my work and continue to the Wizard</a>
              <a type="button" class="btn btn-outline-success btn-icon-text" id="submitdisputeItem">Save my work and show all Dispute Items</a>
            </div>
        </div>
    </div>

    <div class="alert alert-warning mt-4">
        <strong>Finished?</strong> All <em>"Negative"</em> items that you've tagged with "Reason and Instruction" will be saved as "Dispute Items" to be merged into letters in the Wizard. Click either button below to save and continue.
    </div>
</div>


	</div>
</div>
<div class="modal fade" id="RecordModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Re-Import Summary: Results Since Your Last Import</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
             <div class="modal-header">
        <h2>Your Credit Scores</h2>
        <span class="report-date"><?= $reportdate ?? '-'; ?></span>
    </div>
          <div class="row mt-3">
              <div class="col-4">
                  <div class="score">
                      <img src="<?= base_url('downloads/simple_audit_images/equifax.png'); ?>" style="height: 50px !important; width: auto !important;">
                    <h1><b><?= $creditScore[0]; ?></b></h1>  
                      <?php
                      if ($creditScore[0] >= 300 && $creditScore[0] <= 579) {
                            $scoreCategory = "Poor";
                        } elseif ($creditScore[0] >= 580 && $creditScore[0] <= 669) {
                            $scoreCategory = "Fair";
                        } elseif ($creditScore[0] >= 670 && $creditScore[0] <= 739) {
                            $scoreCategory = "Good";
                        } elseif ($creditScore[0] >= 740 && $creditScore[0] <= 799) {
                            $scoreCategory = "Very Good";
                        } elseif ($creditScore[0] >= 800 && $creditScore[0] <= 850) {
                            $scoreCategory = "Excellent";
                        } else {
                            $scoreCategory = "Invalid Score";
                        }
                        ?>
                        <h3><?= $scoreCategory;?></h3>
                  </div>
              </div>
               <div class="col-4">
                  <div class="score">
                      <img src="<?= base_url('downloads/simple_audit_images/experian.png'); ?>" style="height: 50px !important; width: auto !important;">
                     <h1><b><?= $creditScore[1]; ?></b></h1> 
         
                      <?php
                      if ($creditScore[1] >= 300 && $creditScore[1] <= 579) {
                            $scoreCategory = "Poor";
                        } elseif ($creditScore[1] >= 580 && $creditScore[1] <= 669) {
                            $scoreCategory = "Fair";
                        } elseif ($creditScore[1] >= 670 && $creditScore[1] <= 739) {
                            $scoreCategory = "Good";
                        } elseif ($creditScore[1] >= 740 && $creditScore[1] <= 799) {
                            $scoreCategory = "Very Good";
                        } elseif ($creditScore[1] >= 800 && $creditScore[1] <= 850) {
                            $scoreCategory = "Excellent";
                        } else {
                            $scoreCategory = "Invalid Score";
                        }
                        ?>
                        <h3><?= $scoreCategory;?></h3>
                  </div>
              </div>
               <div class="col-4">
                  <div class="score">
                      <img src="<?= base_url('downloads/simple_audit_images/trans_union.png'); ?>" style="height: 50px !important; width: auto !important;">
                     <h1><b><?= $creditScore[2]; ?></b></h1>  
                      <?php
                      if ($creditScore[2] >= 300 && $creditScore[2] <= 579) {
                            $scoreCategory = "Poor";
                        } elseif ($creditScore[2] >= 580 && $creditScore[2] <= 669) {
                            $scoreCategory = "Fair";
                        } elseif ($creditScore[2] >= 670 && $creditScore[2] <= 739) {
                            $scoreCategory = "Good";
                        } elseif ($creditScore[2] >= 740 && $creditScore[2] <= 799) {
                            $scoreCategory = "Very Good";
                        } elseif ($creditScore[2] >= 800 && $creditScore[2] <= 850) {
                            $scoreCategory = "Excellent";
                        } else {
                            $scoreCategory = "Invalid Score";
                        }
                        ?>
                        <h3><?= $scoreCategory;?></h3>
                  </div>
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>-->
          <button type="button" class="btn btn-success" id="modalclose">Continue to Credit Report Preview Page</button>
        </div>
      </div>
    </div>
  </div>
<!--<div class="modal fade" id="PendingModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog modal-md">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="modalLabel">Pending report confirmation</h5>-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">&times;</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--This credit report has been saved as "Pending". The items on this report will not populate to the software until you finish tagging the negative/dispute items and save your work. A link to this pending report is in the client's dashboard.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    $('#RecordModal').modal('show');
 
  });
     $('#modalclose').click(function () {
         $('#RecordModal').modal('hide');
    });
    
$('#Pendingreportdelete').click(function () {
    if (!confirm('Are you sure you want to delete this pending report ?')) {
        return; // Stop execution if user cancels
    }

    $('#loader').show();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url("delete_pending_report/" . $client[0]->sq_client_id); ?>',
        success: function(response) {
            setTimeout(function () {
                $('#loader').hide();
                window.location.href = '<?php echo base_url("simple_audit/$client_id"); ?>';
            }, 500);
        },
        error: function(xhr, status, error) {
            alert('Error: ' + error);
        }
    });
});

 $('#PendingLetter').click(function () {
    $('#loader').show(); // make sure class or ID is correct

    setTimeout(function () {
        $('#loader').hide();

        // First show RecordModal
       Swal.fire({
    icon: '',
    title: 'Pending report confirmation',
    text: 'This credit report has been saved as "Pending". The items on this report will not populate to the software until you finish tagging the negative/dispute items and save your work. A link to this pending report is in the client\'s dashboard.',
    showConfirmButton: true
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'POST',
        url: '<?php echo base_url("save_pending_report/" . $client[0]->sq_client_id); ?>',
        success: function(response) {
            $('#RecordModal').modal('show');
             $('#Pendingreportdelete').show();
             $('#simpleAudit').hide();
        },
        error: function(xhr, status, error) {
            alert('Error: ' + error);
        }
    });

    }
});

    }, 3000);
});

$(document).ready(function() {
    $('#submitwizard').click(function() {
        // Collect the values of selected checkboxes for each category
        var selectedPfullAddress = [];
        var selectedFullAddress = [];
        var selectedNames = [];
        var selectedDob = [];
var reason = $('#reason').val()
var instruction = $('#instruction').val()
        // Pfull Address
        if ($('#pfullAddress1').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress1').val());
        }
        if ($('#pfullAddress2').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress2').val());
        }
        if ($('#pfullAddress3').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress3').val());
        }

        // Full Address
        if ($('#fullAddress1').is(':checked')) {
            selectedFullAddress.push($('#fullAddress1').val());
        }
        if ($('#fullAddress2').is(':checked')) {
            selectedFullAddress.push($('#fullAddress2').val());
        }
        if ($('#fullAddress3').is(':checked')) {
            selectedFullAddress.push($('#fullAddress3').val());
        }

        // Names
        if ($('#name1').is(':checked')) {
            selectedNames.push($('#name1').val());
        }
        if ($('#name2').is(':checked')) {
            selectedNames.push($('#name2').val());
        }
        if ($('#name3').is(':checked')) {
            selectedNames.push($('#name3').val());
        }

        // Date of Birth
        if ($('#dob1').is(':checked')) {
            selectedDob.push($('#dob1').val());
        }
        if ($('#dob2').is(':checked')) {
            selectedDob.push($('#dob2').val());
        }
        if ($('#dob3').is(':checked')) {
            selectedDob.push($('#dob3').val());
        }
        var selectedData = {
            pfullAddress: selectedPfullAddress,
            fullAddress: selectedFullAddress,
            names: selectedNames,
            dob: selectedDob,
             reason: reason,
              instruction: instruction,
            client_id:'<?= $client[0]->sq_client_id ?>'
        };
        console.log(selectedData);

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("previewreport_data_save"); ?>', 
            data: selectedData,
              beforeSend: function() {
        $('#loader').show(); 
    },
                success: function(response) {
        setTimeout(function () {
            $('#loader').hide();
            window.location.href = '<?php echo base_url("generate-letters/$client_id"); ?>';
        }, 500);
    },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
      $('#submitdisputeItem').click(function() {
        // Collect the values of selected checkboxes for each category
        var selectedPfullAddress = [];
        var selectedFullAddress = [];
        var selectedNames = [];
        var selectedDob = [];

        // Pfull Address
        if ($('#pfullAddress1').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress1').val());
        }
        if ($('#pfullAddress2').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress2').val());
        }
        if ($('#pfullAddress3').is(':checked')) {
            selectedPfullAddress.push($('#pfullAddress3').val());
        }

        // Full Address
        if ($('#fullAddress1').is(':checked')) {
            selectedFullAddress.push($('#fullAddress1').val());
        }
        if ($('#fullAddress2').is(':checked')) {
            selectedFullAddress.push($('#fullAddress2').val());
        }
        if ($('#fullAddress3').is(':checked')) {
            selectedFullAddress.push($('#fullAddress3').val());
        }

        // Names
        if ($('#name1').is(':checked')) {
            selectedNames.push($('#name1').val());
        }
        if ($('#name2').is(':checked')) {
            selectedNames.push($('#name2').val());
        }
        if ($('#name3').is(':checked')) {
            selectedNames.push($('#name3').val());
        }

        // Date of Birth
        if ($('#dob1').is(':checked')) {
            selectedDob.push($('#dob1').val());
        }
        if ($('#dob2').is(':checked')) {
            selectedDob.push($('#dob2').val());
        }
        if ($('#dob3').is(':checked')) {
            selectedDob.push($('#dob3').val());
        }
        var selectedData = {
            pfullAddress: selectedPfullAddress,
            fullAddress: selectedFullAddress,
            names: selectedNames,
            dob: selectedDob,
            client_id:'<?= $client[0]->sq_client_id ?>'
        };
        console.log(selectedData);

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("previewreport_data_save"); ?>', 
            data: selectedData,
              beforeSend: function() {
        $('#loader').show(); 
    },
                success: function(response) {
        setTimeout(function () {
            $('#loader').hide();
            window.location.href = '<?php echo base_url("dispute_items/$client_id"); ?>';
        }, 500);
    },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});

</script>