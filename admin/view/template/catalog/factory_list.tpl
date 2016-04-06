<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-information').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> 工厂列表</h3>
      </div>
      <div class="panel-body">
          <div class="well">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-name">工厂名字</label>
                  <input type="text" name="filter_factory_name" value="<?php echo $filter_factory_name; ?>" placeholder="工厂名字" id="input-name" class="form-control" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-status">省</label>
                  <select name="filter_province_code" id="select-province-code" class="form-control">
                    <option value="">全部</option>
                    <?php foreach($areas as $area) { ?>
                    <?php if ($filter_province_code == $area['area_code']) { ?>
                    <option value="<?php echo $area['area_code'];?>" selected="selected"><?php echo $area['area_name'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $area['area_code'];?>"><?php echo $area['area_name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group hidden">
                  <label class="control-label" for="input-status">地区</label>
                  <select name="filter_china_area_id" id="select-china-area-id" class="form-control">
                    <option value="">全部</option>
                    <?php foreach($china_areas as $area) { ?>
                    <?php if ($filter_china_area_id == $area['china_area_id']) { ?>
                    <option value="<?php echo $area['china_area_id'];?>" selected="selected"><?php echo $area['china_area_name'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $area['china_area_id'];?>"><?php echo $area['china_area_name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> 查询</button>
              </div>
            </div>
          </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                <td class="text-left"><?php if ($sort == 'id.title') { ?>
                  <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_title; ?>">工厂名字</a>
                  <?php } ?></td>
                <td class="text-left">省</td>
                <td class="text-left">地名</td>
                <td class="text-right"><?php if ($sort == 'i.sort_order') { ?>
                  <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                  <?php } ?></td>
                <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
              </thead>
              <tbody>
              <?php if ($factories) { ?>
              <?php foreach ($factories as $factory) { ?>
              <tr>
                <td class="text-center"><?php if (in_array($factory['factory_id'], $selected)) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $factory['factory_id']; ?>" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $factory['factory_id']; ?>" />
                  <?php } ?></td>
                <td class="text-left"><?php echo $factory['factory_name']; ?></td>
                <td class="text-left"><?php echo $factory['province_name']; ?></td>
                <td class="text-left"><?php echo $factory['area_name']; ?></td>
                <td class="text-right"><?php echo $factory['sort_order']; ?></td>
                <td class="text-right"><a href="<?php echo $factory['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $('#button-filter').on('click', function() {
      var url = 'index.php?route=catalog/factory&token=<?php echo $token; ?>';

      var filter_factory_name = $('input[name=\'filter_factory_name\']').val();

      if (filter_factory_name) {
        url += '&filter_factory_name=' + encodeURIComponent(filter_factory_name);
      }

      var filter_province_code = $('#select-province-code').val();

      if (filter_province_code) {
        url += '&filter_province_code=' + encodeURIComponent(filter_province_code);
      }

      var filter_china_area_id = $('#select-china-area-id').val();

      if (filter_china_area_id) {
        url += '&filter_china_area_id=' + encodeURIComponent(filter_china_area_id);
      }

      location = url;
    });
    //--></script>
</div>
<?php echo $footer; ?>