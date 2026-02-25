<div class="modal fade" id="acct_addSL_modal">
  <div class="modal-dialog modal-lg">
  <form method="post" id="sku_form" enctype="multipart/form-data">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">ADD SALES</h4>
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
      <div class="row text-center border border-secondary ">                 
  <div class="col-md-12">
  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">OWI DESC:</span>
                  </div>
                  <input type="text" class="form-control" name="owi_desc" id="owi_desc" readonly>
                </div>   
  </div>
  <div class="col-md-6">
  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">SKU:</span>
                  </div>
                  <input type="text" class="form-control" name="form_sku" id="form_sku" readonly>
                </div>   

  </div>

  <div class="col-md-6">

  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">PG UPC:</span>
                  </div>
                  <input type="text" class="form-control" name="pg_upc" id="pg_upc" readonly>
                </div> 

  </div>
<div class="col-md-12">

<div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">UNIT PRICE:</span>
                  </div>
                  <input type="text" class="form-control" name="sku_price" id="sku_price" readonly>
                </div>   

</div>
<div class="col-md-12">
  <hr>
</div>
<div class="col-md-6">

<div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">PRODUCT QUANTITY TO BE ADD:</span>
                </div>
                <input type="text" class="form-control" name="pd_add" id="pd_add" >
      

              </div> 

</div>

                
               <!-- user id -->
               <input type="hidden"  name="sls_price" id="sls_price" >
               <input type="hidden"  name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'];?>" >
               <!-- date updated -->
               <input type="hidden" name="date_updated" id="date_updated" value="<?php echo date('Y-m-d H:i:s');?>" >
               <!-- action -->
               <!-- <input type="hidden" name="action" id="action" value="edit" > -->
               <!-- operation -->
               <input type="hidden" name="operation" id="operation" value="add_sales" >

           </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Close
        </button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <input type="submit" name="action" id="action" class="btn btn-success" value="Save" />   

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
