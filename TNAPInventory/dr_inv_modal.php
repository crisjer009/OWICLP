
<div class="modal fade" id="dr_inv_modal">
  <div class="modal-dialog modal-lg" style="width: fit-content;">
  <form method="post" id="dr_inv_form" enctype="multipart/form-data">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id= "h_owi_desc"></h4>
        <!-- <span>60</span> -->
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
        
  
      <div class="col-md-12 col-sm-6 col-12 divBrnchCd">



<div class="col-md-12 "><input type="hidden" class="form-control" name="form_sku" id="form_sku" readonly></div>

</div>
                <div class="col-md-12">
                


</div>
            <div class="col-md-12">
                <p>Quantity Delivered Per Store</p>
            </div>
 <table class="table table-striped table-valign-middle" id="break_table">
 <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">Total:</th>
                <th></th>
            </tr>
        </tfoot>


 </table>



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
