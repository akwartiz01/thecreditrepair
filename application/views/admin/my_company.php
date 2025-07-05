<?php $time_zone = $this->config->item('time_zone');
?>

<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

<!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>-->

<script>
    tinymce.init({
        selector: '#audit_textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        resize: 'both',
    });
     tinymce.init({
        selector: '#audit_textareas',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        resize: 'both',
    });  
</script>

<style>
    .mce-notification {
        display: none;
    }
.aduit_submit{
    display:block!important;
}
    .form_error {
        color: red;
        font-weight: bold;
    }

    legend {
        padding: 5px 20px;
        font-size: 20px;
        font-weight: bold;
    }

    .placeholder_section .col-md-6 {
        font-size: 13px;
        line-height: 20px;
    }

    .simple_audit_modal {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    .tox.tox-tinymce {
        width: 100% !important;
        height: 600px !important;
    }

    .placeholder_section .col-md-6 {
        font-size: 13px;
        line-height: 20px;
    }

    /* Loader CSS s*/
    #loader {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Loader CSS e*/

    .audit_icons {
        color: rgb(0, 117, 204) !important;
    }

    .audit_disabled_icons {
        color: rgb(196, 196, 196) !important;
    }

    .nav-tabs .nav-link {
        background: #fff !important;

    }

    .nav-tabs.nav-tabs-vertical .nav-link.active,
    .nav-tabs.nav-tabs-vertical-custom .nav-link.active {
        background: #3972fc !important;
    }

    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item.show .nav-link {
        color: #fff !important;
    }

    .nav-tabs .nav-link.active.mdi-account-outline {
        color: #3972fc !important;
    }

    .btns-outline-success {
        /* background-color: #198754 !important; */
        color: #198754 !important;
        border-color: #198754 !important;

    }

    .btns-outline-success:hover {
        background-color: #fff !important;
        opacity: 0.8 !important;
    }

    /* css 02-May-25 start */
    @media screen and (max-width: 767px) {
        .col-12.col-md-4 {
            margin-bottom: 20px;
        }
        .col-12.col-md-6 h3 {
            font-size: 24px;
        }
        button#add_audit {
            line-height: 15px;
        }
        input#audit_defualt {
            position: unset;
        }
    }
    /* css 02-May-25 end */
</style>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
  <div class="page-header mb-4">
          <h1> My Company </h1>
          </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <!--<h4 style="padding-bottom: 17px;"></h4>-->
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <ul class="nav nav-tabs nav-tabs-vertical" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home-2"
                                                role="tab" aria-controls="home" aria-selected="true"> My Company
                                                Profile<i class="mdi mdi-home-outline ml-2"></i>
                                            </a>
                                        </li>
                                        <?php if ($this->session->userdata('user_type') == 'super'  || $this->session->userdata('user_type') == 'subscriber') { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-2"
                                                    role="tab" aria-controls="profile" aria-selected="false"> My Team
                                                    Members (Users) <i class="mdi mdi-account-outline ml-2"></i>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact-2"
                                                    role="tab" aria-controls="contact" aria-selected="false"> Roles &
                                                    Permissions <i class="mdi mdi-email-outline ml-2"></i>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="simple_audit_tab" data-toggle="tab" href="#simple_audit_section" role="tab" aria-controls="contact" aria-selected="false"> Simple Audit Settings <i class="mdi mdi-file-document ml-2"></i>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="portal_preview_tab" data-toggle="tab" href="#portal_preview" role="tab" aria-controls="contact" aria-selected="false"> Client Portal <i class="mdi mdi-clipboard-account ml-2"></i>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="tab-content tab-content-vertical">
                                        <div class="tab-pane fade show active" id="home-2" role="tabpanel"
                                            aria-labelledby="home-tab">
                                            <?php if ($this->session->flashdata('insertion-success')) { ?>

                                                <div id="pDsuccess" class="swal-overlay swal-overlay--show-modal" tabindex="-1">
                                                    <div id="pDMsuccess" class="swal-modal" role="dialog" aria-modal="true">
                                                        <div class="swal-icon swal-icon--success"><span class="swal-icon--success__line swal-icon--success__line--long"></span><span class="swal-icon--success__line swal-icon--success__line--tip"></span>
                                                            <div class="swal-icon--success__ring"></div>
                                                            <div class="swal-icon--success__hide-corners"></div>
                                                        </div>
                                                        <div class="swal-title" style="">Company Updated!</div>
                                                        <div class="swal-text" style=""><?php echo $this->session->flashdata('insertion-success'); ?></div>
                                                        <div class="swal-footer">
                                                            <div class="swal-button-container"><button class="swal-button swal-button--confirm btn btn-primary" onclick="closeSuccessModal();">Continue</button>
                                                                <div class="swal-button__loader">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <?php } ?>
                                            <form class="form-sample" action="<?php echo base_url() ?>my-company" method="POST">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Company
                                                                name<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo isset($resultMyComp[0]->sq_company_name) ? $resultMyComp[0]->sq_company_name : ''; ?>">
                                                                <?php echo form_error('company_name'); ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Website URL</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="website_url" name="website_url" value="<?php echo isset($resultMyComp[0]->sq_company_url) ? $resultMyComp[0]->sq_company_url : ''; ?>">
                                                                <?php //echo form_error('website_url'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Address<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="address" name="address"> <?php echo isset($resultMyComp[0]->sq_company_address) ? $resultMyComp[0]->sq_company_address : ''; ?></textarea>
                                                                <?php echo form_error('address'); ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">City<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($resultMyComp[0]->sq_company_city) ? $resultMyComp[0]->sq_company_city : ''; ?>">
                                                                <?php echo form_error('city'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">State<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="state" name="state" value="<?php echo isset($resultMyComp[0]->sq_company_state) ? $resultMyComp[0]->sq_company_state : ''; ?>">
                                                                <?php echo form_error('state'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Zip<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control zip" id="zip" name="zip" value="<?php echo isset($resultMyComp[0]->sq_company_zip) ? $resultMyComp[0]->sq_company_zip : ''; ?>">
                                                                <?php echo form_error('zip'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Country</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="country" name="country" value="United States" readonly>
                                                                <?php //echo form_error('country'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Time Zone</label>
                                                            <div class="col-sm-12">
                                                                <!--      <input type="text" class="form-control" id="time_zone" name="time_zone" value=""> -->
                                                                <select id="time_zone" name="time_zone" class="form-control">
                        
                                                                        <?php foreach ($time_zone as $key => $timeZone) {
                                                                            if ($resultMyComp[0]->sq_company_time_zone == $key) {
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                        ?>
                                                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $timeZone; ?></option>
                                                                        <?php } ?>
                                                                    
                                                                </select>
                                                                <?php //echo form_error('time_zone'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Phone<span class="text-danger">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control phone" id="phone" name="phone" value="<?php echo isset($resultMyComp[0]->sq_company_contact_no) ? $resultMyComp[0]->sq_company_contact_no : ''; ?>" maxlength="14" minlength="14" onkeypress="return isNumber(event,this);">
                                                                <?php echo form_error('phone'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Fax</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control fax" id="fax" name="fax" value="<?php echo isset($resultMyComp[0]->sq_company_fax) ? $resultMyComp[0]->sq_company_fax : ''; ?>" maxlength="14" minlength="14" onkeypress="return isNumber(event,this);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p>By default, automated notifications are sent from the account
                                                    holder's name and email address. Or you may designate a different
                                                    name (or a company name) and email for all automated notifications
                                                    sent.</p>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Sender Name</label>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" id="sender_name" name="sender_name" value="<?php echo isset($resultMyComp[0]->sq_company_sender_name) ? $resultMyComp[0]->sq_company_sender_name : ''; ?>">
                                                                <?php //echo form_error('sender_name'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Sender Email</label>
                                                            <div class="col-sm-12">
                                                                <input type="email" class="form-control" id="sender_email" name="sender_email" value="<?php echo isset($resultMyComp[0]->sq_company_sender_email) ? $resultMyComp[0]->sq_company_sender_email : ''; ?>">
                                                                <?php //echo form_error('sender_email'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-6 col-form-label">Name/company that
                                                                your client invoices should be payable to </label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="payable_company" name="payable_company" value="<?php echo isset($resultMyComp[0]->sq_company_payable_company) ? $resultMyComp[0]->sq_company_payable_company : ''; ?>">
                                                                <?php //echo form_error('payable_company'); ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <?php if (check_permisions("company", "edit") == 1 || check_permisions("company", "add") == 1) { ?>
                                                    <button type="submit"
                                                        class="btn btn-gradient-primary btn-icon-text add-new" name="addCompanyButton" id="addCompanyButton" onclick="return validate_company();">
                                                        <i class="mdi mdi-account btn-icon-prepend "></i> Submit </button>
                                                <?php } ?>


                                            </form>
                                        </div>
                                        <?php if ($this->session->userdata('user_type') == 'super' || $this->session->userdata('user_type') == 'subscriber') { ?>
                                            <div class="tab-pane fade" id="profile-2" role="tabpanel"
                                                aria-labelledby="profile-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">

                                                        <h3>My Team</h3>
                                                    </div>
                                                    <div class="col-12 col-md-6" style="text-align: right; margin-bottom: 0px;">

                                                        <button type="button"
                                                            class="btn btn-gradient-primary btn-icon-text add-new" onclick="return add_new_team_members();">
                                                            <i class="mdi mdi-account btn-icon-prepend "></i> Add New Team Member
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <?php if (isset($resultMyEmp) && is_array($resultMyEmp)) {
                                                            foreach ($resultMyEmp as $row) {

                                                                $empId = $row->sq_u_id;
                                                                $encode = base64_encode(urlencode($empId * 12345678) / 12345);
                                                                if (!empty($row->sq_u_profile_picture)) {
                                                                    $image = $row->sq_u_profile_picture;
                                                                } else {
                                                                    $image = base_url('assets/img/user.jpg');
                                                                }
                                                        ?>


                                                           <div class="col-lg-3 position-relative">
    <a style="text-decoration:none;color: #000;" href="<?php echo base_url(); ?>edit-employee/<?php echo $encode; ?>">
        <div class="border-bottom text-center pb-4 position-relative mb-4">
            <img src="<?php echo $image; ?>" alt="profile" class="img-lg rounded-circle mb-3">
            <p><?php echo $row->sq_u_first_name . ' ' . $row->sq_u_last_name; ?>
                <?php if (isset($row->sq_u_role) && !empty($row->sq_u_role)) { ?>
                    <br><span style="text-transform: capitalize;">(<?php echo $row->sq_u_status; ?>)</span>
                <?php } ?>
            </p>
        </div>
    </a>

    <!-- Delete Icon -->
    <button onclick="deleteEmployee('<?php echo $row->sq_u_id; ?>')" 
            class="btn btn-sm btn-danger position-absolute" 
            style="top: 5px;right: 35px;border-radius: 50%;font-size: 7px;padding: 10px;">
        <i class="fa fa-trash" style="font-size: 10px"></i>
    </button>
</div>



                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="contact-2" role="tabpanel"
                                                aria-labelledby="contact-tab">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h3>Roles</h3>
                                                    </div>

                                                </div>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" name="addrole" id="addrole" value="" style="margin-bottom: 10px;" placeholder="Add role">
                                                            <?php echo form_error('addrole'); ?>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="submit" class="btn btn-gradient-primary btn-icon-text add-new" name="addRoleBtn" id="addRoleBtn" value="Add">
                                                        </div>

                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="col-12 comppany table-responsive">
                                                        <table id="order-listing" class="table jsgrid">
                                                            <thead>
                                                                <tr>
                                                                    <th> Role Name</th>
                                                                    <th> </th>
                                                                    <th> </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (isset($resultMyRole) && is_array($resultMyRole)) {
                                                               foreach ($resultMyRole as $row) {
                                                                if (strtolower(trim($row->sq_role_name)) === 'team') continue; // Skip Team role
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $row->sq_role_name; ?></td>
                                                                    <td>
                                                                        <a href="<?php echo base_url(); ?>permissions/<?php echo strtolower(trim($row->sq_role_name)); ?>">
                                                                            View Permissions
                                                                        </a>
                                                                    </td>
                                                                    <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                                                                        <i class="mdi mdi-lock menu-icon"></i>
                                                                    </td>
                                                                </tr>
                                                            <?php } 

                                                                } ?>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <?php  //} 
                                                    ?> -->

                                            <div class="tab-pane fade" id="simple_audit_section" role="tabpanel"
                                                aria-labelledby="contact-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <h3>Simple Audit Settings</h3>
                                                    </div>

                                                    <div class="col-12 col-md-6 text-right" style="padding-bottom: 20px !important;">
                                                        <button type="button" class="btn btn-sucess bg-success" style="color: white !important;" id="add_audit"><i class="mdi mdi-plus"></i> Add New Simple Audit Template</button>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-12 comppany">
                                                        <div class="table-responsive">
                                                        <table id="order-listing" class="table jsgrid">
                                                            <thead>
                                                                <tr>
                                                                    <th>Audit Template Name</th>
                                                                    <th>Set As Default</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (isset($simple_audits) && is_array($simple_audits)) {
                                                                    foreach ($simple_audits as $audit_row) {  ?>
                                                                        <tr>
                                                                            <td><?php echo $audit_row->audit_name; ?></td>
                                                                            <td>
                                                                                <?php if ($audit_row->default_audit == "1") { ?>

                                                                                    <input class="form-check-input" type="radio" name="audit_defualt" id="audit_defualt" style="margin-left: 0px !important;" checked><label class="form-check-label" style="margin-top:3px !important; margin-left:20px !important;">Default</label>
                                                                                <?php } else { ?>
                                                                                    <input class="form-check-input" type="radio" name="audit_defualt" id="audit_defualt" style="margin-left: 0px !important;"><label class="form-check-label" style="margin-top:3px !important; margin-left:20px !important;"></label>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center">
                                                                                <?php if ($audit_row->system_default == "1") { ?>

                                                                                    <a title="Locked"><i class="mdi mdi-lock menu-icon audit_disabled_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;

                                                                                    <!--<a title="Preview"><i class="mdi mdi-eye-circle menu-icon audit_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;-->
                                                                             <a title="Preview" 
                                                                                    data-id="<?php echo htmlspecialchars($audit_row->id); ?>"
                                                                                        data-name="<?php echo htmlspecialchars($audit_row->audit_name); ?>"
                                                                                        data-text="<?php echo htmlspecialchars($audit_row->audit_textarea); ?>"
                                                                                        onclick="viewAuditTemplate(this)"
                                                                                        ><i class="mdi mdi-eye-circle menu-icon audit_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;

                                                                                    <a title="Edit Template"
                                                                                        data-id="<?php echo htmlspecialchars($audit_row->id); ?>"
                                                                                        data-name="<?php echo htmlspecialchars($audit_row->audit_name); ?>"
                                                                                         data-default_audit="<?php echo htmlspecialchars($audit_row->default_audit); ?>"
                                                                                          data-include_page_number="<?php echo htmlspecialchars($audit_row->include_page_number); ?>"
                                                                                        data-text="<?php echo htmlspecialchars($audit_row->audit_textarea); ?>"
                                                                                        onclick="editAuditTemplate(this)">


                                                                                        <i class="mdi mdi-pencil menu-icon audit_icons" style='cursor:pointer;'></i>
                                                                                    </a>&nbsp;&nbsp;


                                                                                <?php } else { ?>
                                                                                    <!--<a title="Preview"><i class="mdi mdi-eye-circle menu-icon audit_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;-->
                                       <a title="Preview" data-id="<?php echo htmlspecialchars($audit_row->id); ?>"
                                                                                        data-name="<?php echo htmlspecialchars($audit_row->audit_name); ?>"
                                                                                        data-text="<?php echo htmlspecialchars($audit_row->audit_textarea); ?>"
                                                                                        onclick="viewAuditTemplate(this)"><i class="mdi mdi-eye-circle menu-icon audit_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;

                                                                                    <a title="Edit Template"
                                                                                        data-id="<?php echo htmlspecialchars($audit_row->id); ?>"
                                                                                        data-name="<?php echo htmlspecialchars($audit_row->audit_name); ?>"
                                                                                        data-text="<?php echo htmlspecialchars($audit_row->audit_textarea); ?>"
                                                                                         data-default_audit="<?php echo htmlspecialchars($audit_row->default_audit); ?>"
                                                                                          data-include_page_number="<?php echo htmlspecialchars($audit_row->include_page_number); ?>"
                                                                                        onclick="editAuditTemplate(this)">


                                                                                        <i class="mdi mdi-pencil menu-icon audit_icons" style='cursor:pointer;'></i>
                                                                                    </a>&nbsp;&nbsp;


                                                                                    <a title="Delete" onclick="delete_audit_template(<?php echo $audit_row->id; ?>)"><i class="mdi mdi-delete menu-icon audit_icons" style='cursor:pointer;'></i></a>&nbsp;&nbsp;
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan="3" style="text-align: center;">No data found!</td>
                                                                    </tr>

                                                                <?php  } ?>


                                                            </tbody>
                                                        </table>
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="portal_preview" role="tabpanel"
                                                aria-labelledby="contact-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <h3>Client Portal Options</h3>
                                                    </div>

                                                </div>

                                                <div class="row" style="margin-left:auto; margin-right:auto;">
                                                    <!-- Info Box -->
                                                    <div class="col-12 alert alert-info mt-3" role="alert" style="background-color:#fff;">
                                                        <i class="mdi mdi-message-text"></i> The client portal is the most important tool a credit specialist can have. Your client portal is private label, with your logo and your company information, to look as it custom built just for you. To modify the "Resources" and "Credit Info" pages that your clients see in your portal, click the tabs below. If you activate "Client's Choice" (optional), the client must choose which items to dispute.
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-left:auto; margin-right:auto;">
                                                    <!-- Info Box -->
                                                    <div class="col-12mt-3" style="background-color:#fff;">
                                                        <h5><strong>Portal Preview</strong></h5>
                                                        <p>Want to see how your portal looks for your clients? Click the buttons for a preview</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">

                                                        <a class="btn btns-outline-success" href="<?php echo base_url('client/dashboard'); ?>">View My Client Portal</a>
                                                        <!-- <a class="btn btns-outline-success">View My Affiliate Portal</a> -->
                                                    </div>

                                                </div>

                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">

                </div>

                <!--  <div class="col-6" style="text-align: right; margin-bottom: 24px;">

                    <button type="button" class="btn btn-gradient-primary btn-icon-text">
                        <i class="mdi mdi-account btn-icon-prepend"></i> Add New Client </button>
                </div> -->
            </div>




        </div>
        <!-- content-wrapper ends -->

        <div class="modal fade" id="view_audit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <input type="hidden" id="edit_template">
                <input type="hidden" id="template_id">
                <div class="modal-content" style="background-color:white !important;">
                    <div class="modal-header" style="border: 0">
                        <h4 class="modal-title" id="myModalLabel" style="font-weight: 400 !important;">Audit Template Preview</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                         <div class="modal-body" style="padding: 0px 0px;">
                                  <div class="form-group">
                            <div class="row simple_audit_modal">
                                <div class="col-md-12">
                                    <textarea cols="30" rows="20" name="content" id="audit_textareas"></textarea>
                                </div>

                            </div>
                        </div>
                        </div>
                         <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
                    
        <div class="modal fade" id="add_audit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <input type="hidden" id="edit_template">
                <input type="hidden" id="template_id">
                <div class="modal-content" style="background-color:white !important;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabels" style="font-weight: 400 !important;"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" style="padding: 0px 0px;">

                        <div class="form-group mt-3">

                            <div class="row simple_audit_modal">
                                <div class="col-md-3">
                                    <label>Audit Name</label>
                                    <input type="text" class="form-control" name="audit_name" id="audit_name" value="" style="background: white !important;">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check" style="margin-top: 30px !important;">
                                        <input type="checkbox" class="form-check-input" name="include_page_number" id="include_page_number" value="1" style="margin-left: unset !important;">
                                        <label class="form-check-label">Include page number</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check" style="margin-top: 30px !important;">
                                        <input type="checkbox" class="form-check-input" name="default_audit" id="default_audit" value="1" style="margin-left: unset !important;">
                                        <label class="form-check-label">Set as default</label>
                                    </div>
                                </div>

                                <div class="col-md-2" style="margin-top:20px !important;">
                                    <button type="button" class="btn btn-success" id="reseText" style="background-color: white !important; border:2px solid rgb(176, 173, 171) !important; color: rgb(102, 102, 102) !important; box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 1px -2px, rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px !important;">Reset Text</button>
                                </div>

                                <div class="col-md-3" style="margin-top:20px !important;">
                                    <button type="button" class="btn btn-success" id="view_placeholder" style="background-color: white !important; border:2px solid rgb(176, 173, 171) !important; color: rgb(102, 102, 102) !important; box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 1px -2px, rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px !important;">View Placeholders</button>
                                </div>

                            </div>
                        </div>

                        <div class="form-group" id="placeholders" style="border: 1px solid rgb(221, 219, 218) !important; margin-left:20px !important; margin-right:20px !important; padding-top:20px !important; padding-bottom:20px !important; display:none;">
                            <div class="row placeholder_section simple_audit_modal">
                                <div class="col-md-6">
                                    {company_logo} - <b>Company logo</b><br>
                                    {client_suffix} - <b>Suffix of client</b><br>
                                    {client_first_name} - <b>First name of client</b><br>
                                    {client_middle_name} - <b>Middle name of client</b><br>
                                    {client_last_name} - <b>Last name of client</b><br>
                                    {client_email} - <b>Email of client</b><br>
                                    {client_address} - <b>Address of client</b><br>
                                    {client_previous_address} - <b>Previous address of client</b><br>
                                    {bdate} - <b>Birth date of client</b><br>
                                    {ss_number} -<b> Last 4 of SSN of client</b><br>
                                    {t_no} - <b>Telephone number of client</b><br>
                                    {curr_date} - <b>Current date</b><br>
                                </div>

                                <div class="col-md-6">
                                    {bureau_name} - <b>Credit bureau name</b><br>
                                    {bureau_address} - <b>Credit bureau name and address</b><br>
                                    {account_number} - <b>Account number</b><br>
                                    {dispute_item_and_explanation} - <b>Dispute items and explanation</b><br>
                                    {creditor_name} - <b>Creditor/Furnisher name</b><br>
                                    {creditor_address} - <b>Creditor/Furnisher address</b><br>
                                    {creditor_phone} - <b>Creditor/Furnisher phone number</b><br>
                                    {creditor_city} - <b>Creditor/Furnisher city</b><br>
                                    {creditor_state} - <b>Creditor/Furnisher state</b><br>
                                    {creditor_zip} - <b>Creditor/Furnisher zip</b><br>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row simple_audit_modal">
                                <div class="col-md-12">
                                    <textarea cols="30" rows="20" name="content" id="audit_textarea"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm bg-success" id="aduit_submit" onclick="add_edit_audit_template()"></button>
                    </div>
                </div>
            </div>
        </div>

        <div id="loader">
            <img src="<?php echo base_url('assets/loading-gif.gif'); ?>" style="height: 50px;" alt="Loading..." class="loader-image">
        </div>


        <script>
 $('#reseText').on('click', function() {
    const data = `{COMPANY LOGO}
 
 
Credit Audit Report Prepared for
{CLIENT NAME}
Created: {TODAY'S DATE}

Prepared by {TEAM MEMBER NAME},  {COMPANY NAME}
{COMPANY EMAIL}
{PAGE BREAK}

Dear {CLIENT NAME},

On behalf of {COMPANY NAME}, I'd like to take this opportunity to welcome you as a new client! We are thrilled to have you with us.

Credit is our passion. We understand how important your credit is for your future and we will work tirelessly to make sure we are able to help you achieve your financial goals.

This credit analysis report provides an overview of your credit as potential lenders see it today. It lists the items that are negatively affecting your score and explains how we use the power of the law to improve your credit. It also includes a simple step-by-step plan for you to speed up the process.

This credit analysis report is broken down into 5 sections:
	Credit Score Basics
	Your Credit Scores and Summary
	Analysis of Your Accounts
	An Overview of Our Process
	Your Part in the Process
If you have any questions, do not hesitate to reach out. We are always happy to help!
You can easily reach us during regular business hours in the following ways:

Email: {COMPANY EMAIL}
Website: {COMPANY WEBSITE}
{CLIENT NAME}, thank you again for entrusting {COMPANY NAME} to restore your credit. We are honored to help you achieve your financial goals.

Best,
{TEAM MEMBER NAME}
{COMPANY NAME}

{COMPANY LOGO}
{PAGE BREAK}

What a Low Credit Score Costs you

New Toyota Camry: $23,000/66 Month Term
Jane's Credit Score
730
Interest Rate...............................1.99%
Payment........................................$368
Total Interest Paid
$1,302
Total Payments:
$24,302
 	
John's Credit Score
599
Interest Rate..............................14.99%
Payment.........................................$514
Total Interest Paid
$10,921
Total Payments:
$33,921
A low score can cost you:
$9,616 MORE
For the exact same car and price!
This same thing happens with your credit cards,
mortgage, loans, etc.
{PAGE BREAK}

What a Low Credit Score Costs you

New Home:  $250,000/30 Year Fixed Rate Mortgage
Jane's Credit Score
730
Interest Rate..............................2.75%
Payment...................................$1,021
Total Interest Paid
$117,417
Total Payments:
$367,417
 	
John's Credit Score
599
Interest Rate..............................6.5%
Payment.................................$1,580
Total Interest Paid
$318,861
Total Payments:
$568,861
A low score can cost you:
$201,444 MORE
For exact same home & price!
Cleaning up your credit will lower your bills and can save
hundreds of thousands of dollars!
{PAGE BREAK}

How Credit Bureaus Determine your Credit Score

Your Behavior Effects Your Credit Score
	
Do you pay your bills on time?
Payment history is a major factor in credit scoring. If you have paid bills late, have collections or a bankruptcy, these events won't reflect well in your credit score.
	
Do you have a long credit history?
Generally speaking, the longer your history of holding accounts, the more trusted you will be as a borrower.
	
Have you applied for credit recently?
If you have many recent inquiries this can be construed as being negative by the bureaus. Only apply for credit when you really need it.
	
What is your outstanding debt?
It is important to not use all of your available credit. If all of your credit cards are maxed out, your scores will reflect that you are not managing your debt wisely.
{PAGE BREAK}

Your Credit Scores and Summary
{REPORT PROVIDER REFERENCE}
We have analyzed your credit reports from the three major bureaus. Here are our findings:
{3 BUREAU CREDIT SCORE TABLE}
 
Maxing out your credit cards will lower your score. If you pay balances down to below 30% of your available credit limit of each card, that will increase your score.
{CREDIT UTILIZATION PERCENTAGE USED}		
Total available revolving credit:{TOTAL REVOLVING CREDIT LINES}
Current credit card balance: {REVOLVING CREDIT BALANCE}
It Is Important To Keep Your Credit Monitoring Account Active Throughout The Credit Repair Process
Credit scores vary depending on where you get them because there are dozens of credit scoring models that may calculate your score differently. Maintaining this one (1) credit monitoring account that is compatible with our software gives us a baseline with all 3 bureaus to accurately see changes as they happen.
{PAGE BREAK}

Derogatory Summary
We analyzed all the items on your reports to determine which accounts are negatively impacting your score. Here are our findings:
{DEROGATORY SUMMARY TABLE}
Derogatory Items
{NUMBER OF DEROGATORY ITEMS}
Delinquent or derogatory items
	
Recent late payments, collections, and other derogatory items within the last 6 months will hurt your credit score more than older inactive accounts. Accounts within the last 24 months carry the second most weight. It is crucial to pay all bills on time and never miss payments.
{DEROGATORY ITEMS LIST}
{PAGE BREAK}

Public Records
{PUBLIC RECORD COUNT}
Public Records
	
Public records include details of court records, bankruptcy filings, tax liens and monetary judgments. These generally remain on your Credit Report for 7 to 10 years.
{PUBLIC RECORD TABLE}
Inquiries
{NUMBER OF INQUIRIES}
Inquiries
	
Each time you apply for credit it lowers your score. For that reason we ask during credit repair that you do not apply for anything.
{INQUIRIES TABLE}
{PAGE BREAK}

We Are Experts In Disputing The Errors On Your Report That Lower Your Score.
While we cannot promise to remove all of the negative items on your report, we do know how to use the law in your favor and we have an awesome track record.
Our Plan Of Action
The credit system is flawed, and nearly 80% of all reports have errors that can lower your score. But you have rights and we know how to use them to your benefit! The law gives you the right to dispute any item on your credit reports. And if those items cannot be verified, they must be removed. So we will write many letters to the bureaus. If they can't prove it, they must remove it! And we are very good at this!
We Provide Document Preparation And Credit Education
We will be drafting many letters on your behalf to credit bureaus and creditors, to challenge the items you wish us to challenge. Along the way, we will also guide you how to better manage your credit -- so you can keep your awesome credit long after our work is done.

Your Part In The Process
Your Next Steps
	Log Into Your Secure Client Portal. We will email you the login details.
	Watch our 2-minute video.
	Provide a copy of your Photo ID and a copy of the top section of a recent utility bill (or an insurance statement or some other bill) as proof of your current address to include with our letters to the credit bureaus. Take a picture of these on your phone and upload them to us in your client portal.
{PAGE BREAK}
How You Can Speed Up The Process
	Stop applying for credit (each time you do it lowers your scores)
	Do not close any accounts (this also lowers your score)
	Pay your credit cards down to below 30% of the available credit line. This will make a huge positive impact on your credit score.
	Never spend more than 30% of the available credit line, even if you pay the balance off in full each month.
	Pay your bills on time! One missed payment will lower your score dramatically and undo all the work we are doing.
	Keep your credit monitoring account active throughout the credit repair process, so we can see the changes to your accounts and scores. Your score will never suffer if you're ordering your own reports. Be sure to let us know your login details to the credit monitoring account. You can add those in your client portal.
	Most importantly, We'll be sending many letters to the bureaus. Be sure to open all of your mail and forward the replies here to us. This can be as simple as taking a photo with your phone and uploading it to your portal (or attaching to an email).

This Process Takes Time
Remember, it has taken you years to get your credit into its current state, so cleaning it up will not happen overnight. We cannot dispute everything all at once, or the credit bureaus will reject the disputes by marking them as "frivolous," so we must do this carefully and strategically. It takes 30 to 45 days for bureaus and creditors to respond to each letter, and even more time for changes to reflect on your reports. A difficult item may take multiple letters to multiple parties, so patience is key. Thanks to technology (and by logging into our client portal), you'll receive real-time updates of the work we're doing every step of the way.

By following our program and our advice, your credit will improve - and along the way, we'll teach you how to maintain your excellent credit long after our work is done.

{PAGE BREAK}
So Let's Get Started!
How do we do that? Just reach out to us, so we can complete your signup process and activate your client portal access (if we haven't already).


Throughout this process, our contact information is always on our website and in our emails. You can also send us secure messages in your portal. We want to hear from you and we are eager to help. Once the credit repair process has begun we will also be sending you progress reports and updates every step of the way.

We appreciate that you choose us. We look forward to working with you to improve your credit and your financial future!

Email: {COMPANY EMAIL}
Website: {COMPANY WEBSITE}
`;
console.log(data);
    tinymce.get('audit_textarea').setContent(data);
});

            $('#add_audit_modal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            })

            function add_new_team_members() {
                window.location.href = "<?php echo base_url() ?>new-team";
            }

            function validate_company() {
                var company_name = $('#company_name').val();
            }


            function closeSuccessModal() {
                $('#pDsuccess').css('display', 'none');
                $('#pDMsuccess').css('display', 'none');

            }

            $('#add_audit').on('click', function() {
                $('#aduit_submit').text('Add Template');
                $('#audit_name').val('');
                 $('#myModalLabels').text('Add New Simple Audit Template');
                $('#add_audit_modal').modal('show');
            });


            $('#view_placeholder').on('click', function() {
                if ($('#placeholders').hasClass('active_p')) {
                    $('#placeholders').css('display', 'none');
                    $('#placeholders').removeClass('active_p');
                } else {
                    $('#placeholders').css('display', 'block');
                    $('#placeholders').addClass('active_p');
                }
            });

            function add_edit_audit_template() {
                console.log('add');
                let template_id = $('#template_id').val();
                let edit_template = $('#edit_template').val();
                let audit_name = $('#audit_name').val();
                let include_page_number = $('#include_page_number').is(':checked') ? '1' : '0';
                let default_audit = $('#default_audit').is(':checked') ? '1' : '0';
                let audit_textarea = tinymce.get('audit_textarea').getContent();
console.log(audit_textarea);
                let isValid = true;

                if (audit_name == "") {
                    $('#audit_name').addClass('is-invalid');
                    $('#audit_name').after('<div class="invalid-feedback"><strong>Audit Name is required.</strong></div>');
                    isValid = false;
                }

                if (!isValid) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please provide all mandatory fields!',
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    });
                    return false;
                } else {
                    $('#loader').show();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('add_edit_audit_template'); ?>',
                        data: {
                            'template_id': template_id,
                            'edit_template': edit_template,
                            'audit_name': audit_name,
                            'include_page_number': include_page_number,
                            'default_audit': default_audit,
                            'audit_textarea': audit_textarea

                        },
                        success: function(response) {
                            var data = JSON.parse(response);

                            if (data.success) {
                                $('#loader').hide();

                                setTimeout(function() {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Continue'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#add_audit_modal').modal('hide');
                                            localStorage.setItem('activeTab', '#simple_audit_section');
                                            location.reload();
                                        }
                                    });
                                }, 2000);
                            } else {
                                $('#loader').hide();
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to submit form',
                                    icon: 'error',
                                    confirmButtonText: 'Retry'
                                });
                            }
                        },
                        error: function() {
                            $('#loader').hide();
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while processing your request.',
                                icon: 'error',
                                confirmButtonText: 'Retry'
                            });
                        }
                    });
                }
            }


            // function editAuditTemplate(template_id, audit_name, audit_textarea) {
            //     $('#aduit_submit').text('Update Template');
            //     $('#template_id').val(template_id);
            //     $('#edit_template').val(1);
            //     $('#audit_name').val(audit_name);
            //     tinymce.get('audit_textarea').setContent(audit_textarea);
            //     $('#add_audit_modal').modal('show');
            // }

            function editAuditTemplate(element) {
                console.log('edit');
                   $('#myModalLabels').text('Edit Simple Audit Template');
                var template_id = $(element).data('id');
                var audit_name = $(element).data('name');
                var audit_textarea = $(element).data('text');
  var default_audit = $(element).data('default_audit');
    var include_page_number = $(element).data('include_page_number');
    $('#aduit_submit').show();
                $('#aduit_submit').text('Update Template');
                $('#template_id').val(template_id);
                $('#edit_template').val(1);
                $('#audit_name').val(audit_name);
             $('#default_audit').prop('checked');
                  $('#include_page_number').prop('checked', include_page_number === '1');
                tinymce.get('audit_textarea').setContent(audit_textarea);
                $('#add_audit_modal').modal('show');
                
            }

            function delete_audit_template(audit_id) {

                let id = audit_id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('#loader').show();

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url('delete_audit_template'); ?>',
                            data: {
                                'id': id,

                            },
                            success: function(response) {
                                var data = JSON.parse(response);

                                if (data.success) {
                                    $('#loader').hide();
                                    Swal.fire({
                                        title: 'Success!',
                                        text: "Template deleted successfully!",
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Continue'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            localStorage.setItem('activeTab', '#simple_audit_section');
                                            location.reload();
                                        }
                                    });
                                } else {
                                    $('#loader').hide();
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Failed to delete template',
                                        icon: 'error',
                                        confirmButtonText: 'Retry'
                                    });
                                }
                            },
                            error: function() {
                                $('#loader').hide();
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred while processing your request.',
                                    icon: 'error',
                                    confirmButtonText: 'Retry'
                                });
                            }
                        });
                    }
                });
            }

            $(document).ready(function() {
                var activeTab = localStorage.getItem('activeTab');

                if (activeTab) {
                    $('.nav-link[href="' + activeTab + '"]').tab('show');
                    localStorage.removeItem('activeTab');
                } else {
                    $('.nav-link[href="#profile-2"]').tab('show');
                }
            });
            
            
            function viewAuditTemplate(element) {
                var template_id = $(element).data('id');
                var audit_name = $(element).data('name');
                var audit_textarea = $(element).data('text');

                $('#aduit_submit').hide();
                $('#template_id').val(template_id);
                // $('#edit_template').val(1);
                $('#audit_name').val(audit_name);
                tinymce.get('audit_textareas').setContent(audit_textarea);
$('.tox-editor-header').hide(); // jQuery ka use karke toolbar hide karna

                $('#view_audit_modal').modal('show');
            }
        </script>
        <script>
    function deleteEmployee(id) {
        if (confirm("Are you sure you want to delete this employee?")) {
            // Make an AJAX request to delete the employee
            fetch('<?php echo base_url(); ?>delete-employee/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Employee deleted successfully');
                    location.reload(); // Refresh page
                } else {
                    alert('Failed to delete employee');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
            });
        }
    }
</script>
