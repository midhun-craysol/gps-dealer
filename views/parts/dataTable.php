<script>
  pageName ="<?php echo(isset($pageName)? $pageName :''); ?>";  
</script>

<h6 class="mb-0 text-uppercase"><?php echo(isset($pageTitle)? $pageTitle :''); ?></h6>

<?php 
		if(isset($popupBtnTarget)){
			echo '<button type="button" id="'.$popupBtnTarget.'" class="tbBtn btn btn-sm btn-primary" >+</button>';
		} 
	?>
	<a class="reloadDatatable btn btn-sm" title="Refresh" href="#" data-target="<?php echo(isset($dataTable["Id"])? $dataTable["Id"] :''); ?>" >
            <i class="bi-arrow-clockwise"></i>
	</a>
<hr/>
<div class="card">
	<div class="card-body">
		<?php if(isset($dataTable) && !empty($dataTable)) { ?>
		<div class="table-responsive">
			<table id="<?php echo(isset($dataTable["Id"])? $dataTable["Id"] :''); ?>" class="table table-striped  table-bordered table-hover table-sm" style="width:100%">
				<thead>
					<tr>
					<?php if(!empty($dataTable["fields"])) { 
						foreach ($dataTable["fields"] as $field){
					?>
						<th  <?php echo( (isset($field["width"]) && $field["width"] !="")? "width='".$field["width"]."' " :''); ?>  ><?php echo($field["th"]); ?></th>
					<?php }
					}
					?>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	<?php } ?>
	</div>
</div>
<script>
      
        $( document ).ready(function() {
            $(".reloadDatatable").on("click",function(){ 
              var url=$(".reloadDatatable").data("target");
                $('.bi-arrow-clockwise').addClass('bi-browser-edge');
                setTimeout(function(){
                    var table = $("#"+url).DataTable();
                    table.ajax.reload();
                    $('.bi-arrow-clockwise').removeClass('bi-browser-edge');
                }, 1010);
  
            });
        });
  
</script>