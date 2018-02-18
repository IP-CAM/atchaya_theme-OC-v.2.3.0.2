<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <div class="tab-pane1" id="tab-image">
              <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $grid_image; ?></td>
                      <td class="text-right"><?php echo $grid_name; ?></td>
                      <td class="text-right"><?php echo $grid_description; ?></td>
                      <td class="text-center"><?php echo $grid_sortorder; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $image_row = 0; ?>
                    <?php foreach ($gallery_data as $gallery_datas) { ?>
                    <tr id="image-row<?php echo $image_row; ?>">
                      <td class="text-left">
                      	<a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                        	<img width="100" height="50" src="<?php echo HTTPS_CATALOG.'image/'.$gallery_datas['gallery_image']; ?>" alt="" title="" data-placeholder="" />
                       	</a>
                        <input type="hidden" name="gallery_datas[<?php echo $image_row; ?>][image]" value="<?php echo $gallery_datas['gallery_image']; ?>" id="input-image<?php echo $image_row; ?>" />
                      </td>
                      <td class="text-right">
                        <input type="hidden" name="gallery_datas[<?php echo $image_row; ?>][id]" value="<?php echo $gallery_datas['id']; ?>">
                        <input type="text" name="gallery_datas[<?php echo $image_row; ?>][name]" value="<?php echo $gallery_datas['name']; ?>" placeholder="" class="form-control" />
                      </td>
                      <td class="text-right">
                        <textarea class="form-control" name="gallery_datas[<?php echo $image_row; ?>][description]"><?php echo $gallery_datas['description']; ?></textarea>
                      </td>
                      <td class="text-center">
                      	<input type="text" name="gallery_datas[<?php echo $image_row; ?>][sort_order]" value="<?php echo $gallery_datas['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />
                      </td>
                      <td class="text-left">
                      	<button type="button" onclick="return removerow('<?php echo $image_row; ?>','<?php echo $gallery_datas['id']; ?>')" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                      </td>
                    </tr>
                    <?php $image_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function removerow(id,deleteid)
  {
    var result = confirm("Are you sure you want to delete");
    if(result)
    {
      $.ajax({
        url: 'index.php?route=extension/module/gallery/ajaxrequest&token=<?php echo $token; ?>',
        type: 'post',
        data: {deleteid:deleteid},
        success: function(data) {
          $('#image-row'+id).remove();
        },
      });
    }
  }
var image_row = <?php echo $image_row; ?>;
  function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="" alt="" title="" data-placeholder="" /></a><input type="hidden" name="gallery_data[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="hidden" name="gallery_data[<?php echo $image_row; ?>][id]" value=""><input type="text" name="gallery_data[' + image_row + '][name]" value="" placeholder="" class="form-control" /></td>';
  html += '  <td class="text-right"><textarea class="form-control" name="gallery_data[<?php echo $image_row; ?>][description]"></textarea></td>';
  html += '  <td class="text-center"><input type="text" name="gallery_data[' + image_row + '][sort_order]" value="" placeholder="" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#images tbody').append(html);

  image_row++;
}
 </script>

<?php echo $footer; ?>