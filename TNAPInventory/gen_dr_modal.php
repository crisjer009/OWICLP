<div class="modal fade" id="gen_dr_modal">
  <div class="modal-dialog modal-lg">
  <form method="post" name="gen_dr_form" id="gen_dr_form" enctype="multipart/form-data">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update SKU</h4>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row text-center">      
         <div class="col-md-4">
         <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">COF #:</span>
                  </div>
                  <input type="text" class="form-control" name="consign_tag" id="consign_tag" readonly>
                </div>  
         </div>
         <div class="col-md-4">
         <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">OWI ALU:</span>
                  </div>
                  <input type="text" class="form-control" name="form_sku" id="form_sku" readonly>
                </div> 

         </div>
         <div class="col-md-4">
         <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Current Quantity:</span>
                  </div>
                  <input type="text" class="form-control" name="consign_qty" id="consign_qty" readonly >
                </div>   

         </div>
          <div class="col-md-6">
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Operation:</span>
                  </div>
                  <select class="form-select form-control" id="slct_ops" name="slct_ops">
                  <option selected disabled>Select</option>
                  <option value="1">Add</option>
                  <option value="2">Deduct</option>

                  </select>
                </div> 

          </div>
          <div class="col-md-6 scdcol">
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="cs_edit_title"></span>
                  </div>
                  <input type="text" class="form-control" name="cs_edit_val" id="cs_edit_val" >
                </div>   
          </div>
          <div class="col-md-12 scdcol">
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Adjustment Quantity</span>
                  </div>
                  <input type="text" class="form-control" name="cs_new_val" id="cs_new_val" readonly >
                </div>   
          </div>

       
               <!-- user id -->

               <!-- action -->
               <!-- <input type="hidden" name="action" id="action" value="edit" > -->
               <!-- operation -->
               <input type="hidden" name="operation" id="operation" value="Gen_Edit" >
               <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" >
               <input type="hidden" name="genMod_branch_id" id="genMod_branch_id"  readonly >


           </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Close
        </button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <input type="submit" name="action" id="action" class="btn btn-success btnmodalres" value="Save" />   

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
