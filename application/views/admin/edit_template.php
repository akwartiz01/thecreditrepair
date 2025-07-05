 <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

 <!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>-->

 <script>
   tinymce.init({
     selector: 'textarea',
     plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
   });
 </script>

 <style>
   .mce-notification {
     display: none;
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


   #content_ifr * {
     font-size: 14px !important;
     font-family: Calibri, sans-serif !important;
   }
   #mce_0_ifr * {
     font-size: 14px !important;
     font-family: Calibri, sans-serif !important;
   }
 </style>
 <!-- partial -->
 <div class="container-fluid page-body-wrapper">
   <div class="main-panel pnel">
     <div class="content-wrapper" style="width: 60%;">
       <div class="page-header">
         <h3 class="page-title"> Add New Template </h3>
         <nav aria-label="breadcrumb">
           <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="#">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">Add New Template</li>
           </ol>
         </nav>
       </div>
       <div class="card">
         <div class="card-body">
           <form class="form-sample" method="POST">
             <div class="row">
               <div class="col-md-8">
                 <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Category*</label>
                   <div class="col-sm-9">
                     <select class="form-control" name="category" required>
                       <?php foreach ($templates_category as $category) {
                          if ($templates->category == $category->id) {
                        ?>
                           <option value="<?php echo $category->id; ?>" selected><?php echo $category->category_name; ?></option>
                         <?php  } else { ?>

                           <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
                       <?php }
                        } ?>
                     </select>

                   </div>
                 </div>
               </div>
             </div>

             <div class="row">
               <div class="col-md-8">
                 <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Status</label>
                   <div class="col-sm-4">
                     <div class="form-check">
                       <label class="form-check-label">
                         <input type="radio" class="form-check-input" name="status" value="1" <?php if ($templates->status == 1) {
                                                                                                echo "checked";
                                                                                              } ?>> Active <i class="input-helper"></i></label>
                     </div>
                   </div>
                   <div class="col-sm-5">
                     <div class="form-check">
                       <label class="form-check-label">
                         <input type="radio" class="form-check-input" name="status" value="0" <?php if ($templates->status == 0) {
                                                                                                echo "checked";
                                                                                              } ?>> Inactive <i class="input-helper"></i></label>
                     </div>
                   </div>
                 </div>
               </div>

             </div>

             <div class="row">
               <div class="col-md-12">
                 <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Letter title*</label>
                   <div class="col-sm-10">
                     <input type="text" class="form-control" name="letter_title" value="<?php echo $templates->letter_title; ?>" required>
                     <input type="hidden" name="id" value="<?php echo $templates->id; ?>">
                   </div>
                 </div>
               </div>
             </div>

             <div class="row" id="printthissec">
               <div class="col-md-12">
                 <div class="form-group row" style="padding: 10px 20px;">
                   <textarea cols="30" rows="20" name="content"><?php echo $templates->content; ?></textarea>
                 </div>
               </div>
             </div>

             <div class="row mb-4">

               <div class="col-md-12">

                 <button type="submit" class="btn btn-gradient-primary btn-icon-text" id="btn_letter" name="btn_letter">
                   Submit </button>
                 <button type="button" class="btn btn-success print_button">Print</button>
               </div>

             </div>
           </form>

           <div class="row placeholder_section">
             <legend>Placeholder name:</legend>
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
       </div>
     </div>
     <script type="text/javascript">
       $("body").on("click", ".print_button", function() {

        //  var x = document.getElementById("content_ifr");
         var x = document.getElementById("mce_0_ifr");
         var y = x.contentWindow.document;
         y.body.style.fontFamily = "Calibri, sans-serif";
         y.body.style.fontSize = "18px";


        //  document.getElementById('content_ifr').contentWindow.print();
         document.getElementById('mce_0_ifr').contentWindow.print();

         // var prtContent = document.getElementById("printthissec");
         // var style = document.getElementById("sqhead");
         // var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=570,toolbar=0,scrollbars=0,status=0');

         // WinPrint.document.write(style.innerHTML+'<style>#ptbtn{display:none !important;}#clbtn{display:none !important;} #cltbtn{display:none !important;}</style> '+prtContent.innerHTML);
         // WinPrint.document.close();
         // WinPrint.focus();
         // WinPrint.print();
         // WinPrint.onafterprint = function(){
         //    WinPrint.close();
         // }
       });
     </script>
<!-- 
     <script type="text/javascript">
       document.addEventListener("DOMContentLoaded", function() {
         $("body").on("click", ".print_button", function() {
           var iframe = document.getElementById("mce_0_ifr");

           if (iframe) {
             var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

             if (iframeDoc) {
               iframeDoc.body.style.fontFamily = "Calibri, sans-serif";
               iframeDoc.body.style.fontSize = "18px";

               iframe.contentWindow.print();
             } else {
               console.error("Cannot access the iframe document.");
             }
           } else {
             console.error("Iframe with ID 'mce_0_ifr' not found.");
           }
         });
       });
     </script> -->